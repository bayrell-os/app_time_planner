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


class Users
{

	/**
	 * Declare routes
	 */
	function routes(RouteCollector $routes)
	{
		// Users list
		$routes->addRoute('GET', '/users/', [$this, "getUsers"]);
		$routes->addRoute('GET', '/user/{id:\d+}/', [$this, "getUserById"]);
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
	function getUsers(Request $request, ?Response $response, $vars)
	{
		$db = app()->get("db");

		$st = $db->query(
			"select * from task"
		);
		$rows = $st->fetchAll(\PDO::FETCH_ASSOC);
		$st->closeCursor();

		$keys =
		[
			"id", "name", "gmdate", "status"
		];
		$rows = array_map( object_intersect_curry($keys), $rows );

		$res =
		[
			"items" => $rows,
			"error" =>
			[
				"str" => "",
				"code" => 1,
			],
		];

		$response = new Response(
			json_encode($res),
			Response::HTTP_OK,
			['content-type' => 'application/json']
		);

		return [$request, $response, $vars];
	}


	/**
	 * Get user by id
	 */
	function getUserById(Request $request, ?Response $response, $vars)
	{
		$response = new Response(
			'User id = ' . $vars["id"],
			Response::HTTP_OK,
			['content-type' => 'text/html']
		);
		return [$request, $response, $vars];
	}
}
