<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use DB;
use Image;

class ActivitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
		$typeActivities = config("constants.typeActivities"); 
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = Activity::where('id','!=', null);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('title', 'like', '%' . $data['name'] . '%');
        }
       
        if (isset($data['status']) && !empty($data['status'])) {
            if ($data['status'] == 1)
                $query->where('status', 1);
            if ($data['status'] == 2)
                $query->where('status', 0);
        }

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

        return view('activities.index', compact('records','typeActivities'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$typeActivities = config("constants.typeActivities"); 
        return view('activities.create',compact('typeActivities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$options['allow_img_size'] = 10;
        $request->validate([
            'title' => 'required|max:255|sanitizeScripts',
			'description' => 'required|sanitizeScripts',
			'type_activity' => 'required',
			'code' => 'required',
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),     
        ], [
            'title.sanitize_scripts' => 'Invalid value entered for title field.',
        ]);



        $record = new Activity();
		/** Below code for save image **/
		$destinationPath = public_path('/uploads/activities/');
        $input = $request->all();
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			$file->move($destinationPath, $newName);
			$img = Image::make(public_path('/uploads/activities/'.$newName));
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			
			$img->save(public_path('/uploads/activities/thumb/'.$newName));
           
            $record->image = $newName;
		}
        $record->title = $request->input('title');
		$record->code = $request->input('code');
		$record->type_activity = $request->input('type_activity');
		$record->description = $request->input('description');
        $record->status = $request->input('status');
        $record->save();
        return redirect('activities')->with('success', 'Activity Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
		$typeActivities = config("constants.typeActivities"); 
         return view('activities.view')->with(['activity' => $activity,'typeActivities'=>$typeActivities]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Activity::find($id);
       $typeActivities = config("constants.typeActivities"); 
        return view('activities.edit')->with(['record' => $record,'typeActivities' => $typeActivities]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$options['allow_img_size'] = 10;
        $request->validate([
            'title' => 'required|max:255|sanitizeScripts',
			'description' => 'required|sanitizeScripts',
			'type_activity' => 'required',
			'code' => 'required',
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),
        ], [
            'title.sanitize_scripts' => 'Invalid value entered for title field.',
        ]);

        $record = Activity::find($id);
		/** Below code for save image **/
		$destinationPath = public_path('/uploads/activities/');
        $input = $request->all();
		if ($request->hasFile('image')) {

           
			$fileName = $input['image']->getClientOriginalName();
			$file = request()->file('image');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			$file->move($destinationPath, $newName);
			$img = Image::make(public_path('/uploads/activities/'.$newName));
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			$img->save(public_path('/uploads/activities/thumb/'.$newName));
            //** Below code for unlink old image **//
			$oldImage = public_path('/uploads/activities/'.$record->image);
			$oldImageThumb = public_path('/uploads/activities/thumb/'.$record->image);
			if(!empty($record->image) && @getimagesize($oldImage) && file_exists($oldImage)) {
				unlink($oldImage);
				unlink($oldImageThumb);
			}
            $record->image = $newName;
		}
		
		$record->title = $request->input('title');
		$record->code = $request->input('code');
		$record->type_activity = $request->input('type_activity');
		$record->description = $request->input('description');
        $record->status = $request->input('status');
        $record->save();
        return redirect('activities')->with('success', 'Activity Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Activity::find($id);
        $record->delete();
        return redirect('activities')->with('success', 'Activity Deleted.');
    }
}