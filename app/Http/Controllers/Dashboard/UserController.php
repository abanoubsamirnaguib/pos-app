<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use  Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct(){
              $this->middleware('permission:read_users')->only('index');  
              $this->middleware('permission:create_users')->only('create');  
              $this->middleware('permission:update_users')->only('edit');  
              $this->middleware('permission:delete_users')->only('destroy');  
    }
    public function index(Request $request)
    {

        if($request->search){

        $users=User::whereRoleIs('admin')->where( function( $q ) use ($request) {

           return  ( $q->when($request->search , function($query) use ($request)  {
               
           return  ( $query->where("First_name" , "like" , "%". $request->search . "%" )->
           orWhere("Last_name" , "like" , "%". $request->search . "%")
           ); })); 
   
            })->latest()->paginate(5);
        
        }
        else {
        $users=User::whereRoleIs('admin')->latest()->paginate(2);
        }
        return view("dashboard.users.index",['users'=>$users]);
    }

    public function create()
    {
        return view("dashboard.users.create");
    }
 
    public function store(Request $request)
    {
        $validated = $request->validate([
            "First_name"=>'required',
            "Last_name"=>'required',
            "email"=>'required|email:rfc|unique:users,email',
            "password"=>'required|confirmed'   ,
            'image'    =>'Image'    ,
            "permissions"=>'required|min:1' 
        ]);
        $request_data=$request->except(['password',"password_confirmation",'permissions','image']);
        $request_data['password']=bcrypt($request->password);
        
        if($request->image){

            $img = Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/user_images/'.$request->image->getClientOriginalName() ) );
            $request_data['image'] = $request->image->getClientOriginalName();

        } else {
            $request_data['image'] =('default.png');
        }

        $user = User::Create ($request_data);
        $user->attachRole('admin');
        
        $user->syncPermissions($request->permissions);

        $request->session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.welcome');
    }

    public function edit(User $user)
    {
        return view("dashboard.users.edit",['user'=>$user]);
    }
    
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            "First_name"=>'required',
            "Last_name"=>'required',
            "email"=>['required', Rule::unique('users','email')->ignore($user)] ,   
            "permissions"=>'required|min:1' ,
            'image'    =>'Image',
        ]);

        $request_data=$request->except(['permissions','image']);

        if( $request->image && $request->image != "default.png"){

            Storage::disk("public_uploads")->delete('/user_images/'.$user->image);  

            $img = Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/user_images/'.$request->image->getClientOriginalName() ) );
            $request_data['image'] = $request->image->getClientOriginalName();
        }
    
        $user ->update($request_data);

        $user->syncPermissions($request->permissions);

        $request->session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.welcome');
    }

    public function destroy(User $user, Request $request)
    {
        if($request->image != 'default.png'){
           Storage::disk("public_uploads")->delete('/user_images/'.$user->image);        
        }
        $user->delete();
        $request->session()->flash('success', __('site.deleted_successfully'));
        return redirect(route("dashboard.users.welcome"));
    }
}
