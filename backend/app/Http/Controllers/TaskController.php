<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Laravel\Lumen\Routing\Router;
use App\Models\Task;


class TaskController extends ApiController
{
    var $model_name = Task::class;
   

    /**
     * Register routes
     */
    static function registerRoutes(Router $router)
    {
        $router->get('tasks/',  ['uses' => 'TaskController@actionGetAll']);
        $router->get('tasks/{id}', ['uses' => 'TaskController@actionGetOne']);
        $router->post('tasks/create/', ['uses' => 'TaskController@actionCreate']);
        $router->post('tasks/{id}/edit/', ['uses' => 'TaskController@actionUpdate']);
        $router->delete('tasks/{id}/delete/', ['uses' => 'TaskController@actionDelete']);
    }

    
    /**
     * From database
     */
    public function fromDatabase($item)
    {
        $item = $item->getAttributes();
        $item = \App\Utils::intersect($item, ["id", "name"]);
        return $item;
    }


    /**
     * To database
     */
    public function toDatabase($item)
    {
        $item = \App\Utils::intersect($item, ["name"]);
        return $item;
    }
}
