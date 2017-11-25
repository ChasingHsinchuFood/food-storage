<?php

namespace Food\Storage;

use Illuminate\Database\Eloquent\Model as Eloquent;

class FoodInfo extends Eloquent
{
    protected $fillable = ['address', 'phone_number', 'rate', 'shop_name', 'static_map_image'];
}
