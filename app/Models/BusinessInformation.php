<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessInformation extends Model
{
    use HasFactory;

    protected $table = 'business_information';
    protected $fillable = [
        'id','contact_id','business_name','last_name','first_name','address','city','state','zip_code','email','cell_phone'
    ];
}

