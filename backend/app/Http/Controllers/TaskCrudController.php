<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Laravel\Lumen\Routing\Router;
use App\Models\Task;


class TaskCrudController extends ApiCrudController
{
    var $model_name = Task::class;
    
    
    /**
     * Register routes
     */
    static function registerRoutes(Router $router)
    {
        $router->get('user.tasks/crud/search/',  ['uses' => 'TaskCrudController@actionSearch']);
        $router->get('user.tasks/crud/item/{id:\d+}/', ['uses' => 'TaskCrudController@actionItem']);
        $router->post('user.tasks/crud/create/', ['uses' => 'TaskCrudController@actionCreate']);
        $router->post('user.tasks/crud/edit/{id:\d+}/', ['uses' => 'TaskCrudController@actionUpdate']);
        $router->delete('user.tasks/crud/delete/{id:\d+}/', ['uses' => 'TaskCrudController@actionDelete']);
    }
    
    
    
    /**
     * Allow filter fields
     */
    public function allowFilterField($field_name, $op, $value)
    {
        if ($field_name == "id" && in_array($op, ["=", "<", ">", "<=", ">=", "!=", "in"])) return true;
        if ($field_name == "target_id" && in_array($op, ["=", "<", ">", "<=", ">=", "!=", "in"])) return true;
        if ($field_name == "status" && in_array($op, ["=", "<", ">", "<=", ">=", "!=", "in"])) return true;
        if ($field_name == "gmdate_plan_begin" && in_array($op, ["=", "<", ">", "<=", ">=", "!=", "in"])) return true;
        if ($field_name == "gmdate_plan_end" && in_array($op, ["=", "<", ">", "<=", ">=", "!=", "in"])) return true;
        if ($field_name == "gmdate_work_begin" && in_array($op, ["=", "<", ">", "<=", ">=", "!=", "in"])) return true;
        if ($field_name == "gmdate_work_end" && in_array($op, ["=", "<", ">", "<=", ">=", "!=", "in"])) return true;
        if ($field_name == "work_hours" && in_array($op, ["=", "<", ">", "<=", ">=", "!=", "in"])) return true;
        if ($field_name == "name" && in_array($op, ["=", "like"])) return true;
        return false;
    }
    
    
    
    /**
     * Find query
     */
    public function findQuery($query)
    {
        return $query;
    }
    
    
    
    /**
     * From database
     */
    public function fromDatabase($item)
    {
        $item = $item->getAttributes();
        $item = \App\Utils::intersect
        (
            $item,
            [
                "id",
                "name",
                "description",
                "target_id",
                "user_id",
                "gmdate_plan_begin",
                "gmdate_plan_end",
                "gmdate_work_begin",
                "gmdate_work_end",
                "work_hours",
                "status",
                "pos",
            ]
        );
        return $item;
    }
    
    
    
    /**
     * To database
     */
    public function toDatabase($item)
    {
        $item = \App\Utils::intersect
        (
            $item,
            [
                "name",
                "description",
                "target_id",
                "gmdate_plan_begin",
                "gmdate_plan_end",
                "gmdate_work_begin",
                "gmdate_work_end",
                "status",
                "pos",
            ]
        );
        return $item;
    }
}
