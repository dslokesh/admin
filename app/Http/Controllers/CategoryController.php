<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderBy = array('created_at' => 'DESC');
        $record_per_page = config('constants.RECORDS_PER_PAGE');
        $data = $request->all();

        if(isset($data['sort']) && isset($data['direction'])){
			$orderBy = array();
			$orderBy[$data['sort']] = $data['direction'];
			$categories = Category::sortable($orderBy)->paginate($record_per_page);
		} else {
			$categories = Category::sortable($orderBy)->paginate($record_per_page);
		}

        //$categories = Category::paginate($record_per_page);
        //$categories = Category::sortable()->paginate(2);
       // $categories = Category::orderBy('name', 'ASC')->get();
		//$categories = Category::all();
		//pr($categories); die();
		return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $pcategories = Category::where(['parent_id' => NULL, 'status' => 1])->orderBy('name', 'ASC')->get();
        //pr($pcategories); die;
        return view('categories.create', compact('pcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255|sanitizeScripts|unique:categories'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $category = new Category();
        $category->name = $request->input('name');
        if($request->input('parent_id')!=""){
            $category->parent_id = $request->input('parent_id');
        }        
        //pr($category); die;
        $category->save();
        return redirect('categories')->with('success','Category Created Successfully.');


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    //public function edit(Category $category)
    public function edit($id)
    {
        $pcategories = Category::where(['parent_id' => NULL, 'status' => 1])->orderBy('name', 'ASC')->get();
        //pr($pcategories); //die;
        $category = Category::find($id);
        if($category->parent_id !=""){
            $pcategories[count($pcategories)] = Category::find($category->parent_id);
        }
        //pr($pcategories); 
        //return view('categories.edit')->with('category',$category);
        return view('categories.edit', compact('pcategories','category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    //public function update(Request $request, Category $category)
    public function update(Request $request, $id)
    {
       
        $request->validate([
            'name'=>'required|max:255|sanitizeScripts|unique:categories,name,' .$id,
           // 'parent_id' => 'same:name',
            'status'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);
        //pr($request->all()); die;
        if($request->input('parent_id')!="" && $request->input('parent_id') == $id){
            return redirect('categories/'.$id.'/edit')->with('error','Parent Category and Category must be different.');
        }
        $category = Category::find($id);
        $category->name = $request->input('name');
        if($request->input('parent_id')!=""){
            $category->parent_id = $request->input('parent_id');
        }else{
            $category->parent_id = NULL;
        }
        $category->status = $request->input('status');
        //pr($category); die;
        $category->save();
        return redirect('categories')->with('success','Category Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    //public function destroy(Category $category)
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect('categories')->with('success', 'Category Deleted.');
    }
}
