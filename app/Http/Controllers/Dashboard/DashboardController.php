<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\Client;
use App\Models\product;
use App\Models\user;
use App\Models\order;


class DashboardController extends Controller
{
    function index (){

        $categories_count=category::all()->count();
        $clients_count=Client::all()->count();
        $products_count=product::all()->count();
        $users_count=User::whereRoleIs()->count();

        $sales_data1 = order::
                selectRaw('created_at as year')->
                selectRaw('(created_at) as month')->
                selectRaw('SUM(total_price) as sum')
                ->groupBy( 'year' ,'month' )
                ->get();
                
                $sales_data =[];
                foreach ($sales_data1 as $i=>$data){
                $sales_data [$i] = [
                    "year" => date('Y', strtotime($data->year)),
                    "month" => date('m', strtotime($data->month)),
                    "sum" => $data->sum
                ];
            };
        // dd( $sales_data );
        return view("dashboard.welcome",
        ["categories_count"=>$categories_count,
        "products_count"=>$products_count ,
        "clients_count"=>$clients_count,
        "users_count"=>$users_count,
        'sales_data'=>$sales_data
    ]);
    }
}
