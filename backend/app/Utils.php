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

}