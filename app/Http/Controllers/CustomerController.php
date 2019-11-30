<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Customer;
use App\Http\Resources\Customer as CustomerResource;

class CustomerController extends Controller
{
    public function index(){

        return CustomerResource::collection(Customer::all());
    }

    public function store(Request $request)
    {   
        // //collecting data from post to array
        // $Data=collect($request->customer);

        // $Customer=new Customer;
        // $Customer->name=$Data['name'];
        // $Customer->address=$Data['address'];
        // $Customer->phone=$Data['phone'];
        // $Customer->save();

        // return response()
        //     ->json([
        //         'created' => true,
        //         'message' => "Customer Added"
        //     ]);

        $customer=new Customer();
        $customer->name=$request->input('name');
        $customer->address=$request->input('address');
        $customer->phone=$request->input('phone');

        if($customer->save()){
            return response()->json([
                'msg'=>'You have successfully added the information.',
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

    public function update(Request $request){

        $id=$request->input('id');//get id from edit modal
        $customer=Customer::findOrFail($id);
        $customer->name=$request->input('name');
        $customer->address=$request->input('address');
        $customer->phone=$request->input('phone');

        if($customer->save()){
            return response()->json([
                'msg'=>'You have successfully updated the information.',
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
  
    public function search(Request $request){

       $searchQuery= $request->searchQuery;

       $queryResults=Customer::where('name','like','%'.$searchQuery.'%')->get();

          return response()
            ->json([
                'search' => 'ok',
                'queryResults' => $queryResults
            ]);

        
    }

    public function destroy($id){

        $customer=Customer::findOrFail($id);
         if($customer->delete()){
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

    public function show($id){

        $customer=Customer::findOrFail($id);
        if($customer->save()){
            return response()->json([
                'customer'=>$customer,
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


}
