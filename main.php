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

// it should check the table whether it's existed before calling the createSchema method
$storage->createSchema($capsule);

$storage::Create([]);

$resource = $storage->getCsvContent('stream', '../food-crawler/db.shop.csv');

// ignore the CSV file header
fgets($resource, 4096);

while(!feof($resource)) {
    $string = explode(',', fgets($resource, 4096));
    foreach($string as $key => $str) {
        $string[$key] = trim($str);
    }

    $address = isset($string[0]) ? $string[0] : '';
    $phoneNumber = isset($string[1]) ? $string[1] : '';
    $rate = isset($string[2]) ? $string[2] : '';
    $shopName = isset($string[3]) ? $string[3] : '';
    $mapImage = isset($string[4]) ? $string[4] : '';

    if($address == '') {
        continue;
    }

    $storage::create([
        'address' => $address,
        'phone_number' => $phoneNumber,
        'rate' => $rate,
        'shop_name' => $shopName,
        'static_map_image' => $mapImage,
    ]);
}

$storage->closeStream();

// Getall records of specific table
$storage::all()->toArray();
