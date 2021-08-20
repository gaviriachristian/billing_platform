<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NachaReport extends Model
{
    use HasFactory;

    protected $table = 'nacha_report';
    protected $fillable = [
        'id','log_date','type_code','trans_code','routing_number','account_number','amount',
        'trans_id','name','dis_data','trace_number','filename','processed'
    ];    
}
