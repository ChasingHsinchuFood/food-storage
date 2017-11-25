<?php

/**
 * This is the main file.
 *
 * Initialize the eloquent database setting and including the dependencies.
 */

require_once 'vendor/autoload.php';

use Food\Storage\FoodStorage;
use Illuminate\Database\Capsule\Manager as Capsule;
use Dotenv\Dotenv;
use Food\Storage\FoodInfo;

$dotenv = new Dotenv(__DIR__);
$dotenv->load();

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => getenv('driver'),
    'host' => getenv('host'),
    'database' => getenv('database'),
    'username' => getenv('username'),
    'password' => getenv('password'),
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$storage = new FoodStorage();

$storage->createSchema($capsule);

$foodInfo = $storage::Create([]);

$resource = $storage->getCsvContent('stream', '../food-crawler/db.shop.csv');

// ignore the CSV file header
fgets($resource, 4096);

while(!feof($resource)) {
    $string = explode(',', fgets($resource, 4096));
    $address = $string[0];
    $phoneNumber = $string[1];
    $rate = $string[2];
    $shopName = $string[3];
    $mapImage = $string[4];

    var_dump($foodInfo->foodInfo()->create([
        'address' => $address,
        'phone_number' => $phoneNumber,
        'rate' => $rate,
        'shop_name' => $shopName,
        'static_map_image' => $mapImage,
    ]));
}

$storage->closeStream();
