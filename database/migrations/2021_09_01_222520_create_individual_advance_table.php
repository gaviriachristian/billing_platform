<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndividualAdvanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('individual_advance', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('contact_id')->nullable();
            $table->bigInteger('advance_id')->nullable();
            $table->date('funding_date')->nullable();
            $table->integer('funding_amount')->nullable();
            $table->integer('rtr')->nullable();
            $table->decimal('payment')->nullable();
            $table->string('freq')->nullable();
            $table->decimal('factor')->nullable();
            $table->integer('term_days')->nullable();
            $table->integer('term_months')->nullable();
            $table->integer('holdback')->nullable();
            $table->integer('origination_fee')->nullable();
            $table->integer('program_fee')->nullable();
            $table->integer('wire_fee')->nullable();
            $table->integer('other_fee_merchant')->nullable();
            $table->integer('net_funding_amt')->nullable();
            $table->integer('balance_payoff')->nullable();
            $table->string('advance_type')->nullable();
            $table->bigInteger('account_number')->nullable();
            $table->bigInteger('routing_number')->nullable();
            $table->string('broker')->nullable();
            $table->decimal('broker_upfront_amount')->nullable();
            $table->decimal('broker_upfront_percent')->nullable();
            $table->string('funder')->nullable();
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
        Schema::dropIfExists('individual_advance');
    }
}
