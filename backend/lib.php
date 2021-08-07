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
function container()
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

	$router = container()->get(RouteCollector::class);
	$obj = new $class_name();
	$obj->routes($router);
}


/**
 * Dispatch uri
 */
function dispatch_uri($method, $uri)
{
	/* Create dispatcher */
	$route_collector = container()->get(RouteCollector::class);
	$dispatcher = container()->get(Dispatcher::class);

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

			if ($handler instanceof \Closure)
			{
				$handler($vars);
			}
			else if (is_array( $handler ))
			{
				$obj = $handler[0];
				if (is_object($obj))
				{
					$obj->request_before($vars);
				}
				call_user_func_array($handler, [$vars]);
				if (is_object($obj))
				{
					$obj->request_after($vars);
				}
			}

			break;
	}
}