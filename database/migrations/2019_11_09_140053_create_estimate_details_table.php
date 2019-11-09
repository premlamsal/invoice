<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimate_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('estimate_id');
            $table->foreign('estimate_id')->references('id')->on('estimates')->onDelete('cascade');
            $table->string('product_name');
            $table->string('quantity');
            $table->string('price');
            $table->string('line_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estimate_details');
    }
}
