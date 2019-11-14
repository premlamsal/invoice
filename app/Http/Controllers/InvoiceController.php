<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Invoice;
use App\InvoiceDetail;
use App\Http\Resources\Invoice as InvoiceResource;
use App\Customer;


class InvoiceController extends Controller
{
      public function index()
    {
        /*---------------------------------------------------------
        This block will only return non-realtionship model

        // Get Invoices
        // $Invoices= Invoice::orderBy('created_at', 'desc')->paginate(3);

        //Return collection of Invoices as a resource
        // return InvoiceResource::collection($Invoices);
        -----------------------------------------------------------*/

         return InvoiceResource::collection(Invoice::with('invoiceDetail')->orderBy('updated_at','desc')->paginate(8));
    }

    public function store(Request $request)
    {   
        // //validation
        $this->validate($request,[
        'info.customer_name' => 'required|string|max:50',
        // 'info.title' => 'required|string|max:255',
        // 'info.invoice_date' => 'required|date',
        // 'info.due_date' => 'required|date',
        // 'info.status' => 'required|string|max:10',
        // 'info.discount'=> 'required|numeric|min:0',

        // 'items.*.product_name'=> 'required|max:255',
        // 'items.*.price'=> 'required|numeric|min:1',
        // 'items.*.quantity'=> 'required|integer|min:1',
        ]);






        // //collecting data
        // $items = collect($request->items)->transform(function($item) {
        // $item['line_total'] = $item['quantity'] *$item['price'];
        //     return new InvoiceDetail($item);
        // });

        // if($items->isEmpty()) {
        //     return response()
        //     ->json([
        //         'items_empty' => 'One or more Item is required.'
        //     ], 422);
        // }

        // $data = $request->info;
        // $data['sub_total'] = $items->sum('line_total');
        // $data['tax_amount'] = $data['sub_total'] * 0.13;
        // $data['grand_total'] = $data['sub_total'] + $data['tax_amount'] - $data['discount'];
       

        // $invoice = Invoice::create($data);

        // $invoice->invoiceDetail()->saveMany($items);

         
       

        
    }
    public function update(Request $request){

        $id=$request->id;

        $invoice = Invoice::findOrFail($id);

        $items = collect($request->items)->transform(function($item) {
            $item['line_total'] = $item['quantity'] *$item['price'];
            return new InvoiceDetail($item);
        });

        if($items->isEmpty()) {
            return response()
            ->json([
                'items_empty' => ['One or more Item is required.']
            ], 422);
        }

        $data = $request->info;

        $data['sub_total'] = $items->sum('line_total');
         $data['tax_amount'] = $data['sub_total'] * 0.13;
        $data['grand_total'] = $data['sub_total'] + $data['tax_amount'] - $data['discount'];
       
        $invoice->update($data);

        InvoiceDetail::where('invoice_id', $invoice->id)->delete();

        $invoice->invoiceDetail()->saveMany($items);

        return response()
            ->json([
                'updated' => true,
                'id' => $invoice->id
            ]);

    }

    public function show($id)
    {
        // Get Invoice
        
        $Invoice = Invoice::with('invoiceDetail')->findOrFail($id);
        $customer_id=$Invoice->customer_id;
        $Customer=Customer::findOrFail($customer_id);

        return response()
            ->json([
                'invoice' => $Invoice,
                'customer' => $Customer
            ]);

    }

    public function destroy($id)
    {   
        
        // Get Invoice
        $Invoice = Invoice::findOrFail($id);

        if($Invoice->delete()){
          return new InvoiceResource($Invoice);
        }
        
    }
}
