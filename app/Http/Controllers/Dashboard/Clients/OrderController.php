<?php

namespace App\Http\Controllers\Dashboard\Clients;

use App\Http\Controllers\Controller;
use App\Models\order;
use App\Models\Client;
use App\Models\Category;
use App\Models\product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()  
    {
        $clients=Client::all();
        return view( 'dashboard.orders.index', ['clients'=>$clients] );
    }

    public function create(Client $client)
    {
               $categories = Category::all();
               $orders= $client->orders()->paginate(5);
        return view( 'dashboard.clients.orders.create', ['orders'=>$orders,'client'=>$client,'categories'=>$categories] );
    }

    public function store(Request $request,Client $client)
    {
        // dd( $request->all() );

        $validated = $request->validate([
            "products"=>'required|array',
            // "quantity"=>'required|array',
        ]);
       
        $this->attach_order($request , $client);

        $request->session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');
    }

    public function edit(Client $client,order $order)
    {
        $categories = Category::all();
        $orders= $client->orders()->paginate(5);
        return view( 'dashboard.clients.orders.edit', ['client'=>$client,'order'=> $order,'orders'=> $orders,'categories'=>$categories] );
    }

    public function update(Request $request, Client $client, order $order)
    {
        $validated = $request->validate([
            "products"=>'required|array',
        ]);

        $this->detach_order($order);
        $this->attach_order($request , $client);

        $request->session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');
    }

    private function attach_order($request, $client){

        $order = $client->orders()->Create([]);
        $order->products()->attach($request-> products); 

        $total_price=0;
        
        foreach( $request->products as $id => $quantity ) {
                $product=product::findOrFail($id);

                $total_price += $product ->sale_price * $quantity['quantity'];
                $product->update([
                    'stock'=>$product->stock - $quantity['quantity']
                ]);
        }

        $order->update(['total_price'=> $total_price]);

    }

    private function detach_order($order){

        foreach($order->products as $product){
            $product->update([
                'stock' => $product->stock + $product->pivot->quantity
            ]);
                }
        $order->delete();
    }

 
}
