<?php

// Allow CLI scripts to run with a high limit (8G)
ini_set('memory_limit', '8192M');

require_once __DIR__ . '/vendor/autoload.php';

use SailCMS\CLI;

$cli = new CLI(path: __DIR__);
$cli->run();
