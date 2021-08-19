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

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Utils;


class Task extends Model
{
	protected $table = "tasks";
	protected $primaryKey = "id";
	public $incrementing = true;
	protected $attributes =
	[
    ];
	
	
	/**
	 * Save to database
	 */
	public function save(array $options = [])
    {
		/* Plan time */
		$gmdate_plan_begin_time = Utils::to_timestamp($this->gmdate_plan_begin);
		$gmdate_plan_end_time = Utils::to_timestamp($this->gmdate_plan_end);
		if ($gmdate_plan_begin_time != -1)
		{
			if ($gmdate_plan_begin_time > $gmdate_plan_end_time)
			{
				$this->gmdate_plan_end = Utils::to_date($gmdate_plan_begin_time);
			}
		}
		
		/* Work time */
		$gmdate_work_begin_time = Utils::to_timestamp($this->gmdate_work_begin);
		$gmdate_work_end_time = Utils::to_timestamp($this->gmdate_work_end);
		if ($gmdate_work_begin_time != -1)
		{
			if ($gmdate_work_begin_time > $gmdate_work_end_time)
			{
				$this->gmdate_plan_end = Utils::to_date($gmdate_work_begin_time);
			}
			
			/* Calculate work hours */
			$this->work_hours = $gmdate_work_end_time - $gmdate_work_begin_time;
		}
		else
		{
			$this->work_hours = 0;
		}
		
		parent::save($options);
	}
}