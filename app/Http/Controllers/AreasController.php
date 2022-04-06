<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\UserAreaRelation;
use Illuminate\Http\Request;

class AreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::orderBy('created_at', 'DESC')->get();
        return view('areas.index', compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('areas.create');
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
            'title'=>'required|max:255|sanitizeScripts',
            'zip_code'=>'required|min:5|max:50|sanitizeScripts'
        ], [
			'title.sanitize_scripts' => 'Invalid value entered for Title field.',
            'zip_code.sanitize_scripts' => 'Invalid value entered for ZIP Code field.',
		]);

        $area = new Area();
        $area->title = $request->input('title'); 
        $area->zip_code = $request->input('zip_code');         
        //pr($area); die;
        $area->save();
        return redirect('areas')->with('success','Area Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $area = Area::find($id);
        return view('areas.edit')->with('area',$area);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'=>'required|max:255|sanitizeScripts',
            'zip_code'=>'required|sanitizeScripts|min:5|max:50',
            'status'=>'required'
        ], [
			'title.sanitize_scripts' => 'Invalid value entered for Title field.',
            'zip_code.sanitize_scripts' => 'Invalid value entered for ZIP Code field.',
		]);

        $area = Area::find($id);
        $area->title = $request->input('title');
        $area->zip_code = $request->input('zip_code'); 
        $area->status = $request->input('status');
        $area->save();
        return redirect('areas')->with('success','Area Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area = Area::find($id);

        $cnts = UserAreaRelation::where(['area_id' => $id])->get()->count();

        if($cnts > 0){
            return redirect('areas')->with('error', 'You can\'t delete this. This area has been used already.');
        }else{
            $area->delete();
            return redirect('areas')->with('success', 'Area Deleted.');
        }
    }
}
