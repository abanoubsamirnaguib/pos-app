<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\category;


class CategorySeeder extends Seeder
{

    public function run()
    {
        // $cats=['cat one', 'cat two ' , 'cat three'];

        $cats = [
            ["ar" => "موبيلات"  , 'en' =>'phones'],
            ["ar" => "تلفزيونات"  , 'en' =>'tvs'],
            ["ar" => "لابتوب"  , 'en' =>'laptop'],
            ["ar" => "اثاث"  , 'en' =>'furniture'],
            ["ar" => "العاب"  , 'en' =>'Toys']
        ];

        foreach($cats as $key => $cat){
            // foreach($cat as  $val){
            category::Create(
                [
                 "ar" => ["name"=>$cat['ar']],
                 "en" => ["name"=>$cat['en']]
               ]                
            ); 
        }

    }
}
