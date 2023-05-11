<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB;
use App\Models\Category; 
use App\Models\Subcategory; 
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // all subcategory showing method 
    public function index(){
        //query builder  with onet one join
        // $data = DB::table('subcategories')->leftJoin('categories','subcategories.category_id','categories.id')->select('subcategories.*','categories.category_name')->get();
        // $category = DB::table('categories')->get(); 
        
        //Eloquent ORM
        $data=Subcategory::all();
        $category = Category::all();

        return view('admin.category.subcategory.index',compact('data','category'));
    }

    // subcategory insert method 
    public function store(Request $request){

        $validated = $request->validate([
            'subcategory_name' => 'required|max:55',
        ]);

        //query builder
        // $data = array();
        //  $data['category_id']= $request->category_id;
        // $data['subcategory_name']= $request->subcategory_name;
        // $data['subcat_slug']= Str::slug($request->subcategory_name,'-');
        //$saved= DB::table('subcategories')->insert($data);
        
        //Eloquent ORM
        $saved = Subcategory::insert([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
            'subcat_slug'=>Str::slug($request->subcategory_name,'-')
        ]);

        if($saved){
            $notification = array('message' => 'Subcateogry inserted', 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }
    }

    // subcategory edit method 
    public function edit($id){
        //query builder
        // $data = DB::table('subcategories')->where('id',$id)->first();
        // $category = DB::table('categories')->get();

        //dd($data);

        //Eloquent ORM
        $data = Subcategory::find($id);
        $category=Category::all();

        return view('admin.category.subcategory.edit',compact('data','category'));

    }

    //sub category update
    public function update(Request $request){
        
        //query builder 
        // $data = array();
        // $data['category_id']= $request->category_id;
        // $data['subcategory_name']= $request->subcategory_name;
        // $data['subcat_slug']= Str::slug($request->subcategory_name,'-');

        // $updated = DB::table('subcategories')->where('id',$id)->update($data);

          $updated = Subcategory::where('id',$request->id)->first()->update([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
            'subcat_slug'=>Str::slug($request->subcategory_name,'-')
          ]);

        if($updated){
            $notification = array('message' => 'Subcateogry updated', 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }

    }
    // subcategory delete method 
    public function delete($id){

        // query builder 
        // $deleted = DB::table('subcategories')->where('id',$id)->delete();

        //Eloquent ORM
        $deleted = Subcategory::find($id)->delete();

        if($deleted){
            $notification = array('message' => 'subcateogry deleted', 'alert-type' => 'success');
            return redirect()->back()->with($notification);
        }
    }



}
