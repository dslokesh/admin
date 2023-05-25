<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Supplier;
use App\Models\Activity;
use App\Models\ActivityPrices;
use App\Models\SupplierDetails;
use App\Models\SupplierPriceMarkup;
use Illuminate\Http\Request;
use DB;
use Image;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $perPage = config("constants.ADMIN_PAGE_LIMIT");
        $query = Supplier::with(['country', 'state', 'city']);
        if (isset($data['name']) && !empty($data['name'])) {
            $query->where('name', 'like', '%' . $data['name'] . '%');
        }
       
        if (isset($data['city_id']) && !empty($data['city_id'])) {
            $query->where('city_id', $data['city_id']);
        }
        if (isset($data['status']) && !empty($data['status'])) {
            if ($data['status'] == 1)
                $query->where('status', 1);
            if ($data['status'] == 2)
                $query->where('status', 0);
        }

        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);

        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();

        return view('suppliers.index', compact('records', 'countries', 'states', 'cities'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('suppliers.create', compact('countries'));
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
            'name' => 'required|max:255|sanitizeScripts',
            'mobile' => 'required',
            'address' => 'required',
			'email' => 'required|max:255|sanitizeScripts|email|unique:suppliers|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'zip_code' => 'required',
			'code' => 'required'
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
        ]);


		$input = $request->all();
        $record = new Supplier();
		 /** Below code for save image **/
		$destinationPath = public_path('/uploads/suppliers/');
       
		if ($request->hasFile('logo')) {

			$fileName = $input['logo']->getClientOriginalName();
			$file = request()->file('logo');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			$img = Image::make(public_path('/uploads/suppliers/'.$newName));
            $img->resize(100, 100, function($constraint) {
				$constraint->aspectRatio();
			});
			$img->save(public_path('/uploads/suppliers/thumb/'.$newName));
            $record->logo = $newName;
		}
		
        $record->name = $request->input('name');
		$record->code = $request->input('code');
        $record->mobile = $request->input('mobile');
		$record->email = $request->input('email');
		$record->company_name = $request->input('company_name');
		$record->department = $request->input('department');
		$record->phone_number = $request->input('phone_number');
        $record->address = $request->input('address');
        $record->zip_code = $request->input('zip_code');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->city_id = $request->input('city_id');
        $record->status = $request->input('status');
		
        $record->save();
        return redirect('suppliers')->with('success', 'Supplier Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
		$activity_ids = explode(",",$supplier->activity_id);
		
		$variants = [];
		$markups = [];
		foreach($activity_ids as $aid)
		{
			$activity = Activity::find($aid);
			$variants[$aid] = ActivityPrices::select('variant_code')->distinct()->where('activity_id',  $aid)->get()->toArray();
			
			foreach($variants[$aid] as $variant)
			{
				$m = SupplierPriceMarkup::where('supplier_id',  $supplier->id)->where('activity_id',  $aid)->where('variant_code',  $variant['variant_code'])->first();
				
				if(!empty($m))
				{
					$markups[$activity->title][$variant['variant_code']] = [
						'ticket_only'=>$m->ticket_only,
						'sic_transfer'=>$m->sic_transfer,
						'pvt_transfer'=>$m->pvt_transfer,
					];
				}
			}
			
		}
		
		
        return view('suppliers.view', compact('supplier','markups'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $record = Supplier::find($id);
        $countries = Country::where('status', 1)->orderBy('name', 'ASC')->get();
        $states = State::where('status', 1)->orderBy('name', 'ASC')->get();
        $cities = City::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('suppliers.edit')->with(['record' => $record, 'countries' => $countries, 'states' => $states, 'cities' => $cities]);
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
        $request->validate([
            'name' => 'required|max:255|sanitizeScripts',
            'mobile' => 'required',
            'address' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'country_id' => 'required',
            'zip_code' => 'required',
			'code' => 'required'
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
        ]);
		
		$input = $request->all();
        $record = Supplier::find($id);
		 /** Below code for save image **/
		$destinationPath = public_path('/uploads/suppliers/');
       
		if ($request->hasFile('logo')) {

			$fileName = $input['logo']->getClientOriginalName();
			$file = request()->file('logo');
			$fileNameArr = explode('.', $fileName);
			$fileNameExt = end($fileNameArr);
			$newName = date('His').rand() . time() . '.' . $fileNameExt;
			
			$file->move($destinationPath, $newName);
			$img = Image::make(public_path('/uploads/suppliers/'.$newName));
            $img->resize(250, 250, function($constraint) {
				$constraint->aspectRatio();
			});
			$img->save(public_path('/uploads/suppliers/thumb/'.$newName));
			if($record->logo != 'no-image.png'){
            //** Below code for unlink old image **//
			$oldImage = public_path('/uploads/suppliers/'.$record->logo);
			$oldImageThumb = public_path('/uploads/suppliers/thumb/'.$record->logo);
			
			if(!empty($record->logo) && @getimagesize($oldImage) && file_exists($oldImage)) {
				unlink($oldImage);
				unlink($oldImageThumb);
			}
			}
			
            $record->logo = $newName;
		}
        $record->name = $request->input('name');
		$record->code = $request->input('code');
        $record->mobile = $request->input('mobile');
		$record->email = $request->input('email');
		$record->company_name = $request->input('company_name');
		$record->department = $request->input('department');
		$record->phone_number = $request->input('phone_number');
        $record->address = $request->input('address');
        $record->zip_code = $request->input('zip_code');
        $record->country_id = $request->input('country_id');
        $record->state_id = $request->input('state_id');
        $record->city_id = $request->input('city_id');
        $record->status = $request->input('status');
		
        $record->save();
        return redirect('suppliers')->with('success', 'Supplier Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\State  $State
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Supplier::find($id);
        $record->delete();
        return redirect('suppliers')->with('success', 'Supplier Deleted.');
    }
	
	public function priceMarkupActivityList($id)
    {
		$supplierId = $id;
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $records = Activity::where('status', 1)->where('is_price', 1)->orderBy('title', 'ASC')->paginate($perPage);
		$supplier = Supplier::find($supplierId);
		$activity_ids = explode(",",$supplier->activity_id);
        return view('suppliers.priceActivities', compact('records','supplierId','activity_ids'));
    }
	
	public function priceMarkupActivitySave(Request $request)
    {
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $input = $request->all();
        $supplier = Supplier::find($request->input('supplier_id'));
		
		$activity_id = $request->input('activity_id');
		$data = [];
		if(!empty($activity_id))
		{
			foreach($activity_id as $k => $av)
			{
				$data[] = $av;
			}
			
			$jsonData = implode(",",$data);
			
			$supplier->activity_id = $jsonData;
			$supplier->save();
			return redirect()->route('suppliers.markup.price',[$request->input('supplier_id')])->with('success', 'Activity Saved.');
		}
		else
		{
			return redirect()->back()->with('error', 'Please select at least one activity.');
		}
        
		
        
        
    }
	
	public function markupPriceList($id)
    {
		$supplierId = $id;
		$supplier = Supplier::find($supplierId);
		$activity_ids = explode(",",$supplier->activity_id);
		$activities = Activity::whereIn('id', $activity_ids)->where(['status'=> 1,'is_price'=> 1])->get();
		$variants = [];
		$markups = [];
		foreach($activity_ids as $aid)
		{
			$variants[$aid] = ActivityPrices::select('variant_code')->distinct()->where('activity_id',  $aid)->get()->toArray();
			
			foreach($variants[$aid] as $variant)
			{
				$m = SupplierPriceMarkup::where('supplier_id',  $supplierId)->where('activity_id',  $aid)->where('variant_code',  $variant['variant_code'])->first();
				
				if(!empty($m))
				{
					$markups[$variant['variant_code']] = [
						'ticket_only'=>$m->ticket_only,
						'sic_transfer'=>$m->sic_transfer,
						'pvt_transfer'=>$m->pvt_transfer,
					];
				}
			}
			
		}
		
		
		
		/* print_r($markups);
		exit; */
        return view('suppliers.supplierPriceMarkup', compact('supplierId','activities','variants','markups'));
    }
	
	public function markupPriceSave(Request $request)
    {
		$perPage = config("constants.ADMIN_PAGE_LIMIT");
        $input = $request->all();
        $record = new SupplierPriceMarkup();
		$supplier_id = $request->input('supplier_id');
		$ticket_only = $request->input('ticket_only');
		$sic_transfer = $request->input('sic_transfer');
		$pvt_transfer = $request->input('pvt_transfer');
		$data = [];
		if(!empty($ticket_only))
		{
			foreach($ticket_only as $activity_id => $acv)
			{
				foreach($acv as $variant_code => $ac)
				{
				$data[] = [
				'supplier_id' => $supplier_id,
				'activity_id' => $activity_id,
				'variant_code' => $variant_code,
				'ticket_only' => $ac,
				'sic_transfer' => $sic_transfer[$activity_id][$variant_code],
				'pvt_transfer' => $pvt_transfer[$activity_id][$variant_code],
				];
				}
			}
		}
        
		if(count($data) > 0)
		{
			SupplierPriceMarkup::where("supplier_id",$supplier_id)->delete();
			SupplierPriceMarkup::insert($data);
			 return redirect('suppliers')->with('success', 'Markup saved successfully.');
		}
		else
		{
			 return redirect()->back()->with('error', 'Something went wrong.');
		}
		
    }
}