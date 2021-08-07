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

use Helper\ApiResult;
use App\Models\Task;
use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Tasks
{

	/**
	 * Declare routes
	 */
	function routes(RouteCollector $routes)
	{
		$routes->addRoute('GET', '/tasks/', [$this, "actionList"]);
		$routes->addRoute('GET', '/tasks/{id:\d+}/', [$this, "actionGetById"]);
		$routes->addRoute('POST', '/tasks/create/', [$this, "actionCreate"]);
		$routes->addRoute('POST', '/tasks/edit/', [$this, "actionEdit"]);
		$routes->addRoute('POST', '/tasks/delete/', [$this, "actionDelete"]);
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
	 * List action
	 */
	function actionList(Request $request, ?Response $response, $vars)
	{
		$api_result = new ApiResult();

		try
		{
			$tasks = Task::all();

			$tasks = $tasks->map->only([
				'id',
				'target_id',
				'name',
				'gmdate',
				'status',
				'user_id',
			]);

			$api_result->success( $tasks );
		}
		catch (\Exception $e)
		{
			$api_result->exception( $e );
		}

		return [
			$request, 
			$api_result->getResponse(), 
			$vars
		];
	}



	/**
	 * Create action
	 */
	function actionCreate(Request $request, ?Response $response, $vars)
	{
		$api_result = new ApiResult();

		return [
			$request, 
			$api_result->getResponse(), 
			$vars
		];
	}



	/**
	 * Edit action
	 */
	function actionEdit(Request $request, ?Response $response, $vars)
	{
		$api_result = new ApiResult();
		
		return [
			$request, 
			$api_result->getResponse(), 
			$vars
		];
	}



	/**
	 * Delete action
	 */
	function actionDelete(Request $request, ?Response $response, $vars)
	{
		$api_result = new ApiResult();
		
		return [
			$request, 
			$api_result->getResponse(), 
			$vars
		];
	}



	/**
	 * Get by id action
	 */
	function actionGetById(Request $request, ?Response $response, $vars)
	{
		$id = isset($vars["id"]) ? $vars["id"] : "";
		$api_result = new ApiResult();
		
		return [
			$request, 
			$api_result->getResponse(), 
			$vars
		];
	}
	
}
