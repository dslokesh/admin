<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Supplier;
use App\Models\SupplierDetails;
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
        return view('suppliers.view', compact('supplier'));
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
            //** Below code for unlink old image **//
			$oldImage = public_path('/uploads/suppliers/'.$record->logo);
			$oldImageThumb = public_path('/uploads/suppliers/thumb/'.$record->logo);
			if(!empty($record->logo) && @getimagesize($oldImage) && file_exists($oldImage)) {
				unlink($oldImage);
				unlink($oldImageThumb);
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
}