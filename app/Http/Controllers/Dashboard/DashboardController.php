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

        $sales_data = order::
                selectRaw('YEAR(created_at) as year ')->
                selectRaw('MONTH(created_at) as month ')->
                selectRaw('SUM(total_price) as sum')
        ->groupBy('month, year')->get();

        dd( $sales_data );
        return view("dashboard.welcome",
        ["categories_count"=>$categories_count,
        "products_count"=>$products_count ,
        "clients_count"=>$clients_count,
        "users_count"=>$users_count,
        'sales_data'=>$sales_data
    ]);
    }
}
