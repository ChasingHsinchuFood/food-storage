<?php

/**
 * This is the bootstrap file.
 *
 * Initialize the eloquent database setting and including the dependencies.
 */

require_once 'vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => getenv('driver'),
    'host' => getenv('host'),
    'database' => getenv('database'),
    'username' => getenv('username'),
    'password' => getenv('mysql'),
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();
