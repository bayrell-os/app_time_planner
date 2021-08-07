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

namespace Helper;

use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class App
{
	var $routes = [];
	var $models = [];
	var $commands = [];

	
	/**
	 * Get instance
	 */
	function get($name)
	{
		return Core::$di_container->get($name);
	}



	/**
	 * Init
	 */
	function init()
	{
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
		$this->routes[] = $class_name;
	}



	/**
	 * Add console command
	 */
	function addModel($class_name)
	{
		$this->models[] = $class_name;
	}



	/**
	 * Add console command
	 */
	function addConsoleCommand($class_name)
	{
		$this->commands[] = $class_name;
	}



	/**
	 * Method not found
	 */
	function methodNotFound($routeInfo)
	{
		( new \ApiResult() )
			->error( "404 Not Found", -1 )
			->getResponse()
			->setStatusCode(Response::HTTP_NOT_FOUND)
			->send()
		;
	}



	/**
	 * Method not allowed
	 */
	function methodNotAllowed($routeInfo)
	{
		( new \ApiResult() )
			->error( "405 Method Not Allowed", -1 )
			->getResponse()
			->setStatusCode(Response::HTTP_METHOD_NOT_ALLOWED)
			->send()
		;
	}



	/**
	 * Method found
	 */
	function methodFound($routeInfo)
	{
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
	}



	/**
	 * Run dispatcher
	 */
	function dispatchUri($method, $uri)
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
			case \FastRoute\Dispatcher::NOT_FOUND:
				$this->methodNotFound($routeInfo);
				break;

			// ... 405 Method Not Allowed
			case \FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
				$this->methodNotAllowed($routeInfo);				
				break;

			// Found method
			case \FastRoute\Dispatcher::FOUND:
				$this->methodFound($routeInfo);
				break;
		}
		
	}



	/**
	 * Web app run
	 */
	function run()
	{
		/* Fetch method and URI from somewhere */
		$method = $_SERVER['REQUEST_METHOD'];
		$uri = $_SERVER['REQUEST_URI'];

		/* Remove api */
		$uri = preg_replace("/^\/api/", "", $uri);
		$_SERVER['REQUEST_URI'] = $uri;

		$this->dispatchUri($method, $uri);
	}



	/**
	 * Console app created
	 */
	function consoleAppCreated($app)
	{
		return $app;
	}



	/**
	 * Create console app
	 */
	function createConsoleApp()
	{
		$app = new \Symfony\Component\Console\Application();
		
		/* Register console commands */
		$console_class_list = app()->get("console_class_list");
		foreach ($console_class_list->arr as $class_name)
		{
			$console->add( new $class_name() );
		}

		$app = $this->consoleAppCreated($app);

		return $app;
	}
}
