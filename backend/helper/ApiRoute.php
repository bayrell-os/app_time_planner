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

class ApiRoute
{
    var $api_path = "";
    var $attributes = [
		'id',
		'name',
	];


	
	/**
	 * Declare routes
	 */
	function routes(RouteCollector $routes)
	{
        if ($this->$api_path != "")
        {
            $routes->addRoute
            (
                'GET',
                '/' . $this->$api_path . '/',
                [$this, "actionList"]
            );
            $routes->addRoute
            (
                'GET',
                '/' . $this->$api_path . '/{id:\d+}/',
                [$this, "actionGetById"]
            );
            $routes->addRoute
            (
                'POST',
                '/' . $this->$api_path . '/create/',
                [$this, "actionCreate"]
            );
            $routes->addRoute
            (
                'POST',
                '/' . $this->$api_path . '/{id:\d+}/edit/',
                [$this, "actionEdit"]
            );
            $routes->addRoute
            (
                'POST',
                '/' . $this->$api_path . '/{id:\d+}/delete/',
                [$this, "actionDelete"]
            );
        }
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
}