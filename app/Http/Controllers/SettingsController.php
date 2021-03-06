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

        $this->validate($request, [
          'company_name' => 'required|string|max:200',
          'company_email' => 'required|email|max:255',
          'company_address' => 'required|string|max:200',
          'company_phone' =>  'required|digits:10',
          'company_url' => 'required|url',
          'tax' => 'required|numeric ',
          
        ]);

      $id=$request->input('id');
      $setting=Setting::findOrFail($id);
      $setting->company_name=$request->input('company_name');
      $setting->company_email=$request->input('company_email');
      $setting->company_address=$request->input('company_address');
      $setting->company_phone=$request->input('company_phone');
      $setting->company_url=$request->input('company_url');
      $setting->tax=$request->input('tax');
         
      if($request->hasFile('image')){
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('img'), $imageName);
        $setting->company_logo=$imageName;
        }
      if($setting->update()){
        return response()->json([
          'msg'=>'You have successfully changed the information.',
          'status'=>'success'
        ]);
      }
        else{
          return response()->json([
            'msg'=>'Opps! My Back got cracked while working in Database',
            'status'=>'error'
          ]);
        }
         
   }
}
