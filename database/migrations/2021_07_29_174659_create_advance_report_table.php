<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvanceReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advance_report', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('contact_id')->nullable();
            $table->bigInteger('advance_id')->nullable();
            $table->string('business_name')->nullable();
            $table->string('full_name')->nullable();
            $table->date('funding_date')->nullable();
            $table->date('last_history_date')->nullable();
            $table->decimal('funding_amount')->nullable();
            $table->decimal('rtr')->nullable();
            $table->decimal('payment')->nullable();
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
        Schema::dropIfExists('advance_report');
    }
}
