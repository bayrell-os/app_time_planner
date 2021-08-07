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

require_once __DIR__ . "/vendor/autoload.php";
require_once __DIR__ . "/Lib/utils.php";


/**
 * Init web app
 */
function app_init()
{
	/* Build container */
	build_container( require __DIR__ . "/defs.php" );

	/* Includes routes */
	addRoutesFromClass(\App\Routes\Users::class);

	/* Connect to database */
	$db = app()->get("db");
	if (!$db->isConnected())
	{
		header("Content-Type: application/json");
		echo json_encode
		([
			"error" =>
			[
				"code" => -1,
				"str" => $db->last_error_str,
			]
		]);
		exit();
	}
}



/**
 * Run web app
 */
function app_run()
{
	/* Fetch method and URI from somewhere */
	$method = $_SERVER['REQUEST_METHOD'];
	$uri = $_SERVER['REQUEST_URI'];

	/* Remove api */
	$uri = preg_replace("/^\/api/", "", $uri);
	$_SERVER['REQUEST_URI'] = $uri;

	dispatch_uri($method, $uri);
}