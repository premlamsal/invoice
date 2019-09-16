<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Invoice extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return parent::toArray($request);// will sent all data 
        //  return[
        //     'id'=>$this->id,
        //     'title'=> $this->title,
        //     'customer_name'=> $this->customer_name,
        //     'invoice_date'=> $this->invoice_date,
        //     'due_date'=> $this->due_date,
        //     'discount'=> $this->discount,
        //     'grand_total'=> $this->grand_total,
        //     'invoice_no'=> $this->invoice_no,
        //     'status'=>$this->status,
        //     'created_at'=>$this->created_at->diffForHumans(),
        // ];


    }

    public function with($request){

        return[
            'version'=>'1.0.0',
            'author_url'=>url('http://premlamsal.com.np')
        ];

    }
}