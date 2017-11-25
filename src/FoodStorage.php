<?php

namespace Food\Storage;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Capsule\Manager as Capsule;

class FoodStorage extends Eloquent
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */

    protected $fillable = [];

    private $resource;

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */

    protected $hidden = [];

    /*
    * Get FoodInfo of food information
    *
    */

    public function foodInfo()
    {
        return $this->hasMany('Food\Storage\FoodInfo');

    }

    /*
    * Create the shop_info table schema
    *
    */

    public function createSchema(Capsule $capsule)
    {
        if(!$capsule::hasTable('food_storages')) {
            $capsule::schema()->create('food_storages', function ($table) {
                $table->primary('address');
                $table->string('address');
                $table->string('phone_number');
                $table->double('rate', 8, 2);
                $table->string('shop_name');
                $table->string('static_map_image');
            });
        }
    }

    /*
    * Get the csv contents
    *
    */

    public function setUpdatedAt($value)
    {
        $this->{static::UPDATED_AT} = $value;
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
