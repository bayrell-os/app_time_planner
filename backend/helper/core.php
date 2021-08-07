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

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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
function addRoute($class_name, $file_name = "")
{
	if ($file_name != "")
	{
		require_once $file_name;
	}

	$router = app()->get(RouteCollector::class);
	$obj = new $class_name();
	$obj->routes($router);
	app()->get("routes_list")->add($class_name);
}



/**
 * Add console command
 */
function addModel($class_name)
{
	app()->get("models_list")->add($class_name);
}



/**
 * Add console command
 */
function addConsoleCommand($class_name)
{
	app()->get("console_class_list")->add($class_name);
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
		// ... 404 Not Found
		case FastRoute\Dispatcher::NOT_FOUND:

			( new \ApiResult() )
				->error( "404 Not Found", -1 )
				->getResponse()
				->setStatusCode(Response::HTTP_NOT_FOUND)
				->send()
			;

			break;

		// ... 405 Method Not Allowed
		case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
			$allowedMethods = $routeInfo[1];

			( new \ApiResult() )
				->error( "405 Method Not Allowed", -1 )
				->getResponse()
				->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED)
				->send()
			;

			break;

		// Found method
		case FastRoute\Dispatcher::FOUND:
			$handler = $routeInfo[1];
			$vars = $routeInfo[2];

			$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
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
 * Dynamic load class from namespace app
 */
function appLoadClass($name)
{
	$arr = explode("\\", $name);
	$prefix = "app";

	if (count($arr) == 0) return;
	if ($arr[0] != "App") return;
	if ($arr[0] == "App") $prefix = "app";
	$arr = array_slice($arr, 1);
	$file_name = array_pop($arr) . ".php";
	$dir_name = implode(DIRECTORY_SEPARATOR, $arr);
	$file_path = dirname(__DIR__) . DIRECTORY_SEPARATOR .
		$prefix . DIRECTORY_SEPARATOR .	
		$dir_name . DIRECTORY_SEPARATOR .
		$file_name;
	if (file_exists($file_path) && is_file($file_path))
	{
		require_once $file_path;
	}
}
spl_autoload_register('appLoadClass');


/**
 * Api Result
 */
class ApiResult
{
	var $data = null;
	var $error_code = 0;
	var $error_name = "";
	var $error_str = "";
	var $status_code = Response::HTTP_OK;


	
	/**
	 * Success
	 */
	function success($data)
	{
		$this->data = $data;
		$this->clearError();
		$this->error_code = 1;
		return $this;
	}



	/**
	 * Error
	 */
	function error($error_str = "", $error_code = -1)
	{
		$this->clearError();
		$this->error_str = $error_str;
		$this->error_code = $error_code;
		return $this;
	}



	/**
	 * Exception
	 */
	function exception($e)
	{
		$this->clearError();
		$this->error_str = $e->getMessage();
		$this->error_code = $e->getErrorCode();
		$this->error_name = get_class($e);
		$this->status_code = Response::HTTP_INTERNAL_SERVER_ERROR;
		return $this;
	}



	/**
	 * Clear error
	 */
	function clearError()
	{
		$this->error_code = 0;
		$this->error_name = "";
		$this->error_str = "";
		return $this;
	}



	/**
	 * Returns response
	 */
	function getResponse()
	{
		$res =
		[
			"data" => $this->data,
			"error" =>
			[
				"code" => $this->error_code,
				"name" => $this->error_name,
				"str" => $this->error_str,
			],
		];
		return new Response(
			json_encode($res),
			$this->status_code,
			['content-type' => 'application/json']
		);
	}
}


/**
 * Class list
 */
class ListContainer
{
	var $arr = [];
	function add($item)
	{
		$this->arr[] = $item;
	}
}