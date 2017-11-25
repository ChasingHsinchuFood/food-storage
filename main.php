<?php

require_once './bootstrap.php';

use Food\Storage\FoodStorage;

$storage = new FoodStorage();

$storage->createSchema($capsule);

$foodInfo = $storage::Create([]);

$resource = $storage->getCsvContent('stream', './db.shop.csv');

var_dump($foodInfo->foodInfo()->create([
    'address' => $address,
    'phone_number' => $phoneNumber,
    'rate' => $rate,
    'shop_name' => $shopName,
    'static_map_image' => $mapImage,
]));

$storage->closeStream();
