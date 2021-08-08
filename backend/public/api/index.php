<?php

/* Remove api */
$uri = $_SERVER['REQUEST_URI'];
//$uri = preg_replace("/^\/api/", "", $uri);
//$_SERVER['REQUEST_URI'] = $uri;

$app = require __DIR__.'/../../bootstrap/app.php';
$app->run();
