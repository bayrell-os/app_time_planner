<?php

/*!
 *  Bayrell Time Planner
 *
 *  (c) Copyright 2020 - 2021 "Ildar Bikmamatov" <support@bayrell.org>
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *      https://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */

use \FastRoute\RouteCollector;
use \FastRoute\Dispatcher;


/* Global container */
global $di_container;


/**
 * Returns current container
 */
function app()
{
	global $di_container;
	return $di_container;
}


/**
 * Build container
 */
function build_container($defs)
{
	global $di_container;
	$container_builder = new DI\ContainerBuilder();
	$container_builder->addDefinitions($defs);
	$di_container = $container_builder->build();
}


/**
 * Add routes from class
 */
function addRoutesFromClass($class_name, $file_name = "")
{
	if ($file_name != "")
	{
		require_once $file_name;
	}

	$router = app()->get(RouteCollector::class);
	$obj = new $class_name();
	$obj->routes($router);
}


/**
 * Dispatch uri
 */
function dispatch_uri($method, $uri)
{
	/* Create dispatcher */
	$route_collector = app()->get(RouteCollector::class);
	$dispatcher = app()->get(Dispatcher::class);

	/* Strip query string (?foo=bar) and decode URI */
	if (false !== $pos = strpos($uri, '?'))
	{
		$uri = substr($uri, 0, $pos);
	}
	$uri = rawurldecode($uri);

	/* Dispatch page */
	$routeInfo = $dispatcher->dispatch($method, $uri);
	switch ($routeInfo[0])
	{
		case FastRoute\Dispatcher::NOT_FOUND:
			// ... 404 Not Found
			break;

		case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
			$allowedMethods = $routeInfo[1];
			// ... 405 Method Not Allowed
			break;

		case FastRoute\Dispatcher::FOUND:
			$handler = $routeInfo[1];
			$vars = $routeInfo[2];

			$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
			//$request = new Slim\Psr7\Request();
			$response = null;

			if ($handler instanceof \Closure)
			{
				$handler($vars);
			}
			else if (is_array( $handler ))
			{
				$obj = $handler[0];
				if (is_object($obj))
				{
					list($request, $response, $vars) =
						$obj->request_before($request, $response, $vars);
				}
				if ($response == null)
				{
					list($request, $response, $vars) = call_user_func_array
					(
						$handler,
						[$request, $response, $vars]
					);
				}
				if (is_object($obj))
				{
					list($request, $response, $vars) =
						$obj->request_after($request, $response, $vars);
				}
			}
			
			if ($response != null)
			{
				$response->send();
			}

			break;
	}
}


/**
 * Load class from namespace app
 */
function appLoadClass($name)
{
	$arr = explode("\\", $name);
	
	if (count($arr) == 0) return;
	if ($arr[0] != "App") return;
	$arr = array_slice($arr, 1);
	$file_name = array_pop($arr) . ".php";
	$dir_name = implode(DIRECTORY_SEPARATOR, $arr);
	$file_path = dirname(__DIR__) . DIRECTORY_SEPARATOR .
		$dir_name . DIRECTORY_SEPARATOR .
		$file_name;
	if (file_exists($file_path) && is_file($file_path))
	{
		require_once $file_path;
	}
}
spl_autoload_register('appLoadClass');


/**
 * Intersect object
 */
function object_intersect($item, $keys)
{
	$res = [];
	foreach ($item as $key => $val)
	{
		if (in_array($key, $keys))
		{
			$res[$key] = $val;
		}
	}
	return $res;
}


/**
 * Intersect object
 */
function object_intersect_curry($keys)
{
	return function ($item) use ($keys)
	{
		$res = [];
		foreach ($item as $key => $val)
		{
			if (in_array($key, $keys))
			{
				$res[$key] = $val;
			}
		}
		return $res;
	};
}
