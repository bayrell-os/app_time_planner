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


class Core
{

	static $di_container = null;


	/**
	 * Build container
	 */
	static function buildContainer($defs)
	{
		$container_builder = new \DI\ContainerBuilder();
		$container_builder->addDefinitions($defs);
		static::$di_container = $container_builder->build();
	}


	/**
	 * Get app instance
	 */
	static function app()
	{
		return static::$di_container->get("App");
	}
}

