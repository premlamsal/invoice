<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
	public function invoiceDetail() {
	    return $this->hasMany('\App\invoiceDetail','invoice_id','id');
	}

    public function customer() {
	    return $this->belongsTo('\App\Customer','customer_id','id');
	}

	 protected $fillable = ['title', 'invoice_date','due_date','customer_id','customer_name','sub_total','discount','tax_amount','grand_total','status'];
}
