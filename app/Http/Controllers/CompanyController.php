<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$companies = Company::orderBy('created_at', 'DESC')->get();
         //return view('companies.index', compact('companies'));

         return view('companies.index'); 
    }

       /*
   AJAX request
   */
   public function getCompanies(Request $request){


        //pr($request); die;
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page
  

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Company::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Company::select('count(*) as allcount')->where('name', 'like', '%' .$searchValue . '%')->count();

        // Fetch records
        $records = Company::orderBy($columnName,$columnSortOrder)
        ->where('companies.name', 'like', '%' .$searchValue . '%')
        ->select('companies.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();

        $data_arr = array();
            foreach($records as $record){
                $getEleDelId = 'delete-form-'.$record->id;
                $html = '';
                $html.='<a class="btn btn-info btn-sm" href="'.route('companies.edit',$record->id).'"> <i class="fas fa-pencil-alt"></i>Edit </a>';
                $html.='<form id="delete-form-'.$record->id.'" method="post" action="'.route('companies.destroy',$record->id).'" style="display:none;">'.csrf_field().'
                '.method_field("DELETE").'</form>';
                $html.=' <a class="btn btn-danger btn-sm" href="javascript:void(0)" onclick="if(confirm('."'Are you sure, You want to delete this?'".')){ event.preventDefault(); document.getElementById('."'".$getEleDelId."'".').submit(); }else{ event.preventDefault(); }"><i class="fas fa-trash"></i>Delete</a>';
                $data_arr[] = array(
                    "id" => ++$start,
                    "name" => $record->name,
                    "status" => $record->status ? 'Active' : 'Inactive',
                    "created_at" => $record->created_at ? date(config('app.date_format'),strtotime($record->created_at)) : null,
                    "updated_at" => $record->updated_at ? date(config('app.date_format'),strtotime($record->updated_at)) : null,
                    "action" =>$html
                );
            }

        $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
        );

        echo json_encode($response);
        exit;
  }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
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
            'name'=>'required|max:255|sanitizeScripts|unique:companies'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $company = new Company();
        $company->name = $request->input('name');       
        //pr($company); die;
        $company->save();
        return redirect('companies')->with('success','Company Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
  
        $company = Company::find($id);
        return view('companies.edit')->with('company',$company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|max:255|sanitizeScripts|unique:companies,name,' .$id,
            'status'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $company = Company::find($id);
        $company->name = $request->input('name');
        $company->status = $request->input('status');
        $company->save();
        return redirect('companies')->with('success','Company Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);

        $cnts = User::where(['company_id' => $id])->get()->count();

        if($cnts > 0){
            return redirect('companies')->with('error', 'You can\'t delete this. This company has been used already.');
        }else{

            $company->delete();
            return redirect('companies')->with('success', 'Company Deleted.');
        }
    }
}
