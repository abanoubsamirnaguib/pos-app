<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\order;


class orderController extends Controller
{
    public function index(Request $request)
    {

        $orders=order::whereHas('client',function($query) use ($request){

            return $query->where("name", 'like' , "%".$request->search."%"); 

        })
        ->paginate(5)->withQueryString();
        return view( 'dashboard.orders.index', ['orders'=>$orders] );
    }

    public function products(order $order){

        $products=$order->products;
        return view( 'dashboard.orders._products', ['products'=>$products,'order'=>$order] );
    }

    public function destroy(order $order,Request $request)
    {
        foreach($order->products as $product){
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
        }
        $order->delete();
        $request->session()->flash('success', __('site.deleted_successfully'));
        return redirect(route("dashboard.categories.index"));
    }
}
