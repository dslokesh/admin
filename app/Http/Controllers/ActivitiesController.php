<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Transfer;
use App\Models\Zone;
use App\Models\Files;
use App\Models\ActivityPrices;
use Illuminate\Http\Request;
use DB;
use Image;
use File;

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
        $query = Activity::with('prices')->where('id','!=', null);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('title', 'like', '%' . $data['name'] . '%');
        }
       
        if (isset($data['status']) && !empty($data['status'])) {
            if ($data['status'] == 1)
                $query->where('status', 1);
            if ($data['status'] == 2)
                $query->where('status', 0);
        }
		
		if (isset($data['is_price']) && !empty($data['is_price'])) {
            if ($data['is_price'] == 1)
                $query->where('is_price', 1);
            if ($data['is_price'] == 2)
                $query->where('is_price', 0);
        }

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		//dd($records);
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
		$transfers = Transfer::where('status', 1)->orderBy('name', 'ASC')->get();
		$zones = Zone::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('activities.create',compact('typeActivities','transfers','zones'));
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
			'description' => 'required',
			'type_activity' => 'required',
			'code' => 'required',
			'featured_image' => 'required|image|max:' . ($options['allow_img_size'] * 1024),
			'image.*' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
        ], [
            'title.sanitize_scripts' => 'Invalid value entered for title field.',
			'image.*.max' => 'The image must not be greater than '. $options['allow_img_size'] .' MB.',
			'featured_image.max' => 'The featured image must not be greater than '.$options['allow_img_size'].' MB.',
			'image.*.image' => 'The image must be an image.',
        ]);

		
        $record = new Activity();
		
		$allday = ($request->input('AllDay'))?$request->input('AllDay'):'';
		$weekdays = ($request->input('day'))?$request->input('day'):[];
		
		if($allday == 'All')
		{
			$record->availability = $allday;
		}
		else
		{
			if(count($weekdays) > 0)
			{
				$days = implode(",",$weekdays);
				$record->availability = $days;
			}
		}
		
		$sic_TFRS = $request->input('sic_TFRS');
		
		if($sic_TFRS == 1)
		{
			$zones = $request->input('zones');
			$zoneValue = $request->input('zoneValue');
			$zoneArray = [];
			foreach($zones as $k => $z)
			{
				$zoneArray[] = [
				'zone' => $z,
				'zoneValue' => $zoneValue[$k],
				];
			}
			
			$zoneArrayJson = json_encode($zoneArray);
			$record->zones = $zoneArrayJson;
		}
		
		if($request->hasfile('featured_image')){
            $image = $request->file('featured_image');
			$record->image = $this->uploadImages($image);
        }
		
		$record->sic_TFRS = $sic_TFRS;
        $record->title = $request->input('title');
		$record->code = $request->input('code');
		$record->type_activity = $request->input('type_activity');
		$record->entry_type = $request->input('entry_type');
		$record->priror_booking_time = $request->input('priror_booking_time');
		$record->vat = $request->input('vat');
		$record->black_sold_out = $request->input('black_sold_out');
		$record->is_opendated = $request->input('is_opendated');
		$record->valid_till = ($request->input('is_opendated')==1)?$request->input('valid_till'):'';
		$record->pvt_TFRS = $request->input('pvt_TFRS');
		$record->transfer_plan = ($request->input('pvt_TFRS')==1)?$request->input('transfer_plan'):0;
		$record->inclusion = $request->input('inclusion');
		$record->exclusion = $request->input('exclusion');
		$record->description = $request->input('description');
		$record->cancellation_policy = $request->input('cancellation_policy');
        $record->status = $request->input('status');
		$record->save();
		
		//Upload Additional images
        $images = array();
        if($request->hasfile('image'))
        {
           foreach($request->file('image') as $file)
           {
               $filename = $this->uploadImages($file);
			   $images[] = [
                    'filename' => $filename,
                    'model_id' => $record->id,
					'model' => "Activity",
                ];
            }
			
			Files::insert($images);
        }
		
		
		if ($request->has('save_and_continue')) {
        return redirect()->route('activity.prices.create',$record->id)->with('success', 'Activity Created Successfully.');
		} else {
        return redirect('activities')->with('success', 'Activity Created Successfully.');
		}
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
		$activity = $activity::with('transfer')->where('id',$activity->id)->first();
		$zoneArray = [];
		if($activity->sic_TFRS == 1)
		{
			$zoneArrayJson = json_decode($activity->zones);
			
			foreach($zoneArrayJson as $k => $z)
			{
				$zone = Zone::where('status', 1)->where('id', $z->zone)->orderBy('name', 'ASC')->first();
				
				$zoneArray[] = [
				'zone' => $zone->name,
				'zoneValue' => $z->zoneValue,
				];
			}
			
			
		}
		
		$priceData = ActivityPrices::where('activity_id',$activity->id)->get();
		
         return view('activities.view')->with(['activity' => $activity,'typeActivities'=>$typeActivities,'zoneArray'=>$zoneArray,'priceData'=>$priceData]);
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
		$transfers = Transfer::where('status', 1)->orderBy('name', 'ASC')->get();
		$zones = Zone::where('status', 1)->orderBy('name', 'ASC')->get();
		$allDays = 0;
		$days = [];
		if($record->availability == 'All')
		{
			$allDays = 1;
		}
		else
		{
			$days = explode(",",$record->availability);
		}
		
		$zonesData = json_decode($record->zones);
		
		
		$images = '["';
		$image_key = [];
        if($record->images != ''){
            $image_path = [];
            $image_key = [];
            foreach($record->images as $image){
                $image_path[] = asset('/uploads/activities/' . $image->filename);
                $image_key[] = $image->id;
            }

            $images .= implode('","', $image_path );
        }
        $images .= '"]';
		
		return view('activities.edit',compact('record','typeActivities','transfers','zones','allDays','days','zonesData','images', 'image_key'));
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
			'description' => 'required',
			'type_activity' => 'required',
			'code' => 'required',
			'featured_image' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			'image' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),
        ], [
		'featured_image.max' => 'The featured image must not be greater than '.$options['allow_img_size'].' MB.',
            'title.sanitize_scripts' => 'Invalid value entered for title field.',
        ]);

        $record = Activity::find($id);
		//check featured_image
        if($request->hasfile('featured_image')){
            $image = $request->file('featured_image');
			$old = '';
			if($record->image != 'no-image.png'){
				$old = $record->image;
			}
			
			$record->image = $this->uploadImages($image,$old);
        }
		$allday = ($request->input('AllDay'))?$request->input('AllDay'):'';
		$weekdays = ($request->input('day'))?$request->input('day'):[];
		
		if($allday == 'All')
		{
			$record->availability = $allday;
		}
		else
		{
			if(count($weekdays) > 0)
			{
				$days = implode(",",$weekdays);
				$record->availability = $days;
			}
		}
		
		$sic_TFRS = $request->input('sic_TFRS');
		
		if($sic_TFRS == 1)
		{
			$zones = $request->input('zones');
			$zoneValue = $request->input('zoneValue');
			$zoneArray = [];
			foreach($zones as $k => $z)
			{
				$zoneArray[] = [
				'zone' => $z,
				'zoneValue' => $zoneValue[$k],
				];
			}
			
			$zoneArrayJson = json_encode($zoneArray);
			$record->zones = $zoneArrayJson;
		}
		
		$record->sic_TFRS = $sic_TFRS;
        $record->title = $request->input('title');
		$record->type_activity = $request->input('type_activity');
		$record->code = $request->input('code');
		$record->entry_type = $request->input('entry_type');
		$record->priror_booking_time = $request->input('priror_booking_time');
		$record->vat = $request->input('vat');
		$record->black_sold_out = $request->input('black_sold_out');
		$record->is_opendated = $request->input('is_opendated');
		$record->valid_till = ($request->input('is_opendated')==1)?$request->input('valid_till'):'';
		$record->pvt_TFRS = $request->input('pvt_TFRS');
		$record->transfer_plan = ($request->input('pvt_TFRS')==1)?$request->input('transfer_plan'):0;
		$record->inclusion = $request->input('inclusion');
		$record->exclusion = $request->input('exclusion');
		$record->description = $request->input('description');
		$record->cancellation_policy = $request->input('cancellation_policy');
        $record->status = $request->input('status');
        $record->save();
		
		//Upload Additional images
        if($request->hasfile('image'))
        {
           foreach($request->file('image') as $file)
           {
				$additional_filename = $this->uploadImages($file);
				$original_name = $file->getClientOriginalName();
				$data['filename'] = $additional_filename;
				$data['model_id'] = $record->id;
				$data['model'] = "Activity";
				$add_image = Files::create($data);
            }
        }
		
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
	
	
	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPriceForm($id)
    {
		$activity = Activity::find($id);
        return view('activities.create_prices',compact('activity'));
    }
	
	
	
    public function editPriceForm($id)
    {
		$activity = Activity::find($id);
		$priceData = ActivityPrices::where('activity_id',$id)->get();
		
        return view('activities.edit_prices',compact('activity','priceData'));
    }
	
	 /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	 
    public function activityPriceSave(Request $request)
    {
		
		//print_r($request->all());
		//exit;
		$act = Activity::find($request->input('activity_id'));
		
		$variant_name = $request->input('variant_name');
		$variant_code = $request->input('variant_code');
		$slot_duration = $request->input('slot_duration');
		$activity_duration = $request->input('activity_duration');
		$end_time = $request->input('end_time');
		$start_time = $request->input('start_time');
		$rate_valid_from = $request->input('rate_valid_from');
		$rate_valid_to = $request->input('rate_valid_to');
		$adult_rate_without_vat = $request->input('adult_rate_without_vat');
		$adult_rate_with_vat = $request->input('adult_rate_with_vat');
		$adult_max_no_allowed = $request->input('adult_max_no_allowed');
		$adult_min_no_allowed = $request->input('adult_min_no_allowed');
		$adult_start_age = $request->input('adult_start_age');
		$adult_end_age = $request->input('adult_end_age');
		$chield_rate_without_vat = $request->input('chield_rate_without_vat');
		$chield_rate_with_vat = $request->input('chield_rate_with_vat');
		$chield_max_no_allowed = $request->input('chield_max_no_allowed');
		$chield_min_no_allowed = $request->input('chield_min_no_allowed');
		$chield_start_age = $request->input('chield_start_age');
		$chield_end_age = $request->input('chield_end_age');
		$infant_rate_without_vat = $request->input('infant_rate_without_vat');
		$infant_rate_with_vat = $request->input('infant_rate_with_vat');
		$infant_max_no_allowed = $request->input('infant_max_no_allowed');
		$infant_min_no_allowed = $request->input('infant_min_no_allowed');
		$infant_start_age = $request->input('infant_start_age');
		$infant_end_age = $request->input('infant_end_age');
		
		$booking_window_valueto = $request->input('booking_window_valueto');
		$cancellation_value_to = $request->input('cancellation_value_to');
		$booking_window_valueSIC = $request->input('booking_window_valueSIC');
		$cancellation_valueSIC = $request->input('cancellation_valueSIC');
		$booking_window_valuePVT = $request->input('booking_window_valuePVT');
		$cancellation_valuePVT = $request->input('cancellation_valuePVT');
		$data = [];
		foreach($variant_name as $k => $v)
		{
			$data[] = [
					'activity_id' => $request->input('activity_id'),
                    'variant_name' => $v,
					'variant_code' => $variant_code[$k],
                    'slot_duration' => $slot_duration[$k],
					'activity_duration' => $activity_duration[$k],
					'start_time' => $start_time[$k],
					'end_time' => $end_time[$k],
					'rate_valid_from' => $rate_valid_from[$k],
					'rate_valid_to' => $rate_valid_to[$k],
					'adult_rate_without_vat' => $adult_rate_without_vat[$k],
					'adult_rate_with_vat' => $adult_rate_with_vat[$k],
					'adult_max_no_allowed' => $adult_max_no_allowed[$k],
					'adult_min_no_allowed' => $adult_min_no_allowed[$k],
					'adult_start_age' => $adult_start_age[$k],
					'adult_end_age' => $adult_end_age[$k],
					'chield_rate_without_vat' => $chield_rate_without_vat[$k],
					'chield_rate_with_vat' => $chield_rate_with_vat[$k],
					'chield_max_no_allowed' => $chield_max_no_allowed[$k],
					'chield_min_no_allowed' => $chield_min_no_allowed[$k],
					'chield_start_age' => $chield_start_age[$k],
					'chield_end_age' => $chield_end_age[$k],
					
					'infant_rate_without_vat' => $infant_rate_without_vat[$k],
					'infant_rate_with_vat' => $infant_rate_with_vat[$k],
					'infant_max_no_allowed' => $infant_max_no_allowed[$k],
					'infant_min_no_allowed' => $infant_min_no_allowed[$k],
					'infant_start_age' => $infant_start_age[$k],
					'infant_end_age' => $infant_end_age[$k],
					
					'booking_window_valueto' => $booking_window_valueto[$k],
					'cancellation_value_to' => $cancellation_value_to[$k],
					'booking_window_valueSIC' => $booking_window_valueSIC[$k],
					'cancellation_valueSIC' => $cancellation_valueSIC[$k],
					'booking_window_valuePVT' => $booking_window_valuePVT[$k],
					'cancellation_valuePVT' => $cancellation_valuePVT[$k],
					
                ];
		}
		if(count($data) > 0)
		{
			ActivityPrices::where("activity_id",$request->input('activity_id'))->delete();
			ActivityPrices::insert($data);
			$act->is_price = 1;
			$act->save();
		}
		else
		{
			$act->is_price = 0;
			$act->save();
		}
		
		
        return redirect('activities')->with('success', 'Activity Created Successfully.');
    }
	
	/**
     * Specified  from upload company images and remove if already uploaded.
     *
     */
    public function uploadImages($file, $old ='')
    {
        $dest_fullfile = public_path('/uploads/activities/');
        $dest_thumb = public_path('/uploads/activities/thumb/');
        File::isDirectory($dest_fullfile) or File::makeDirectory($dest_fullfile,  0777, true, true);
        File::isDirectory($dest_thumb) or File::makeDirectory($dest_thumb,  0777, true, true);
        if(!empty($old) && File::exists($dest_fullfile.$old)){
            File::delete($dest_fullfile.$old);
            if(File::exists($dest_thumb .$old)){
                File::delete($dest_thumb .$old);
            }
        }
        $imgFile = Image::make($file->getRealPath());
        $imagename = time().rand(10,1000) . '.'. $file->getClientOriginalExtension();
        $imgFile->save($dest_fullfile . $imagename);
        $imgFile->resize(360, 250, function ($constraint) {
            $constraint->aspectRatio();
        })->save($dest_thumb . $imagename);
        return $imagename;
    }
	
	public function newRowAddmore(Request $request)
    {
		$activity_id = $request->input('activity_id');
		$rowCount = $request->input('rowCount');
		$activity = Activity::find($activity_id);
		$view = view("activities.addmore_prices",['rowCount'=>$rowCount,'activity'=>$activity])->render();
         return response()->json(['success' => 1, 'html' => $view]);
    }
}