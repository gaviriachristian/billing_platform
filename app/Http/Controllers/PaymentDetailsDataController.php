<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\PaymentDetailReport;

class PaymentDetailsDataController extends Controller
{
    public function index()
    {
        $payments = PaymentDetailReport::all('id','contact_id','trans_id','advance_id','funding_date','status','balance','trans_type','amount');
        return $payments;
    }

    public function detail($id)
    {
        $payment = PaymentDetailReport::where('id', $id)->get();
        $payment[0]['modal_title'] = $payment[0]['memo'];
        return $payment;
    }
}

