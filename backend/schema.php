<?php

Capsule::schema()
	->create('tasks', function ($table) {
		$table->bigIncrements('id');
		$table->string('name');
		$table->string('status');
	})
;