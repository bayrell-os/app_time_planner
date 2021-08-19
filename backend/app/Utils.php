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
    
    
    
    /**
     * To datetime
     */
    static function to_datetime($date, $tz = 'UTC', $format = 'Y-m-d H:i:s')
    {
        $tz = $tz instanceof \DateTimeZone ? $tz : new \DateTimeZone($tz);
        $dt = \DateTime::createFromFormat($format, $date, $tz);
        return $dt;
    }
    
    
    
    /**
     * To timestamp
     */
    static function to_timestamp($date, $tz = 'UTC', $format = 'Y-m-d H:i:s')
    {
        $dt = static::to_datetime($date, $tz, $format);
        if ($dt) return $dt->getTimestamp();
        return -1;
    }
    
    
    
    /**
     * To date
     */
    static function to_date($timestamp, $tz = 'UTC', $format = 'Y-m-d H:i:s')
    {
        $tz = $tz instanceof \DateTimeZone ? $tz : new \DateTimeZone($tz);
        $dt = new \DateTime();
        $dt->setTimestamp($timestamp);
        $dt->setTimezone($tz);
        return $dt->format($format);
    }
    
    
    
    /**
     * Attr
     */
    static function attr($obj, $keys, $default_value = null)
    {
        if (gettype($keys) != "array") $keys = [ $keys ];
        else $keys = array_values($keys);
        
        while (count($keys) != 0)
        {
            $key = $keys[0];
            if (!isset($obj[$key])) return $default_value;
            $obj = $obj[$key];
            array_shift($keys);
        }
        
        return $obj;
    }
    
    
    /**
     * Get sql
     */
    static function getSql($query)
    {
        $sql = $query->toSql();
        $data = $query->getBindings();
        $sql = vsprintf(str_replace("?", "'%s'", $sql), $data);
        return $sql;
    }
}