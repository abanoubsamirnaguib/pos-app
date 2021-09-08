<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\category;
use App\Models\order;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class product extends Model implements TranslatableContract
{
    use  Translatable;

    public $guarded = [];
    public $translatedAttributes = ['name', 'description'];

        public function categories()
        {
            return $this->belongsTo(category::class,'category_id');
        }
        public function orders()
        {
            return $this->belongsToMany(order::class);
        }



        protected $appends = [
            'image_path' , 'profit_percent'
        ];
        public function getImagePathAttribute()
        {
            return (asset('uploads/product_images/'. $this->image));
        }
        public function getProfitPercentAttribute()
        {
            $profit= $this->sale_price -$this->purchase_price; 
            $profit_percent =$profit* 100 / $this->purchase_price;

            return number_format($profit_percent , 2);
        }
    
}
