<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    //var_dump($_SERVER['REQUEST_URI']);
    return $router->app->version();
});

\App\Http\Controllers\TaskController::registerRoutes($router);
\App\Http\Controllers\TargetController::registerRoutes($router);


/*
$router->group(['prefix' => 'api'], function () use ($router) {
    
});
*/