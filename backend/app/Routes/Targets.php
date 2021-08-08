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
use App\Models\Target;
use FastRoute\RouteCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Targets
{

	var $attributes = [
		'id',
		'name',
	];


	
	/**
	 * Declare routes
	 */
	function routes(RouteCollector $routes)
	{
		$routes->addRoute('GET', '/targets/', [$this, "actionList"]);
		$routes->addRoute('GET', '/targets/{id:\d+}/', [$this, "actionGetById"]);
		$routes->addRoute('POST', '/targets/create/', [$this, "actionCreate"]);
		$routes->addRoute('POST', '/targets/{id:\d+}/edit/', [$this, "actionEdit"]);
		$routes->addRoute('POST', '/targets/{id:\d+}/delete/', [$this, "actionDelete"]);
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
			$targets = Target::all();
			$targets = $targets->map->only($this->attributes);
			$api_result->success( $targets );
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
	 * Get by id action
	 */
	function actionGetById(Request $request, ?Response $response, $vars)
	{
		$api_result = new ApiResult();

		$id = isset($vars["id"]) ? $vars["id"] : "";
		$target = Target::find($id);
		if ($target != null)
		{
			$api_result->success( $target->only($this->attributes) );
		}
		else
		{
			$api_result->exception( new \Helper\Exception\ItemNotFoundException() );
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

		if (0 !== strpos($request->headers->get('Content-Type'), 'application/json'))
		{
			$api_result->exception( new \Exception("Content type must be application/json") );
		}
		else
		{
			$post = json_decode($request->getContent(), true);
			if ($post == null)
			{
				$api_result->exception( new \Exception("Post is null") );
			}
			else
			{
				$data = isset($post["data"]) ? $post["data"] : [];
				$data = object_intersect($data, $this->attributes);
				$target = new Target();
				foreach ($data as $key => $value)
				{
					$target->$key = $value;
				}
				$target->save();
				$api_result->success( $target->only($this->attributes) );
			}
		}

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
		
		if (0 !== strpos($request->headers->get('Content-Type'), 'application/json'))
		{
			$api_result->exception( new \Exception("Content type must be application/json") );
		}
		else
		{
			$post = json_decode($request->getContent(), true);
			if ($post == null)
			{
				$api_result->exception( new \Exception("Post is null") );
			}
			else
			{
				$id = isset($vars["id"]) ? $vars["id"] : "";
				
				$target = Target::find($id);
				if ($target == null)
				{
					$api_result->exception( new \Helper\Exception\NotFoundException() );
				}
				else
				{
					$data = isset($post["data"]) ? $post["data"] : [];
					$data = object_intersect($data, $this->attributes);
					foreach ($data as $key => $value)
					{
						$target->$key = $value;
					}
					$target->save();
					$api_result->success( $target->only($this->attributes) );
				}
				
			}
		
		}

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
		
		$id = isset($vars["id"]) ? $vars["id"] : "";
		$target = Target::find($id);
		if ($target != null)
		{
			$target->delete();
			$api_result->success( $target->only($this->attributes) );
		}
		else
		{
			$api_result->exception( new \Helper\Exception\ItemNotFoundException() );
		}

		return [
			$request, 
			$api_result->getResponse(), 
			$vars
		];
	}
	
}
