<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceReport extends Model
{
    use HasFactory;

    protected $table = 'advance_report';
    protected $fillable = [
        'contact_id','advance_id','business_name','full_name','funding_date','last_history_date','funding_amount','rtr','payment','freq','factor',
        'term_days','term_months','holdback','origination_fee','days_since_funding','advance_type','method','modified','advance_status',
        'balance','est_payoff_date','received','last_merchant_cleared','ach_drafting','paused','assigned','account_number','routing_number',
        'first_name','last_name','broker','broker_upfront_amount','gateway','portfolio','number_of_payments','bitty_renewals_manager'
    ];
}
