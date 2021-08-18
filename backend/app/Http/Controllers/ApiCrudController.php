<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;
use App\Exceptions\ItemNotFound;
use App\Utils;


/**
 * Api crud controller
 */
abstract class ApiCrudController extends BaseController
{
    var $request = null;
    var $action = "";
    var $model_name = "";
    var $api_result =
    [
        "data" => null,
        "error" => [
            "code" => 0,
            "str" => "",
            "name" => "",
        ]
    ];
    var $filter = null;
    var $start = 0;
    var $limit = 1000;
    var $total = 0;
    var $items = null;
    
    
    
    /**
     * Returns max limit
     */
    public function getMaxLimit()
    {
        return 1000;
    }
    
    
    
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
     * Validate reuest
     */
    public function validateRequest(Request $request)
    {
        return true;
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
     * Allow filter fields
     */
    public function allowFilterField($field_name, $op, $value)
    {
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
     * Find items
     */
    public function findItems()
    {
        $class_name = $this->model_name;
        
        /* Get query */
        $query = $class_name::query();
        
        /* Limit */
        $query
            ->where($this->filter)
            ->offset($this->start)
            ->limit($this->limit)
        ;
        
        /* Filter query */
        $query = $this->findQuery($query);
        
        /* Result */
        $this->items = $query->get();
        $this->total = $query->count();        
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
     * Returns filter by request
     */
    public function initFilter()
    {
        $this->filter = [];
        if ($this->request->exists("filter"))
        {
            $this->filter = Utils::parseFilter
            (
                $this->request->input("filter"),
                Utils::method($this, "allowFilterField")
            );
        }
    }
    
    
    
    /**
     * Init action
     */
    public function init()
    {
        /* Search action */
        if ($this->action == "actionSearch")
        {
            $max_limit = $this->getMaxLimit();
            if ($this->request->exists("start"))
            {
                $this->start = (int)($this->request->input("start"));
            }
            if ($this->request->exists("start"))
            {
                $this->limit = (int)($this->request->input("limit"));
            }
            if ($this->limit > $max_limit) $this->limit = $max_limit;
            $this->initFilter();
        }
    }
    
    
    
    /**
     * Final action
     */
    public function final()
    {
    }
    
    
    
    /**
     * Get all data
     */
    public function actionSearch(Request $request)
    {
        $this->action = "actionSearch";
        $this->request = $request;
        
        /* Setup action */
        $this->init();
        
        /* Find items */
        $this->findItems();
        
        /* Result */
        $result =
        [
            "items" => [],
            "filter" => $this->filter,
            "start" => $this->start,
            "limit" => $this->limit,
            "total" => $this->total,
        ];
        
        /* From database */
        $items = $this->items;
        foreach ($items->all() as $item)
        {
            $item = $this->fromDatabase($item);
            $result["items"][] = $item;
        }

        /* Set api result */
        $this->setApiSuccess($result);

        /* Setup action */
        $this->final();
        
        /* Response */
        return $this->getApiResponse();
    }
    
    
    
    /**
     * Get item by id
     */
    public function actionItem($id, Request $request)
    {
        $this->action = "actionItem";
        $this->request = $request;

        /* Find items */
        $item = $this->findItemById($id);

        if ($item == null)
        {
            throw new ItemNotFound();
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
        $this->request = $request;
        
        $class_name = $this->model_name;

        /* Validate */
        if (!$this->validateRequest($request))
        {
            return $this->getApiResponse();    
        }

        /* Get post data */
        $post = $request->all();
        $data = isset($post["data"]) ? $post["data"] : [];

        /* Create item */
        $data = $this->toDatabase($data);
        $item = new $class_name();
        foreach ($data as $key => $value) $item->$key = $value;
        $item->save();
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
        $this->request = $request;
        
        /* Validate */
        if (!$this->validateRequest($request))
        {
            return $this->getApiResponse();    
        }

        /* Find items */
        $item = $this->findItemById($id);
        $class_name = $this->model_name;        

        if ($item == null)
        {
            throw new ItemNotFound();
        }
        else
        {
            /* Get post data */
            $post = $request->all();
            $data = isset($post["data"]) ? $post["data"] : [];

            /* Update item */
            $data = $this->toDatabase($data);
            foreach ($data as $key => $value) $item->$key = $value;
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
    public function actionDelete($id, Request $request)
    {
        $this->action = "actionDelete";
        $this->request = $request;
        
        /* Find items */
        $item = $this->findItemById($id);
        $class_name = $this->model_name;

        if ($item == null)
        {
            throw new ItemNotFound();
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
