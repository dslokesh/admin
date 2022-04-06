<?php

namespace App\Http\Controllers;

use App\Models\UserAreaRelation;
use App\Models\User;
use App\Models\Area;
use Illuminate\Http\Request;

class UserAreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
        $userid = $request->get('userid');
        $user = User::find($userid);
        $userareas = UserAreaRelation::where('user_id', $userid)->get();
        //pr($userareas); die;
        return view('userareas.index', compact('user','userareas')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $userid = $request->get('userid');
        $user = User::find($userid);
        $areas = Area::where(['status' => 1])->orderBy('title', 'ASC')->get();
        return view('userareas.create', compact('areas', 'user'));
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
            'area_id' => 'required',
        ]);

        $cntuas = UserAreaRelation::where(['user_id' => $request->input('user_id'), 'area_id' => $request->input('area_id')])->get()->count();
        if($cntuas > 0){
            return redirect('userareas/create?userid='.$request->input('user_id'))->with('error', 'This area has been assigned already.');
        }
        $userarea = new UserAreaRelation();
        $userarea->user_id = $request->input('user_id'); 
        $userarea->area_id = $request->input('area_id'); 
        //pr($userarea); die;
        $userarea->save();

        return redirect('userareas?userid='.$request->input('user_id'))->with('success','User\'s area Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAreaRelation  $userAreaRelation
     * @return \Illuminate\Http\Response
     */
    public function show(UserAreaRelation $userAreaRelation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAreaRelation  $userAreaRelation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $userarea = UserAreaRelation::find($id);
        $user = User::find($userarea->user_id);
        $areas = Area::where(['status' => 1])->orderBy('title', 'ASC')->get();
        return view('userareas.edit', compact('areas', 'user', 'userarea'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAreaRelation  $userAreaRelation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'area_id' => 'required',
        ]);

        $userarea = UserAreaRelation::find($id);
        $userarea->user_id = $request->input('user_id');
        $userarea->area_id = $request->input('area_id');
        $userarea->save();
        return redirect('userareas?userid='.$request->input('user_id'))->with('success','User\'s area Updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAreaRelation  $userAreaRelation
     * @return \Illuminate\Http\Response
     */
    //public function destroy(UserAreaRelation $userAreaRelation)
    public function destroy($id)
    {
        $userAreaRel = UserAreaRelation::find($id);
        $user_id = $userAreaRel->user_id;
        $userAreaRel->delete();
        return redirect('userareas?userid='.$user_id)->with('success', 'User\'s area Deleted.');
    }
}
