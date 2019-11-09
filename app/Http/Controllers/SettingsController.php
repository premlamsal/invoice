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

           if($request->company_name!="" && $request->company_email!="" && $request->company_address!="" && $request->company_phone!="" && $request->company_url!="" && $request->vat!="")
           {

            

              $company_name= $request->input('company_name');
              $company_email= $request->input('company_email');
              $company_address= $request->input('company_address');
              $company_phone= $request->input('company_phone');
              $company_url= $request->input('company_url');
              $vat= $request->input('vat');

              $id=$request->input('id');


              $setting=Setting::findOrFail($id);
              $setting->company_name=$company_name;
              $setting->company_email=$company_email;
              $setting->company_address=$company_address;
              $setting->company_phone=$company_name;
              $setting->company_url=$company_url;
              $setting->vat=$vat;

              if($request->hasFile('image')){
                $imageName = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path('img'), $imageName);
                $setting->company_logo=$imageName;
              }

              if($setting->update()){
                   $sendResponse=response()->json(['msg'=>'You have successfully changed the information.','status'=>'success']);
              }
              else{
                 $sendResponse=response()->json(['msg'=>'Opps! My Back got cracked while working in Database','status'=>'error']);
              }
         
           }
           else{
             $sendResponse=response()->json(['msg'=>'Opps! I am quite hungry, Please provide all information.','status'=>'error']);
           }

           return $sendResponse;
     
   
   }
}
