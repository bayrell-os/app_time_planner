<?php

/*
$migrations = app()->get("Migration");

$migrations
	->create('tasks', function ($table) {
		$table->bigIncrements('id');
		$table->string('name');
		$table->string('status');
	})
;

$migrations
	->create('targets', function ($table) {
		$table->bigIncrements('id');
		$table->string('name');
	})
;
*/

$migrations = app()->get("migrations_list");
var_dump($migrations);