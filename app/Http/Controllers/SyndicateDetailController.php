<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SyndicateDetail;

class SyndicateDetailController extends Controller
{
    public function index()
    {
        $syndicate = SyndicateDetail::all('id','funded_report_id','syndicators_name','syndicators_amt','syndicators_rtr','syn_of_adv','syn_servicing_fee');
        return $syndicate;
    }

    public function detail($id)
    {
        $syndicates = SyndicateDetail::where('funded_report_id', $id)->get();
        return $syndicates;
    }
}
