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


/**
 * Intersect object
 */
function object_intersect($item, $keys)
{
	$res = [];
	if ($item instanceof \Illuminate\Database\Eloquent\Model)
	{
		$item = $item->getAttributes();
	}
	foreach ($item as $key => $val)
	{
		if (in_array($key, $keys))
		{
			$res[$key] = $val;
		}
	}
	return $res;
}


/**
 * Intersect object
 */
function object_intersect_curry($keys)
{
	return function ($item) use ($keys)
	{
		return object_intersect($item, $keys);
	};
}