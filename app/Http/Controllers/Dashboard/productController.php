<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\productTranslations ;
use  Intervention\Image\ImageManagerStatic as Image;

class productController extends Controller
{

    public function index(Request $request)
    {
        // $products=product::paginate(5);
        $categories=Category::all();

        if($request->search  or $request->category_id){

            $products=product::when($request->search , function($query) use ($request)  {
                    
                return   $query->whereTranslationLike("name" , "%". $request->search . "%" );
                })->When($request->category_id , function($query) use ($request)  {          
                    return   $query->where("category_id" ,  $request->category_id  );
                    })   
                 ->latest()->paginate(5);
            }
            else {
            $products=product::paginate(5);
                }
                // return (($categories));
        return view('dashboard.products.index',['products'=>$products,'categories'=>$categories]);
    }


    public function create()
    {
        $categories=Category::all();
        return view('dashboard.products.create',['categories'=>$categories]);
    }


    public function store(Request $request)
    {
        $rules=[
        'category_id'=>'required|integer|exists:categories,id',
        'sale_price'=>'required|integer',
        'stock'=>'required|integer',
        'image' => 'image'
        ];
        foreach(config('translatable.locales') as $locale)
        {
            $rules+=[$locale.'.name'=>['required', Rule::unique('product_translations',"name") ]];
            $rules+=[$locale.'.description'=>['required', Rule::unique('product_translations',"description") ]];
        }  
        
        $request_data=$request->all(); 

        if($request->image){

            $img = Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('/uploads/product_images/'.$request->image->getClientOriginalName() ) );
            $request_data['image'] = $request->image->getClientOriginalName();

        } else {
            $request_data['image'] =('default.png');
        }

        $validated = $request->validate($rules);



        $products = product::Create ($request_data);
            
        $request->session()->flash('success', __('site.added_successfully'));
        return redirect(route('dashboard.products.index'));
    }



    public function edit(product $product)
    {
        $categories=Category::all();
        return view("dashboard.products.edit",['categories'=>$categories,'product'=>$product]);
    
    }


    public function update(Request $request, product $product)
    {
        $rules=[
            'category_id'=>'required|integer|exists:categories,id',
            'sale_price'=>'required|integer',
            'stock'=>'required|integer',
            'image' => 'image'
            ];
            foreach(config('translatable.locales') as $locale)
            {
                $rules+=[$locale.'.name'=>['required', Rule::unique('product_translations',"name")->ignore($product->id, "product_id") ]];
                $rules+=[$locale.'.description'=>['required'] ];
            }  
            
            $request_data=$request->all(); 
    
            
                if( $request->image && $request->image != "default.png"){

                    Storage::disk("public_uploads")->delete('/product_images/'.$product->image);  
    
                $img = Image::make($request->image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/uploads/product_images/'.$request->image->getClientOriginalName() ) );
                $request_data['image'] = $request->image->getClientOriginalName();
            
            }
    
            $validated = $request->validate($rules);
            $product ->update($request_data);

            $request->session()->flash('success', __('site.updated_successfully'));
            return redirect(route('dashboard.products.index'));
    }


    public function destroy(Request $request, product $product)
    {
        if($request->image != 'default.png'){
            Storage::disk("public_uploads")->delete('/product_images/'.$product->image);        
         }
         $product->delete();
         $request->session()->flash('success', __('site.deleted_successfully'));
        //  dd($product);
        return redirect(route('dashboard.products.index'));
    }
}
