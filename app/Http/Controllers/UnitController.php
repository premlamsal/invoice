<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Resources\Unit as UnitResource;
use App\Unit;

class UnitController extends Controller
{
    public function index()
    {
        return UnitResource::collection(Unit::all());
    }

   
    public function store(Request $request)
    {
        $unit=new Unit();
        $unit->short_name=$request->input('short_name');
        $unit->long_name=$request->input('long_name');

        if($unit->save()){
            return response()->json(['msg'=>'You have successfully added the information.','status'=>'success']);
        }
        else{
            return response()->json(['msg'=>'Opps! My Back got cracked while working in Database','status'=>'error']);
        }

    }

    public function show($id)
    {

        $unit=Unit::findOrFail($id);
       

        if($unit->save()){
            return response()->json([
                'unit'=>$unit,
                'status'=>'success'
            ]);
        }
        else{
            return response()->json(['msg'=>'Opps! My Back got cracked while working in Database','status'=>'error']);
        }

    }

    public function update(Request $request)
    {
        $id=$request->input('id');
        $unit = Unit::findOrFail($id);
        $unit->short_name=$request->input('short_name');
        $unit->long_name=$request->input('long_name');
        if($unit->save()){
            return response()->json([
                'msg'=>"Record Updated successfully",
                'status'=>'success'
            ]);
        }
        else{
            return response()->json([
                'msg'=>'Opps! My Back got cracked while working in Database',
                'status'=>'error'
            ]);
        }
    }

    public function destroy($id)
    {

    }
}
