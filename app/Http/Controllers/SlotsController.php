<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\Request;
use DB;
class SlotsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		//$this->checkPermissionMethod('list.hotlecat');
        $records = Slot::orderBy('created_at', 'DESC')->get();
		
        return view('slots.index', compact('records'));

    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		//$this->checkPermissionMethod('list.hotlecat');
        return view('slots.create');
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
            'slot_type' => 'required',
            'custom_slot' => ($request->slot_type == 1) ? 'required' : '',
            'duration' => ($request->slot_type == 2) ? 'required|integer' : '',
        ], [
            'name.sanitize_scripts' => 'Invalid value entered for Name field.',
            'custom_slot.required' => 'Custom time slot is required when Slot Type is Custom.',
            'duration.required' => 'Duration is required when Slot Type is Auto.',
        ]);
		
        $start_time = strtotime('00:00');
        $end_time = strtotime('24:00');
		$slot_type = $request->input('slot_type');
        $custom_slot = $request->input('custom_slot');
        $slots = [];
        if($slot_type==1){
            $slots = explode(',', $custom_slot);
        } else if($slot_type==2){
            $duration = $request->input('duration');
           
            while ($start_time < $end_time) {
                $slot_end_time = strtotime("+{$duration} minutes", $start_time);
                if ($slot_end_time > $end_time) {
                    $slot_end_time = $end_time;
                }
            
                $start_time_formatted = date('H:i', $start_time);
                $end_time_formatted = date('H:i', $slot_end_time);
            
                $slots[] = "$start_time_formatted - $end_time_formatted";
            
                $start_time = $slot_end_time;
            
                if ($start_time == $end_time) {
                    break;
                }
            }
         }
dd($slots);
        $record = new Slot();
        $record->slot_type = $request->input('slot_type');
		 $record->status = $request->input('status');
        $record->save();
        return redirect('slots')->with('success','Hotel Category Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
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
		//$this->checkPermissionMethod('list.hotlecat');
        $record = Slot::find($id);
        return view('slots.edit')->with('record',$record);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slot  $Slot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required|max:255|sanitizeScripts|unique:slots,name,' .$id,
            'status'=>'required'
        ], [
			'name.sanitize_scripts' => 'Invalid value entered for Name field.',
		]);

        $record = Slot::find($id);
        $record->name = $request->input('name');
        $record->status = $request->input('status');
        $record->save();
        return redirect('slots')->with('success','Hotel Category Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Slot::find($id);
        $record->delete();
        return redirect('slots')->with('success', 'Hotel Category Deleted.');
    }
	
}
