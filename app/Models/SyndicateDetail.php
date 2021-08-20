<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyndicateDetail extends Model
{
    use HasFactory;

    protected $table = 'syndicate_detail';
    protected $fillable = [
        'id','funded_report_id','syndicators_name','syndicators_amt','syndicators_rtr','syn_of_adv','syn_servicing_fee'
    ];
}
