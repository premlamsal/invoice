<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Invoice;
use App\InvoiceDetail;
use App\Http\Resources\Invoice as InvoiceResource;
use App\Customer;
use App\Setting;


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

            'info.title' => 'required | string |max:200',
            'info.customer_name' => 'required | string| max:200',
            'info.due_date' => 'required | date',
            'info.invoice_date' => 'required | date',

            'info.discount' => 'required | numeric| max:200',

            'items.*.product_name' => 'required | string |max:200',
            'items.*.price' => 'required | numeric',
            'items.*.quantity' => 'required | numeric',

        ]);

         $settings=Settings::findOrFail(1);

        //collecting data
        $items = collect($request->items)->transform(function($item) {
        $item['line_total'] = $item['quantity'] *$item['price'];
            return new InvoiceDetail($item);
        });

        if($items->isEmpty()) {
            return response()
            ->json([
                'items_empty' => 'One or more Item is required.'
            ], 422);
        }

        $data = $request->info;
        $data['sub_total'] = $items->sum('line_total');
        $data['tax_amount'] = $data['sub_total'] * 0.13;
        $data['grand_total'] = $data['sub_total'] + $data['tax_amount'] - $data['discount'];
       

        $invoice = Invoice::create($data);

        $invoice->invoiceDetail()->saveMany($items);

        return response()->json(['msg'=>'You have successfully created the Invoice.','status'=>'success']);
        
    }
    public function update(Request $request){
       // //validation
         $this->validate($request,[

            'info.title' => 'required | string |max:200',
            'info.customer_name' => 'required | string| max:200',
            'info.due_date' => 'required | date',
            'info.invoice_date' => 'required | date',
            
            'info.discount' => 'required | numeric| max:200',

            'items.*.product_name' => 'required | string |max:200',
            'items.*.price' => 'required | numeric',
            'items.*.quantity' => 'required | numeric',

        ]);  
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

        return response()->json(['msg'=>'You have successfully updated the Invoice.','status'=>'success']);
        

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
     public function searchInvoices(Request $request){

        $searchKey=$request->input('searchTableKey');
        if($searchKey!=''){
            
            // $queryResults=Estimate::where('customer_name','like','%'.$searchQuery.'%')->get();
            return InvoiceResource::collection(Invoice::where('customer_name','like','%'.$searchKey.'%')->get());    
        }
    }

}
