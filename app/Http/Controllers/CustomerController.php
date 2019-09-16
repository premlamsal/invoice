<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        


    }

    public function store(Request $request)
    {   
        //collecting data from post to array
        $Data=collect($request->customer);

        $Customer=new Customer;
        $Customer->name=$Data['name'];
        $Customer->address=$Data['address'];
        $Customer->phone=$Data['phone'];
        $Customer->save();

        return response()
            ->json([
                'created' => true,
                'message' => "Customer Added"
            ]);
       
    }

  
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
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
}
