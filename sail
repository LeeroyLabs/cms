<?php

require_once __DIR__ . '/vendor/autoload.php';

use SailCMS\CLI;

$cli = new CLI(path: __DIR__);
$cli->run();