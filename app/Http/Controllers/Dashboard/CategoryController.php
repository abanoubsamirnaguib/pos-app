<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Category;
use App\Models\CategoryTranslation;


class CategoryController extends Controller
{

    public function index(Request $request)
    {
        if($request->search){

        $categories=Category::when($request->search , function($query) use ($request)  {
                
            return   $query->whereTranslationLike("name" ,  "%". $request->search . "%" );
            })->latest()->paginate(5);
        }
        else {
        $categories=Category::paginate(5);
            }
            // return (($categories));
        return view('dashboard.categories.index',['categories'=>$categories]);
    }

    public function create()
    {
        $categories=Category::all();
        return view('dashboard.categories.create',['categories'=>$categories]);
    }

    public function store(Request $request)
    {
        $rules=[];
        foreach(config('translatable.locales') as $locale)
        {
            $rules+=[$locale.'.name'=>['required', Rule::unique('category_translations',"name") ]];
        }      
        $validated = $request->validate(
            // ["name"=>'required',]
            $rules
        );
        // dd($request->all() );

        $request_data=$request->all();     

        $category = Category::Create ($request_data);
            
        $request->session()->flash('success', __('site.added_successfully'));
        return redirect(route('dashboard.categories.index'));
    }

    public function edit(category $category)
    {
        return view("dashboard.categories.edit",['category'=>$category]);

    }

    public function update(Request $request, Category $category)
    {
        $rules=[];
        foreach(config('translatable.locales') as $locale)  
        {
            $rules=[$locale.'.name'=>['required', Rule::unique('category_translations',"name")->ignore($category->id, 'category_id') ] ];
        }      
        $validated = $request->validate($rules);

        // $validated = $request->validate([
        //     "name"=>['required', Rule::unique('categories','name')->ignore($category)] ,   
        // ]

        $request_data=$request->all();
        $category ->update($request_data);

        $request->session()->flash('success', __('site.updated_successfully'));
        return redirect(route('dashboard.categories.index'));
    }

    public function destroy(category $category,Request $request)
    {
         $category->delete();
         $request->session()->flash('success', __('site.deleted_successfully'));
         return redirect(route("dashboard.categories.index"));
    }
}
