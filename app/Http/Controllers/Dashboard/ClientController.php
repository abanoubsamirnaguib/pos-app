<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{

    public function index(Request $request)
    {

        if($request->search ) {

            $Clients=Client::when($request->search , function($query) use ($request)  {
                    
                return   $query->where("name" , 'like' ,"%". $request->search . "%" )
                ->orWhere("phone" , 'like' ,"%". $request->search . "%") 
                ->orWhere("address" , 'like' ,"%". $request->search . "%") ;
                })
                 ->latest()->paginate(5);
            }
            else {
            $Clients=Client::paginate(5);
                }
        return view( 'dashboard.clients.index', ['clients'=>$Clients] );
    }

    public function create()
    {
        $Clients=Client::all();

        return view('dashboard.clients.create',['Clients'=>$Clients]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name"=>'required',
            "phone"=>'required|array|max:14',
            'address'    =>'required|string'    ,
        ]);

        $request_data = $request->all(); 
        $request_data['phone']=array_filter($request->phone);
        
        $client =Client::Create ($request_data);

        $request->session()->flash('success', __('site.added_successfully'));
        return redirect(route('dashboard.clients.index'));
    }

    public function edit(Client $client)
    {
        return view("dashboard.clients.edit",['client'=>$client]);
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            "name"=>'required',
            "phone"=>'required|array|max:14',
            'address'=>'required|string'    ,
        ]);

        $request_data=$request->all();
        $request_data['phone']=array_filter($request->phone);
        $client ->update($request_data);

        $request->session()->flash('success', __('site.updated_successfully'));
        return redirect(route('dashboard.clients.index'));
    }

    public function destroy(Client $client,Request $request)
    {
         $client->delete();
         $request->session()->flash('success', __('site.deleted_successfully'));
         return redirect(route('dashboard.clients.index')); 
    }
}
