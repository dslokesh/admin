<?php
namespace App\Http\Controllers;

use App\Models\Variant;
use App\Models\Transfer;
use App\Models\Zone;
use App\Models\Files;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Image;
use File;

class VariantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	 
    public function index(Request $request)
    {
		//$this->checkPermissionMethod('list.activity');
        $data = $request->all();
		$typeActivities = config("constants.typeActivities"); 
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = Variant::where('id','!=', null);
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
        return view('variants.index', compact('records'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$this->checkPermissionMethod('list.activity');
		$typeActivities = config("constants.typeActivities"); 
		$transfers = Transfer::where('status', 1)->orderBy('name', 'ASC')->get();
		$zones = Zone::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('variants.create',compact('typeActivities','transfers','zones'));
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
			'entry_type' => 'required',
			'code' => 'required',
			'featured_image' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			'brand_logo' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			'image.*' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
        ], [
            'title.sanitize_scripts' => 'Invalid value entered for title field.',
			'image.*.max' => 'The image must not be greater than '. $options['allow_img_size'] .' MB.',
			'featured_image.max' => 'The featured image must not be greater than '.$options['allow_img_size'].' MB.',
			'brand_logo.max' => 'The brand logo must not be greater than '.$options['allow_img_size'].' MB.',
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
			$pickup_time = $request->input('pickup_time');
			$dropup_time = $request->input('dropup_time');
			$zoneArray = [];
			foreach($zones as $k => $z)
			{
				$zoneArray[] = [
				'zone' => $z,
				'zoneValue' => $zoneValue[$k],
				'pickup_time' => $pickup_time[$k],
				'dropup_time' => $dropup_time[$k],
				];
			}
			
			$zoneArrayJson = json_encode($zoneArray);
			$record->zones = $zoneArrayJson;
		}
		else
		{
			$record->zones = '';
		}
		
		if($request->hasfile('brand_logo')){
            $image = $request->file('brand_logo');
			$record->brand_logo = $this->uploadImages($image);
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
		$record->priror_booking_time = 1;
		$record->vat = $request->input('vat');
		$record->black_sold_out = $request->input('black_sold_out');
		$record->is_opendated = $request->input('is_opendated');
		$record->valid_till = ($request->input('is_opendated')==1)?$request->input('valid_till'):'';
		$record->pvt_TFRS = $request->input('pvt_TFRS');
		$record->pvt_TFRS_text = $request->input('pvt_TFRS_text');
		$record->pick_up_required = $request->input('pick_up_required');
		$record->transfer_plan = ($request->input('pvt_TFRS')==1)?$request->input('transfer_plan'):0;
		$record->inclusion = $request->input('inclusion');
		$record->exclusion = $request->input('exclusion');
		$record->description = $request->input('description');
		$record->cancellation_policy = $request->input('cancellation_policy');
		$record->booking_policy = $request->input('booking_policy');
        $record->status = $request->input('status');
		$record->created_by = Auth::user()->id;
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
        return redirect()->route('variants.prices.create',$record->id)->with('success', 'Activity Created Successfully.');
		} else {
        return redirect('variants')->with('success', 'Activity Created Successfully.');
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
		$this->checkPermissionMethod('list.activity');
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
				'pickup_time' => (!empty($z->pickup_time))?$z->pickup_time:'',
				'dropup_time' => (!empty($z->dropup_time))?$z->dropup_time:'',
				];
			}
			
			
		}
		
		$priceData = ActivityPrices::where('activity_id',$activity->id)->get();
		
         return view('variants.view')->with(['activity' => $activity,'typeActivities'=>$typeActivities,'zoneArray'=>$zoneArray,'priceData'=>$priceData]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$this->checkPermissionMethod('list.activity');
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
		
		return view('variants.edit',compact('record','typeActivities','transfers','zones','allDays','days','zonesData','images', 'image_key'));
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
			'entry_type' => 'required',
			'code' => 'required',
			'featured_image' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			'brand_logo' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			//'image' => 'nullable|image|max:' . ($options['allow_img_size'] * 1024),
			'image.*' => 'nullable|mimes:jpeg,jpg,png|max:' . ($options['allow_img_size'] * 1024),
        ], [
		'featured_image.max' => 'The featured image must not be greater than '.$options['allow_img_size'].' MB.',
		'brand_logo.max' => 'The brand logo must not be greater than '.$options['allow_img_size'].' MB.',
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
		
		if($request->hasfile('brand_logo')){
            $brand_logoimage = $request->file('brand_logo');
			$old = '';
			if($record->brand_logo != 'no-image.png'){
				$old = $record->brand_logo;
			}
			
			$record->brand_logo = $this->uploadImages($brand_logoimage,$old);
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
			$pickup_time = $request->input('pickup_time');
			$dropup_time = $request->input('dropup_time');
			$zoneArray = [];
			foreach($zones as $k => $z)
			{
				$zoneArray[] = [
				'zone' => $z,
				'zoneValue' => $zoneValue[$k],
				'pickup_time' => $pickup_time[$k],
				'dropup_time' => $dropup_time[$k],
				];
			}
			
			$zoneArrayJson = json_encode($zoneArray);
			$record->zones = $zoneArrayJson;
		}
		else
		{
			$record->zones = '';
		}
		
		
		$record->sic_TFRS = $sic_TFRS;
        $record->title = $request->input('title');
		$record->type_activity = $request->input('type_activity');
		$record->code = $request->input('code');
		$record->entry_type = $request->input('entry_type');
		$record->priror_booking_time = 1;
		$record->vat = $request->input('vat');
		$record->black_sold_out = $request->input('black_sold_out');
		$record->is_opendated = $request->input('is_opendated');
		$record->valid_till = ($request->input('is_opendated')==1)?$request->input('valid_till'):'';
		$record->pvt_TFRS = $request->input('pvt_TFRS');
		$record->transfer_plan = ($request->input('pvt_TFRS')==1)?$request->input('transfer_plan'):0;
		$record->pvt_TFRS_text = $request->input('pvt_TFRS_text');
		$record->pick_up_required = $request->input('pick_up_required');
		$record->inclusion = $request->input('inclusion');
		$record->exclusion = $request->input('exclusion');
		$record->description = $request->input('description');
		$record->cancellation_policy = $request->input('cancellation_policy');
		$record->booking_policy = $request->input('booking_policy');
        $record->status = $request->input('status');
		$record->updated_by = Auth::user()->id;
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
	
	
	
}