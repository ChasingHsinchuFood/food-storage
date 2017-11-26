<?php

namespace Food\Storage;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;

class FoodSouvenir extends Eloquent
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */

    protected $fillable = ['no', 'product_name', 'shop_name', 'address', 'phone_number', 'shop_website'];

    /**
    * Set the timestamps is false avoid adding updating time.
    *
    * @var boolean
    */

    public $timestamps = false;

    private $resource;

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */

    protected $hidden = [];

    /*
    * Create the shop_info table schema
    *
    */

    public function createSchema(Capsule $capsule)
    {
        $capsule::schema()->create('food_souvenirs', function ($table) {
            $table->increments('id');
            $table->string('no');
            $table->string('product_name');
            $table->string('shop_name');
            $table->string('address');
            $table->string('phone_number');
            $table->string('shop_website');
        });
    }

    /*
    * Get the csv contents
    *
    */

    public function getCsvContent(string $contentType, string $filePath)
    {
        if(file_exists($filePath) == false) {
            throw new \InvalidArgumentException('The '.$filePath.' file is not found');
        }

        return $this->resource = ($contentType == 'stream') ? fopen($filePath, 'r') : file_get_contents($filePath);
    }

    /*
    * Get the csv contents
    *
    */

    public function closeStream()
    {
        fclose($this->resource);
    }
}
