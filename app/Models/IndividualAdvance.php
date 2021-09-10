<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IndividualAdvance extends Model
{
    use HasFactory;

    protected $table = 'individual_advance';
    protected $fillable = [
        'id','contact_id','advance_id','funding_date','funding_amount','rtr','payment','freq',
        'factor','term_days','term_months','holdback','origination_fee','program_fee','wire_fee','other_fee_merchant','net_funding_amt',
        'balance_payoff','advance_type','account_number','routing_number','broker','broker_upfront_amount','broker_upfront_percent','funder'
    ];
}
