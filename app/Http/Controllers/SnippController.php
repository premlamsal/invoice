<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Estimate;
use App\Customer;
use App\Unit;

class SnippController extends Controller
{
  
   public function fetchDashInfo(){
    $invoice=Invoice::count();
    $estimate=Estimate::count();
    $customer=Customer::count();
    $unit=Unit::count();

    return response()->json([
          'invoice'=>$invoice,
          'estimate'=>$estimate,
          'customer'=>$customer,
          'unit'=>$unit
        ]);
   }
}
