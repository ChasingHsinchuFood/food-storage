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

    protected $fillable = ['name', 'email', 'password','userimage'];

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

    public function createSchema()
    {
        Capsule::schema()->create('shop_info', function ($table) {
            $table->increments('id');
            $table->string('address');
            $table->string('phone_number');
            $table->double('rate');
            $table->string('shop_name');
            $table->string('static_map_image');
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

        return ($contentType == 'stream') ? fopen($filePath, 'r') : file_get_contents($filePath);
    }
}
