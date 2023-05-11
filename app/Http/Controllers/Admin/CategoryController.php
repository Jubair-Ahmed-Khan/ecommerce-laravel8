<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

use Illuminate\Support\Str;
use DB;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //all category showing method

    public function index(){
        //query builder 
        //  $data = DB::table('categories')->get();

        //Eloquent ORM
        $data = Category::all();

         return view('admin.category.category.index',compact('data'));
    }

    // category insert method 
    public function store(Request $request){

        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:55',
        ]);

        //query builder
        // $data = array();
        // $data['category_name']= $request->category_name;
        // $data['category_slug']= Str::slug($request->category_name,'-');
        // $saved = DB::table('categories')->insert($data);
        
        //Eloquent ORM
        $saved = Category::insert([
            'category_name'=>$request->category_name,
            'category_slug'=>Str::slug($request->category_name,'-')
        ]);

        if($saved){
            $notification = array('message' => 'Cateogry inserted', 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }
    }

    // category edit method 
    public function edit($id){
        //query builder
        // $data = DB::table('categories')->where('id',$id)->first();

        //Eloquent ORM
        $data = Category::findorfail($id);

        return response()->json($data);

    }

    //category update method
    public function update(request $request){
        
        $id = $request->id;

        //query builder 
        // $data = array();
        // $data['category_name']= $request->category_name;
        // $data['category_slug']= Str::slug($request->category_name,'-');
        // $updated = DB::table('categories')->where('id',$id)->update($data);

          $updated = Category::findorfail($id)->update([
            'category_name'=>$request->category_name,
            'category_slug'=>Str::slug($request->category_name)
          ]);

        if($updated){
            $notification = array('message' => 'Cateogry updated', 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }

    }

    // category delete method 
    public function delete($id){

        // query builder 
        // $deleted = DB::table('categories')->where('id',$id)->delete();

        //Eloquent ORM
        $deleted = Category::find($id)->delete();

        if($deleted){
            $notification = array('message' => 'Cateogry deleted', 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }
    }

    

}
