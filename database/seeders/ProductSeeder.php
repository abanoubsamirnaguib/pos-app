<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats=['prod one', 'prod two ' , 'prod three'];

        foreach($cats as $cat){
            product::Create([
                'category_id'=>random_int(1,3),
                'ar'=>["name"=>$cat, "description"=>$cat." desc"],
                'en'=>["name"=>$cat ,"description"=>$cat." desc"],

                'purchase_price'=>'120',
                'sale_price'=>'150',
                'stock'=>'5'
            ]); 
        }
    }
}
