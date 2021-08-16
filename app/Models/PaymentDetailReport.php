<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetailReport extends Model
{
    use HasFactory;

    protected $table = 'payment_details_report';
    protected $fillable = [
        'id','contact_id','trans_id','advance_id','funding_date','process_date','cleared_date','amount','status','balance','sub_type','memo',
        'return_code','return_date','return_reason','trans_type','custodial_account'
    ];
}
