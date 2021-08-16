<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentDetailsReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details_report', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned()->primary();
            $table->bigInteger('contact_id')->nullable();
            $table->bigInteger('trans_id')->nullable();
            $table->bigInteger('advance_id')->nullable();
            $table->date('funding_date')->nullable();
            $table->date('process_date')->nullable();
            $table->date('cleared_date')->nullable();
            $table->decimal('amount')->nullable();
            $table->string('status')->nullable();
            $table->decimal('balance')->nullable();
            $table->string('sub_type')->nullable();
            $table->string('memo')->nullable();
            $table->string('return_code')->nullable();
            $table->date('return_date')->nullable();
            $table->string('return_reason')->nullable();
            $table->string('trans_type')->nullable();
            $table->string('custodial_account')->nullable();
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
        Schema::dropIfExists('payment_details_report');
    }
}
