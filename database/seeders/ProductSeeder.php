<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\product;

class ProductSeeder extends Seeder
{

    public function run()
    {
        // $cats=['prod one', 'prod two ' , 'prod three'];

        include('prod.php');

        foreach($prods as $prod){
            product::Create($prod); 
        }
    }
}
