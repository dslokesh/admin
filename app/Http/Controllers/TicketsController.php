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
use Illuminate\Support\Facades\Log;
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

	public function ticketGenerate(Request $request, $id)
    {
		$voucherActivity = VoucherActivity::find($id);
		$adult = $voucherActivity->adult;
		$child = $voucherActivity->child;
		$totalTicket = $adult+$child;
		$counter = 0;
		$ticketCount = Ticket::where('ticket_generated','0')->where('activity_id',$voucherActivity->activity_id)->where('activity_variant',$voucherActivity->variant_unique_code)->whereDate('valid_from', '<=',$voucherActivity->tour_date)->whereDate('valid_till', '>=',$voucherActivity->tour_date)->count();
		if($ticketCount >= $totalTicket)
		{
			for($c = 1; $c<=$totalTicket;$c++){
				$ticketB = Ticket::where('ticket_for','Both')->where('ticket_generated','0')->where('activity_id',$voucherActivity->activity_id)->where('activity_variant',$voucherActivity->variant_unique_code)->whereDate('valid_from', '<=',$voucherActivity->tour_date)->whereDate('valid_till', '>=',$voucherActivity->tour_date)->first();
					if(!empty($ticketB)){
						if($counter != $totalTicket)
						{
						$ticketB->voucher_activity_id = $voucherActivity->id;
						$ticketB->ticket_generated = 1;
						$ticketB->voucher_id = $voucherActivity->voucher_id;
						$ticketB->save();
						$counter++;
						}
					}
			}
		
			if($counter != $totalTicket)
			{
				for($a = 1; $a<=$adult;$a++){
				$ticketA = Ticket::where('ticket_for','Adult')->where('ticket_generated','0')->where('activity_id',$voucherActivity->activity_id)->where('activity_variant',$voucherActivity->variant_unique_code)->whereDate('valid_from', '<=',$voucherActivity->tour_date)->whereDate('valid_till', '>=',$voucherActivity->tour_date)->first();
				
					if(!empty($ticketA)){
						if($counter != $totalTicket)
						{
						$ticketA->voucher_activity_id = $voucherActivity->id;
						$ticketA->ticket_generated = 1;
						$ticketA->voucher_id = $voucherActivity->voucher_id;
						$ticketA->save();
						$counter++;
						}
					}
				}
			}
			
			if($counter != $totalTicket)
			{
				for($c = 1; $c<=$child;$c++){
				$ticketC = Ticket::where('ticket_for','Child')->where('ticket_generated','0')->where('activity_id',$voucherActivity->activity_id)->where('activity_variant',$voucherActivity->variant_unique_code)->whereDate('valid_from', '<=',$voucherActivity->tour_date)->whereDate('valid_till', '>=',$voucherActivity->tour_date)->first();
					if(!empty($ticketC)){
						if($counter != $totalTicket)
						{
							$ticketC->voucher_activity_id = $voucherActivity->id;
							$ticketC->ticket_generated = 1;
							$ticketC->voucher_id = $voucherActivity->voucher_id;
							$ticketC->save();
							$counter++;
						}
					}
				}
			}
			
			if($counter > 0){
				$voucherActivity->ticket_generated = 1;
				$voucherActivity->save();
				return redirect()->back()->with('success', 'Ticket has been generated successfully.');	
			} else {
			return redirect()->back()->with('error', 'Ticket Not Generate.');
			}

		}
		else{
			return redirect()->back()->with('error', 'Total Ticket Not Available.');
		}
		
		
    }
	
	public function ticketDwnload(Request $request, $id)
    {
		$voucherActivity = VoucherActivity::find($id);
		$voucher = Voucher::where('id',$voucherActivity->voucher_id)->first();;
		$tickets = Ticket::where('activity_id',$voucherActivity->activity_id)->where('activity_variant',$voucherActivity->variant_unique_code)->where('voucher_activity_id',$voucherActivity->id)->where('ticket_generated','1')->get();
		//dd($voucherActivity->activity);
		//return view('tickets.ticketPdf', compact('voucherActivity','tickets','voucher'));
        $voucherActivity->ticket_downloaded = 1;
		$voucherActivity->save();
		foreach($tickets as $ticket){
		$ticket->ticket_downloaded = 1;
		$ticket->save();
		}
        $pdf = SPDF::loadView('tickets.ticketPdf', compact('voucherActivity','tickets','voucher'));
       $pdf->setPaper('A4')->setOrientation('portrait');
        return $pdf->download('Ticket'.$voucherActivity->variant_unique_code.'.pdf');
	}
    
    
    public function create(){
		//
    }

    
    public function store(Request $request){
		
        //
    }

    public function show(Ticket $ticket){
		//
    }

   
    public function edit($id){
       //
        
    }

   
    public function update(Request $request, $id){
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
			$terms_and_conditions = $request->input('terms_and_conditions');
		
			$file = $request->file('uploaded_file_csv');
			if ($file) {
				$f = $file->getClientOriginalName();
				$filename = time().$f;
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
				$location = 'uploads/csv'; //Created an "uploads" folder for that
				// Upload file
				$file->move($location, $filename);
				// In case the uploaded file path is to be stored in the database 
				$filepath = public_path($location . "/" .$filename);
				// Reading file
				$file = fopen($filepath, "r");
				$importData_arr = array(); // Read through the file and store the contents as an array
				$i = 0;
				//Read the contents of the uploaded file 
				while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
					$dateStr = $filedata[2];
					$dateStr2 = $filedata[3];

                // Custom function to parse dates with single-digit day values
                $date = $this->parseDate($dateStr);
                $date2 = $this->parseDate($dateStr2);

                // Check if parsing was successful before assigning the formatted dates
				
                if ($date && $date2) {
                    $filedata[2] = $date->format('Y-m-d');
                    $filedata[3] = $date2->format('Y-m-d');
                } else {
                    Log::error("Error parsing dates '{$dateStr}' or '{$dateStr2}'");
                }
				
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
				
				
				
				
				
				$valid_from = (isset($importData[2]))?$importData[2]:'';
				$valid_till = (isset($importData[3]))?$importData[3]:'';

				//echo "<pre>";
				//print_r($importData);
				//exit;
				if(empty($valid_from) OR empty($valid_till)){
					//return redirect()->back()->withInput()->with('error', 'The from date and till date  is required.');
				}
				$data[] = [
					'ticket_for' => $ticket_for,	
					'type_of_ticket' => $type_of_ticket,	
					'activity_id' => $activity_id,	
					'activity_variant' => $activity_variant,	
					'terms_and_conditions' => $terms_and_conditions,	
					'ticket_no' => $ticket_no,
					'serial_number' => $serial_number,
                    'valid_from' => $valid_from,
					'valid_till' => $valid_till,
				];
				
				}
				
				/* return response()->json([
				'message' => "$j records successfully uploaded"
				]); */
				
				
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
	
	 private function parseDate($dateStr)
    {
        // Array of date formats to support
        $dateFormats = [
            'd/m/Y', // Format: dd/mm/yyyy
            'm/d/Y', // Format: mm/dd/yyyy
			'Y/m/d', // Format: yyyy/mm/dd
            'Y-m-d', // Format: yyyy-mm-dd
			'd-m-Y', // Format: dd-mm-yyyy
			'm-d-Y', // Format: mm-dd-yyyy
        ];

        foreach ($dateFormats as $dateFormat) {
            $parsedDate = \DateTime::createFromFormat($dateFormat, $dateStr);
            if ($parsedDate !== false) {
                return Carbon::instance($parsedDate);
            }
        }

        return null;
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
