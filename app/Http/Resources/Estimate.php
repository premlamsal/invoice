<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Estimate extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         // return parent::toArray($request);// will sent all data 
         return[
            'id'=>$this->id,
            'title'=> $this->title,
            'customer_name'=> $this->customer_name,
            'estimate_date'=> $this->estimate_date,
            'due_date'=> $this->due_date,
            'discount'=> $this->discount,
            'grand_total'=> $this->grand_total,
            'estimate_no'=> $this->estimate_no,
            'status'=>$this->status,
            'updated_at'=>$this->created_at->diffForHumans(),
        ];

    }



      public function with($request){

        return[
            'version'=>'1.0.0',
            'author_url'=>url('http://premlamsal.com.np')
        ];

    }
}
