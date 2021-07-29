<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceReport extends Model
{
    use HasFactory;

    protected $table = 'advance_report';
    protected $fillable = ['contact_id','advance_id','business_name','full_name','funding_date','last_history_date','funding_amount','rtr','payment'];
}
