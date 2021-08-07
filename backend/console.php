#!/usr/bin/env php
<?php

require __DIR__ . '/app.php';

/* Init app */
app_init();
console_init();

/* Run console */
$console = app()->get("console");
$console->run();