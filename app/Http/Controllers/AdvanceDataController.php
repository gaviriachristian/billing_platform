<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AdvanceReport;

class AdvanceDataController extends Controller
{
    public function index()
    {
        $advances = AdvanceReport::all('id','contact_id','advance_id','business_name','full_name','payment','advance_status');
        return $advances;
    }

    public function detail($id)
    {
        $advance = AdvanceReport::where('id', $id)->get();
        $advance[0]['modal_title'] = $advance[0]['business_name'];
        return $advance;
    }
}
