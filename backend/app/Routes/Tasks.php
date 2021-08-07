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

namespace App\Routes;

use \FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Tasks
{

	/**
	 * Declare routes
	 */
	function routes(RouteCollector $routes)
	{
		// Tasks list
		$routes->addRoute('GET', '/tasks/', [$this, "getTasks"]);
		$routes->addRoute('GET', '/tasks/{id:\d+}/', [$this, "getTaskById"]);
	}


	/**
	 * Request before
	 */
	function request_before(Request $request, ?Response $response, $vars)
	{
		return [$request, $response, $vars];
	}


	/**
	 * Request after
	 */
	function request_after(Request $request, ?Response $response, $vars)
	{
		return [$request, $response, $vars];
	}


	/**
	 * Get users
	 */
	function getTasks(Request $request, ?Response $response, $vars)
	{
		$users = \App\Models\Task::all();

		$keys =
		[
			"id", "name", "gmdate", "status"
		];
		$rows = array_map( object_intersect_curry($keys), $users->all() );

		$result = ( new \ApiResult() )
			->success( $rows )
		;

		return [
			$request, 
			$result->getResponse(), 
			$vars
	];
	}


	/**
	 * Get task by id
	 */
	function getTaskById(Request $request, ?Response $response, $vars)
	{
		$response = new Response(
			'User id = ' . $vars["id"],
			Response::HTTP_OK,
			['content-type' => 'text/html']
		);
		return [$request, $response, $vars];
	}
}
