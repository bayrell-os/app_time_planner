#!/usr/bin/env php
<?php

require __DIR__ . '/app.php';

/* Init app */
app_init();

/* Create console */
$console = app()->get("console");

/* Register console commands */
$console_class_list = app()->get("console_class_list");
foreach ($console_class_list->arr as $class_name)
{
	$console->add( new $class_name() );
}

/* Run console */
$console->run();