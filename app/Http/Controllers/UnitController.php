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
        return UnitResource::collection(Unit::paginate(8));
    }

   
    public function store(Request $request)
    {   

        $this->validate($request, [
          'short_name' => 'required|string|max:10',
          'long_name' => 'required|string|max:100',
        ]);


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
         $this->validate($request, [
          'short_name' => 'required|string|max:10',
          'long_name' => 'required|string|max:100',
        ]);

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
                'msg'=>'Error Updating Data',
                'status'=>'error'
            ]);
        }
    }

    public function destroy($id)
    {

        $unit=Unit::findOrFail($id);
         if($unit->delete()){
             return response()->json([
                'msg'=>'successfully Deleted',
                'status'=>'success'
            ]);
         }
         else{
             return response()->json([
                'msg'=>'Error while deleting data',
                'status'=>'error'
            ]);
         }
    }
}
