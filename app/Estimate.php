<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    public function estimateDetail() {
	    return $this->hasMany('\App\estimateDetail','estimate_id','id');
	}

    public function customer() {
	    return $this->belongsTo('\App\Customer','customer_id','id');
	}

	 protected $fillable = ['title', 'estimate_date','due_date','customer_id','customer_name','sub_total','discount','grand_total','status'];
}
