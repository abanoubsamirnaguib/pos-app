<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\product;


use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Category extends Model implements TranslatableContract
{
    use  Translatable;

    public $guarded = [];
    public $translatedAttributes = ['name'];


    public function products()
    {
        return $this->hasMany(product::class ,'category_id' );
    }

}
