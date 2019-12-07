<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimateDetail extends Model
{
	public function estimateDetail() {
	    return $this->belongsTo('\App\Estimate','estimate_id','id');
	}
	 protected $fillable = ['estimate_id', 'product_name', 'quantity','price','unit','line_total'];
}
