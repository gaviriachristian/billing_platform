<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAdvanceReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advance_report', function (Blueprint $table) {
            $table->string('freq')->nullable();
            $table->decimal('factor')->nullable();
            $table->integer('term_days')->nullable();
            $table->integer('term_months')->nullable();
            $table->integer('holdback')->nullable();
            $table->integer('origination_fee')->nullable();
            $table->integer('days_since_funding')->nullable();
            $table->string('advance_type')->nullable();
            $table->string('method')->nullable();
            $table->dateTime('modified')->nullable();
            $table->string('advance_status')->nullable();
            $table->decimal('balance')->nullable();
            $table->date('est_payoff_date')->nullable();
            $table->integer('received')->nullable();
            $table->date('last_merchant_cleared')->nullable();
            $table->boolean('ach_drafting')->nullable();
            $table->boolean('paused')->nullable();
            $table->string('assigned')->nullable();
            $table->bigInteger('account_number')->nullable();
            $table->bigInteger('routing_number')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('broker')->nullable();
            $table->decimal('broker_upfront_amount')->nullable();
            $table->string('gateway')->nullable();
            $table->string('portfolio')->nullable();
            $table->integer('number_of_payments')->nullable();
            $table->string('bitty_renewals_manager')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advance_report', function (Blueprint $table) {
            $table->dropColumn('freq');
            $table->dropColumn('factor');
            $table->dropColumn('term_days');
            $table->dropColumn('term_months');
            $table->dropColumn('holdback');
            $table->dropColumn('origination_fee');
            $table->dropColumn('days_since_funding');
            $table->dropColumn('advance_type');
            $table->dropColumn('method');
            $table->dropColumn('modified');
            $table->dropColumn('advance_status');
            $table->dropColumn('balance');
            $table->dropColumn('est_payoff_date');
            $table->dropColumn('received');
            $table->dropColumn('last_merchant_cleared');
            $table->dropColumn('ach_drafting');
            $table->dropColumn('paused');
            $table->dropColumn('assigned');
            $table->dropColumn('account_number');
            $table->dropColumn('routing_number');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('broker');
            $table->dropColumn('broker_upfront_amount');
            $table->dropColumn('gateway');
            $table->dropColumn('portfolio');
            $table->dropColumn('number_of_payments');
            $table->dropColumn('bitty_renewals_manager');
        });
    }
}
