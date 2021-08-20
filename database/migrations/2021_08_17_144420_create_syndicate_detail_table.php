<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyndicateDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syndicate_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('funded_report_id')->nullable();
            $table->string('syndicators_name')->nullable();
            $table->integer('syndicators_amt')->nullable();
            $table->decimal('syndicators_rtr')->nullable();
            $table->decimal('syn_of_adv')->nullable();
            $table->decimal('syn_servicing_fee')->nullable();
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
        Schema::dropIfExists('syndicate_detail');
    }
}
