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
	function request_before($vars)
	{
	}


	/**
	 * Request after
	 */
	function request_after($vars)
	{
	}


	/**
	 * Get users
	 */
	function getUsers($vars)
	{
		echo "Users";
	}


	/**
	 * Get user by id
	 */
	function getUserById($vars)
	{
		echo "User id = " . $vars["id"];
	}
}
