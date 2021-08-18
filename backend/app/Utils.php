<?php

namespace App;

/**
 * Utils
 */
class Utils
{
    /**
     * Intersect object
     */
    static function intersect($obj, $keys)
    {
        $res = [];
        foreach ($obj as $key => $val)
        {
            if (in_array($key, $keys))
            {
                $res[$key] = $val;
            }
        }
        return $res;
    }
    
    
    
    /**
     * Filter parse functions
     */
    static function parseFilter($filter, $allow_filter_field_callback)
    {
        if (gettype($filter) != "array") return [];
        $filter = array_map
        (
            function ($obj) use ($allow_filter_field_callback)
            {
                $obj = json_decode($obj, true);
                if (gettype($obj) != "array") return null;
                if (count($obj) != 3) return null;
                if (!$allow_filter_field_callback($obj[0], $obj[1], $obj[2])) return null;
                return [$obj[0], $obj[1], $obj[2]];
            },
            $filter
        );
        $filter = array_filter($filter, function ($item){ return $item !== null; } );
        return $filter;
    }
    
    
    
    /**
     * Create function
     */
    static function method($obj, $method_name)
    {
        return function () use ($obj, $method_name)
        {
            return call_user_func_array([$obj, $method_name], func_get_args());
        };
    }
}