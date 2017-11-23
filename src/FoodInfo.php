<?php

namespace Food\Storage\AddFoodInfo;

use Illuminate\Database\Eloquent\Model as Eloquent;

class AddFoodInfo extends Eloquent
{
    protected $fillable = ['address', 'phone_number', 'rate', 'shop_name', 'static_map_image'];
}
