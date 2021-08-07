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

namespace Helper;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Api Result
 */
class ApiResult
{
	var $data = null;
	var $error_code = 0;
	var $error_name = "";
	var $error_str = "";
	var $status_code = Response::HTTP_OK;


	
	/**
	 * Success
	 */
	function success($data)
	{
		$this->data = $data;
		$this->clearError();
		$this->error_code = 1;
		return $this;
	}



	/**
	 * Error
	 */
	function error($error_str = "", $error_code = -1)
	{
		$this->clearError();
		$this->error_str = $error_str;
		$this->error_code = $error_code;
		return $this;
	}



	/**
	 * Exception
	 */
	function exception($e)
	{
		$this->clearError();
		$this->error_str = $e->getMessage();
		$this->error_code = $e->getErrorCode();
		$this->error_name = get_class($e);
		$this->status_code = Response::HTTP_INTERNAL_SERVER_ERROR;
		return $this;
	}



	/**
	 * Clear error
	 */
	function clearError()
	{
		$this->error_code = 0;
		$this->error_name = "";
		$this->error_str = "";
		return $this;
	}



	/**
	 * Returns response
	 */
	function getResponse()
	{
		$res =
		[
			"data" => $this->data,
			"error" =>
			[
				"code" => $this->error_code,
				"name" => $this->error_name,
				"str" => $this->error_str,
			],
		];
		return new Response(
			json_encode($res),
			$this->status_code,
			['content-type' => 'application/json']
		);
	}
}