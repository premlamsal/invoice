<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Resources\Setting as SettingResource;
use App\Setting;

class SettingsController extends Controller
{
   public function index(){

   		$Settings=Setting::first();

   		 return response()
            ->json([
                'settings' => $Settings,
                'msg' => 'Record Retrived'
            ]);

   }
   public function update(Request $request){

   
   }
}
