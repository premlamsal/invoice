<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Estimate;
use App\Customer;

class SnippController extends Controller
{
   public function totalInvoices(){
   	$invoice=Invoice::count();
   	return response()->json([
          'info'=>$invoice,
          'status'=>'success'
        ]);
   }
   public function totalEstimates(){
   	$estimate=Estimate::count();
   	return response()->json([
          'info'=>$estimate,
          'status'=>'success'
        ]);
   }
   public function totalCustomer(){
   	$customer=Customer::count();
   	return response()->json([
          'info'=>$customer,
          'status'=>'success'
        ]);
   }
   public function totalNotification(){

   }
}
