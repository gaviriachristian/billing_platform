<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PmFundedReport extends Model
{
    use HasFactory;

    protected $table = 'pm_funded_report';
    protected $fillable = [
        'id','contact_id','advance_id','funding_date','business_name','last_name','first_name','funding_amount','rtr','payment','freq',
        'factor','term_days','term_months','holdback','origination_fee','program_fee','wire_fee','other_fee_merchant','net_funding_amt',
        'balance_payoff','advance_type','account_number','routing_number','broker','broker_upfront_amount','broker_upfront_percent','funder',
        'syndicators_name','syndicators_amt','syndicators_rtr','syn_of_adv','syn_servicing_fee','address','city','state','zip_code','email','cell_phone'
    ];
}
