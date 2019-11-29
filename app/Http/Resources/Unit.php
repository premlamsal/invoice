<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Unit extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
         return[
            'id'=>$this->id,
            'short_name'=> $this->short_name,
            'long_name'=> $this->long_name,
            'updated_at'=>$this->updated_at->diffForHumans(),
        ];
    }

    
      public function with($request){

        return[
            'version'=>'1.0.0',
            'author_url'=>url('http://premlamsal.com.np')
        ];

    }
}
