<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
	public function invoiceDetail() {
	    return $this->belongsTo('\App\Invoice','invoice_id','id');
	}
	 protected $fillable = ['invoice_id', 'product_name', 'quantity','price','line_total'];
}
