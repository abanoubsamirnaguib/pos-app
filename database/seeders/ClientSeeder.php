<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;


class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     
    public function run()
    {
        $names=['mohamed', 'ahmed ' , 'Abanoub'];

        foreach($names as $name){
            Client::Create([
                'name'=>$name ,
                'address'=>'el haram',
                'phone'=>'01225485354',
            ]); 
        }
    }
}
