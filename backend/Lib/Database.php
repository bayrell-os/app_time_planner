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

namespace App\Lib;

class Database
{
	var $db_host = "";
	var $db_port = "";
	var $db_name = "";
	var $db_username = "";
	var $db_password = "";
	var $db_tz="UTC";
	var $pdo = null;
	var $last_error = null;
	var $last_error_str = "";
	var $last_error_code = 0;
	
	
	function isConnected()
	{
		return $this->pdo != null;
	}


	function connect()
	{
		try
		{
			$str = 'mysql:host='.$this->db_host;
			if ($this->db_port != null) $str .= ':'.$this->db_port;
			if ($this->db_name != null) $str .= ';dbname='.$this->db_name;
			$this->pdo = new \PDO
			(
				$str, $this->db_username, $this->db_password, 
				array
				(
					\PDO::ATTR_PERSISTENT => false
				)
			);
			$this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			$this->pdo->exec("set names utf8; set time_zone = '" . $this->db_tz . "'");
		}
		catch (\PDOException $e)
		{
			$this->pdo = null;
			$this->setError($e, [ "error_str" => "Failed connected to database!" ]);
		}
		catch (\Excepion $e)
		{
			$this->pdo = null;
			$this->setError($e, [ "error_code" => -1 ]);
		}
	}



	/**
	 * Set error
	 */
	function setError($e, $params = [])
	{
		$this->last_error = $e;
		$this->last_error_str = $e->getMessage();
		$this->last_error_code = $e->getCode();
		if (isset($params["error_str"]))
		{
			$this->last_error_str = $params["error_str"];
		}
		if (isset($params["error_code"]))
		{
			$this->last_error_code = $params["error_code"];
		}
	}



	/**
	 * Prepare SQL
	 */
	function prepare($sql)
	{
		$st = $this->pdo->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
		return $st;
	}



	/**
	 * Execute statement
	 */
	function execute($st, $params = null)
	{
		try
		{
			$st->execute($params != null ? $params : []);
		}
		catch (\PDOException $e)
		{
			$this->setError(e);
		}
	}



	/**
	 * Query statement
	 */
	function query($sql, $params = null)
	{
		$st = $this->prepare($sql);
		$this->execute($st, $params);
		return $st;
	}



	/**
	 * Get first item
	 */
	function getOne($sql, $arr)
	{
		$st = $this->query($sql, $arr);
		return $st->fetch(\PDO::FETCH_ASSOC);
	}



	/**
	 * Insert into database
	 */
	function insert($table_name, $data)
	{
		$keys = [];
		$values = [];
		foreach ($data as $key=>$val)
		{
			$keys[] = "`" . $key . "`";
			$values[] = ":" . $key;
		}
		$sql = "insert into " . $table_name . 
			" (" . implode(",",$keys) . ") values (" . implode(",",$values) . ")"
		;
		$st = $this->query($con, $sql, $data);
		return $st;
	}



	/**
	 * Update into database
	 */
	function update($table_name, $update, $where)
	{
		/* Build update */
		$update_arr = [];
		$update_keys = array_keys($update);
		foreach ($update_keys as $key)
		{
			$update_arr[] = "`" . $key . "` = :_update_" . $key;
			$args["_update_" . $key] = $update[$key];
		}
		$update_str = implode(", ", $update_arr);
		
		/* Build where */
		$where_arr = [];
		$where_keys = array_keys($where);
		foreach ($where_keys as $key)
		{
			$where_arr[] = "`" . $key . "` = :_where_" . $key;
			$args["_where_" . $key] = $where[$key];
		}
		$where_str = implode(" and ", $where_arr);

		$sql = \Elberos\wpdb_prepare
		(
			"update $table_name set $update_str where $where_str",
			$args
		);
		$st = $this->query($sql);
		return $st;
	}



	/**
	 * Delete from database
	 */
	function delete($table_name, $where)
	{
		/* Build where */
		$where_arr = [];
		$where_keys = array_keys($where);
		foreach ($where_keys as $key)
		{
			$where_arr[] = "`" . $key . "` = :_where_" . $key;
			$args["_where_" . $key] = $where[$key];
		}
		$where_str = implode(" and ", $where_arr);

		$sql = \Elberos\wpdb_prepare
		(
			"update $table_name set $update_str where $where_str",
			$args
		);
		$st = $this->query($sql);
		return $st;
	}



	/**
	 * Found rows
	 */
	function foundRows($con)
	{
		$sql = "SELECT FOUND_ROWS() as c;";
		$st = $this->query($con, $sql);
		$res = $st->fetch(\PDO::FETCH_ASSOC);
		return $res['c'];
	}


	/**
	 * Returns last insert id
	 */
	function getLastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
}