<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\User;
use App\Models\Activity;
use App\Models\ActivityPrices;
use App\Models\AgentPriceMarkup;
use Illuminate\Http\Request;
use App\Models\VoucherActivity;
use Illuminate\Support\Facades\Response;
use App\Models\Ticket;
use DB;
use SiteHelpers;
use Carbon\Carbon;
use SPDF;
use Illuminate\Support\Facades\Auth;
use App\Models\AgentAmount;
use Validator;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		 $perPage = config("constants.ADMIN_PAGE_LIMIT");
		 $data = $request->all();
		$query = Ticket::where('id','!=', null);
		if (isset($data['ticket_no']) && !empty($data['ticket_no'])) {
            $query->where('ticket_no', $data['ticket_no']);
        } if (isset($data['serial_number']) && !empty($data['serial_number'])) {
             $query->where('serial_number', $data['serial_number']);
        }if (isset($data['valid_from']) && !empty($data['valid_from'])) {
            $query->whereDate('valid_from', '>=',$data['valid_from']);
        }if (isset($data['valid_till']) && !empty($data['valid_till'])) {
            $query->whereDate('valid_till', '<=',$data['valid_till']);
        }
        $records = $query->orderBy('created_at', 'DESC')->paginate($perPage);
		$agetid = '';
		$agetName = '';
		
        return view('tickets.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
        //
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $Ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
		//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       //
		
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $Ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $Voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Ticket::find($id);
        $record->delete();
        return redirect('tickets')->with('success', 'Ticket Deleted.');
    }
	
	public function csvUploadForm()
    {
		$activities = Activity::where('status', 1)->orderBy('title', 'ASC')->get();
		return view('tickets.csv-upload',  compact('activities'));
    }
	
	/**
     * Upload the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
	public function csvUploadPost(Request $request)
    {
		$validator = Validator::make($request->all(), [
            'ticket_for' => 'required',
			'type_of_ticket' => 'required',
			'activity_id' => 'required',
			'activity_variant' => 'required',
            
        ]);
		
		// if the validator fails, redirect back to the form
		$data = [];
		$j = 0;
        if ($validator->fails()) {    
            
            return redirect()->back()
                ->withErrors($validator) // send back all errors to the form
                ->withInput();
        } else {
            
			$ticket_for = $request->input('ticket_for');
			$type_of_ticket = $request->input('type_of_ticket');
			$activity_id = $request->input('activity_id');
			$activity_variant = $request->input('activity_variant');
		
			$file = $request->file('uploaded_file_csv');
			if ($file) {
				$filename = $file->getClientOriginalName();
				$extension = $file->getClientOriginalExtension(); //Get extension of uploaded file
				$tempPath = $file->getRealPath();
				$fileSize = $file->getSize(); //Get size of uploaded file in bytes
				//Check for file extension and size
				$returnData = $this->checkUploadedFileProperties($extension, $fileSize);
				if($returnData == 1){
					return redirect()->back()->withInput()->with('error', 'Please upload valid csv file.');
				}elseif($returnData == 2){
					return redirect()->back()->withInput()->with('error', 'Invalid file extension.');
				}
				//Where uploaded file will be stored on the server 
				$location = 'uploads'; //Created an "uploads" folder for that
				// Upload file
				$file->move($location, $filename);
				// In case the uploaded file path is to be stored in the database 
				$filepath = public_path($location . "/" . $filename);
				// Reading file
				$file = fopen($filepath, "r");
				$importData_arr = array(); // Read through the file and store the contents as an array
				$i = 0;
				//Read the contents of the uploaded file 
				while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
				$num = count($filedata);
				// Skip first row (Remove below comment if you want to skip the first row)
				if ($i == 0) {
				$i++;
				continue;
				}
				for ($c = 0; $c < $num; $c++) {
				if(!empty($filedata[$c][0]))
				{
				$importData_arr[$i][] = $filedata[$c];
				}
				}
				$i++;
				}
				fclose($file); //Close after reading
				$j = 0;
				
				foreach ($importData_arr as $importData) {
				$j++;
				$ticket_no = str_replace("'", "\'", $importData[0]);
				$ticket_no = str_replace('"', "'+String.fromCharCode(34)+'", $importData[0]);
				$serial_number = str_replace("'", "\'", $importData[1]);
				$serial_number = str_replace('"', "'+String.fromCharCode(34)+'", $importData[1]);
				

				$ticket_no = addslashes(trim(ucwords(strtolower($ticket_no))));
				$serial_number = addslashes(trim(ucwords(strtolower($serial_number))));
				$valid_from = date("Y-m-d",strtotime($importData[2]));
				$valid_till = date("Y-m-d",strtotime($importData[3]));
				$data[] = [
					'ticket_for' => $ticket_for,	
					'type_of_ticket' => $type_of_ticket,	
					'activity_id' => $activity_id,	
					'activity_variant' => $activity_variant,	
					'ticket_no' => $ticket_no,	
					'serial_number' => $serial_number,
                    'valid_from' => $valid_from,
					'valid_till' => $valid_till,
				];
				
				}
				/* return response()->json([
				'message' => "$j records successfully uploaded"
				]); */
				
				//print_r($data);
				//exit;
				if(count($data) > 0){
					Ticket::insert($data);
				}
				}
				else
				{
					return redirect()->back()->withInput()->with('error', 'Please upload valid csv file.');
				}
							         
            
            
           return redirect('tickets')->with('success', $j.' Records successfully uploaded.');
        }
		
		
    }
	
	public function checkUploadedFileProperties($extension, $fileSize)
	{
		$valid_extension = array("csv", "xlsx"); //Only want csv and excel files
		$maxFileSize = 2097152; // Uploaded file size limit is 2mb
		if (in_array(strtolower($extension), $valid_extension)) {
		if ($fileSize <= $maxFileSize) {
		} else {
		return 1;
		}
		} else {
			return 2;
		//throw new \Exception('Invalid file extension', '415'); //415 error
		}
		}
	
}