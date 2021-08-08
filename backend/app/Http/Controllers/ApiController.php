<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use App\Models\Task;
use App\Exceptions\ItemNotFound;


/**
 * Api controller
 */
class ApiController extends BaseController
{
    var $action = "";
    var $model_name = "";
    var $api_result = [
        "data" => null,
        "error" => [
            "code" => 0,
            "str" => "",
            "name" => "",
        ]
    ];


    /**
     * Set api success
     */
    public function setApiSuccess($data)
    {
        $this->api_result["data"] = $data;
        $this->api_result["error"]["code"] = 1;
        $this->api_result["error"]["str"] = "";
        $this->api_result["error"]["name"] = "";
    }


    /**
     * Set api error
     */
    public function setApiError($str = "", $code = -1)
    {
        $this->api_result["error"]["code"] = $code;
        $this->api_result["error"]["str"] = $str;
        $this->api_result["error"]["name"] = "";
    }


    /**
     * Set api exception
     */
    public function setApiException(\Exception $e)
    {
        $this->api_result["error"]["code"] = $e->getCode();
        $this->api_result["error"]["str"] = $e->getMessage();
        $this->api_result["error"]["name"] = str_replace("\\", ".", get_class($e));
    }


    /**
     * Get api response
     */
    public function getApiResponse()
    {
        return response()->json($this->api_result);
    }


    /**
     * From database
     */
    public function fromDatabase($item)
    {
        return $item->getAttributes();
    }


    /**
     * To database
     */
    public function toDatabase($item)
    {
        return $item;
    }


    /**
     * Find items
     */
    public function findItems()
    {
        $class_name = $this->model_name;
        $items = $class_name::all();
        return $items;
    }


    /**
     * Find item by id
     */
    public function findItemById($id)
    {
        $class_name = $this->model_name;
        $item = $class_name::find($id);
        return $item;
    }


    /**
     * Get all data
     */
    public function actionGetAll()
    {
        $this->action = "actionGetAll";

        /* Find items */
        $items = $this->findItems();
        
        /* From database */
        $result = [];
        foreach ($items->all() as $item)
        {
            $item = $this->fromDatabase($item);
            $result[] = $item;
        }

        /* Set api result */
        $this->setApiSuccess($result);

        /* Response */
        return $this->getApiResponse();
    }


    /**
     * Get item by id
     */
    public function actionGetOne($id)
    {
        $this->action = "actionGetOne";

        /* Find items */
        $item = $this->findItemById($id);

        if ($item == null)
        {
            $this->setApiException( new ItemNotFound() );
        }
        else
        {
            /* From database */
            $result = $this->fromDatabase($item);

            /* Set result */
            $this->setApiSuccess($result);
        }
        
        return $this->getApiResponse();
    }


    /**
     * Create item
     */
    public function actionCreate(Request $request)
    {
        $this->action = "actionCreate";
        $class_name = $this->model_name;

        /* Get post data */
        $item = $request->all();

        /* Create item */
        $item = $this->toDatabase($item);
        $item = $class_name::create($item);
        $result = $this->fromDatabase($item);
        
        /* Set result */
        $this->setApiSuccess($result);
        
        /* Response */
        return $this->getApiResponse();
    }


    /**
     * Update item
     */
    public function actionUpdate($id, Request $request)
    {
        $this->action = "actionUpdate";

        /* Find items */
        $item = $this->findItemById($id);
        $class_name = $this->model_name;

        if ($item == null)
        {
            $this->setApiException( new ItemNotFound() );
        }
        else
        {
            /* Get post data */
            $update = $request->all();

            /* Update item */
            $update = $this->toDatabase($update);
            foreach ($update as $key => $value) $item->$key = $value;
            $item->save();
            $result = $this->fromDatabase($item);

            /* Set result */
            $this->setApiSuccess($result);
        }

        /* Response */
        return $this->getApiResponse();
    }


    /**
     * Delete item
     */
    public function actionDelete($id)
    {
        $this->action = "actionDelete";

        /* Find items */
        $item = $this->findItemById($id);
        $class_name = $this->model_name;

        if ($item == null)
        {
            $this->setApiException( new ItemNotFound() );
        }
        else
        {
            /* Delete item */
            $item->delete();
            $result = $this->fromDatabase($item);

            /* Response */
            $this->setApiSuccess($result);
        }

        /* Response */
        return $this->getApiResponse();
    }
}
