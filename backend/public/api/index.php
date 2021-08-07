<?php

require_once __DIR__ . "/../../vendor/autoload.php";

\Helper\Core::buildContainer( __DIR__ . "/../../defs.php" );
$app = app();
$app->init();
$app->run();
