<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Estimate;
use App\EstimateDetail;
use App\Http\Resources\Estimate as EstimateResource;
use App\Customer;
use Validator;

class EstimateController extends Controller
{

    public function index()
    {
     return EstimateResource::collection(Estimate::with('estimateDetail')->orderBy('updated_at','desc')->paginate(8));
    }

    public function store(Request $request)
    {

        // $request=json_decode($request->items, true);
        $this->validate($request,[

            'info.title' => 'required | string |max:200',
            'info.customer_name' => 'required | string| max:200',
            'info.due_date' => 'required | date',
            'info.estimate_date' => 'required | date',

            'info.discount' => 'required | numeric| max:200',


            'items.*.product_name' => 'required | string |max:200',
            'items.*.price' => 'required | numeric',
            'items.*.quantity' => 'required | numeric',

        ],[

            'info.title.required'=> 'This field is required'


        ]);

        // print_r($request->all());

        $items = collect($request->items)->transform(function($item) {
            $item['line_total'] = $item['quantity'] *$item['price'];
            return new EstimateDetail($item);
        });

        if($items->isEmpty()) {
            return response()
            ->json([
                'items_empty' => 'One or more Item is required.'
            ], 422);
        }

        $data = $request->info;
        $data['sub_total'] = $items->sum('line_total');
        $data['grand_total'] = $data['sub_total'] - $data['discount'];

        $estimate = Estimate::create($data);

        $estimate->estimateDetail()->saveMany($items);

         return response()->json(['msg'=>'You have successfully created the Estimate.','status'=>'success']);
    }

    public function show($id)
    {
        // Get Estimate
        
        $Estimate = Estimate::with('estimateDetail')->findOrFail($id);
        $customer_id=$Estimate->customer_id;
        $Customer=Customer::findOrFail($customer_id);

        return response()
            ->json([
                'estimate' => $Estimate,
                'customer' => $Customer
            ]);
    }

    public function update(Request $request)
    {

        // $request=json_decode($request->items, true);
        $this->validate($request,[

            'info.title' => 'required | string |max:200',
            'info.customer_name' => 'required | string| max:200',
            'info.due_date' => 'required | date',
            'info.estimate_date' => 'required | date',
            'info.discount' => 'required | numeric| max:200',

            'items.*.product_name' => 'required | string |max:200',
            'items.*.price' => 'required | numeric',
            'items.*.quantity' => 'required | numeric',

        ],[

            'info.title.required'=> 'This field is required'


        ]);

         $id=$request->id;

        $estimate = Estimate::findOrFail($id);

        $items = collect($request->items)->transform(function($item) {
            $item['line_total'] = $item['quantity'] *$item['price'];
            return new EstimateDetail($item);
        });

        if($items->isEmpty()) {
            return response()
            ->json([
                'items_empty' => ['One or more Item is required.']
            ], 422);
        }

        $data = $request->info;

        $data['sub_total'] = $items->sum('line_total');
        $data['grand_total'] = $data['sub_total'] - $data['discount'];

        $estimate->update($data);

        EstimateDetail::where('estimate_id', $estimate->id)->delete();

        $estimate->estimateDetail()->saveMany($items);

        

         return response()->json(['msg'=>'You have successfully updated the Estimate.','status'=>'success']);

    }

 
    public function destroy($id)
    {
        // Get Estimate
        $Estimate = Estimate::findOrFail($id);

        if($Estimate->delete()){
          return new EstimateResource($Estimate);
        }
        
    }
    public function searchEstimates(Request $request){

        $searchKey=$request->input('searchTableKey');
        if($searchKey!=''){
            
            // $queryResults=Estimate::where('customer_name','like','%'.$searchQuery.'%')->get();
            return EstimateResource::collection(Estimate::where('customer_name','like','%'.$searchKey.'%')->get());    

        }


       // return EstimateResource::collection(Estimate::where('customer_name','like','%'.$searchQuery.'%')->orderBy('updated_at','desc')->paginate(8));    


  
    }
}
