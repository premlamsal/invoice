<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Estimate;
use App\EstimateDetail;
use App\Http\Resources\Estimate as EstimateResource;
use App\Customer;

class EstimateController extends Controller
{

    public function index()
    {
    return EstimateResource::collection(Estimate::with('estimateDetail')->orderBy('updated_at','desc')->paginate(8));
    }

    public function store(Request $request)
    {
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

        return response()
            ->json([
                'created' => true,
                'id' => $estimate->id
            ]);
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

        return response()
            ->json([
                'updated' => true,
                'id' => $estimate->id
            ]);

    }

 
    public function destroy($id)
    {
        // Get Estimate
        $Estimate = Estimate::findOrFail($id);

        if($Estimate->delete()){
          return new EstimateResource($Estimate);
        }
        
    }
}
