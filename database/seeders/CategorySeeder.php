<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cats=['cat one', 'cat two ' , 'cat three'];

        foreach($cats as $cat){
            Category::Create([
                'ar'=>["name"=>$cat],
                'en'=>["name"=>$cat],
            ]); 
        }

    }
}