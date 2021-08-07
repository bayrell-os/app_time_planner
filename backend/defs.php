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

use Psr\Container\ContainerInterface;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;

return
[
	"db" =>
		function (ContainerInterface $c)
		{
			$capsule = new Capsule;
			$capsule->addConnection([
				'driver'    => 'mysql',
				'host'      => getenv("DB_HOSTNAME"),
				'database'  => getenv("DB_NAME"),
				'username'  => getenv("DB_USERNAME"),
				'password'  => getenv("DB_PASSWORD"),
				'charset'   => 'utf8',
				'collation' => 'utf8_unicode_ci',
				'prefix'    => '',
			]);

			// $capsule->setEventDispatcher(new Dispatcher(new Container));

			// Set the cache manager instance used by connections... (optional)
			//$capsule->setCacheManager();

			// Make this Capsule instance available globally via static methods... (optional)
			$capsule->setAsGlobal();

			// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
			$capsule->bootEloquent();

			require_once __DIR__ . "/schema.php";

			return $capsule;
		},
	"console" => DI\create(\Symfony\Component\Console\Application::class),
	"routes_list" => DI\create(ListContainer::class),
	"models_list" => DI\create(ListContainer::class),
	"console_class_list" => DI\create(ListContainer::class),
	\FastRoute\RouteParser::class => DI\create(\FastRoute\RouteParser\Std::class),
	\FastRoute\DataGenerator::class => DI\create(\FastRoute\DataGenerator\GroupCountBased::class),
	\FastRoute\RouteCollector::class => DI\autowire(\FastRoute\RouteCollector::class),
	\FastRoute\Dispatcher::class =>
		function (ContainerInterface $c)
		{
			$router = $c->get(\FastRoute\RouteCollector::class);
			return new \FastRoute\Dispatcher\GroupCountBased( $router->getData() );
		},
];