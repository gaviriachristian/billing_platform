<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNachaReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nacha_report', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('log_date')->nullable();
            $table->char('type_code',1)->nullable();
            $table->char('trans_code',2)->nullable();
            $table->integer('routing_number')->nullable();
            $table->bigInteger('account_number')->nullable();
            $table->decimal('amount')->nullable();
            $table->bigInteger('trans_id')->nullable();
            $table->string('name')->nullable();
            $table->char('dis_data',3)->nullable();
            $table->bigInteger('trace_number')->nullable();
            $table->string('filename')->nullable();
            $table->boolean('processed')->nullable();
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
        Schema::dropIfExists('nacha_report');
    }
}
