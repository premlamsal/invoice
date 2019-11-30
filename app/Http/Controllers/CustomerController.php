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
    
     $this->validate($request, [
      'name' => 'required|alpha|max:100',
      'address' => 'required|string|max:200',
      'phone' => 'required|numeric|size:10'
     ]);

        $customer=new Customer();
        $customer->name=$request->input('name');
        $customer->address=$request->input('address');
        $customer->phone=$request->input('phone');

        if($customer->save()){
            return response()->json([
                'msg'=>'Customer added successfully',
                'status'=>'success'
            ]);
        }
        else{
            return response()->json([
                'msg'=>'Error while adding customer',
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
                'msg'=>'Customer update successfully',
                'status'=>'success'
            ]);
        }
        else{
            return response()->json([
                'msg'=>'Error while updating customer',
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
                'msg'=>'Error while retriving Customer',
                'status'=>'error'
            ]);
        }
    }


}
