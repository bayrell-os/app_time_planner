<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Laravel\Lumen\Routing\Router;
use App\Models\Target;


class TargetCrudController extends ApiCrudController
{
    var $model_name = Target::class;
   

    /**
     * Register routes
     */
    static function registerRoutes(Router $router)
    {
        $router->get('targets/',  ['uses' => 'TargetController@actionGetAll']);
        $router->get('targets/{id:\d+}/', ['uses' => 'TargetController@actionGetOne']);
        $router->post('targets/create/', ['uses' => 'TargetController@actionCreate']);
        $router->post('targets/{id:\d+}/edit/', ['uses' => 'TargetController@actionUpdate']);
        $router->delete('targets/{id:\d+}/delete/', ['uses' => 'TargetController@actionDelete']);
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
