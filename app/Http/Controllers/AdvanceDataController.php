<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AdvanceReport;

class AdvanceDataController extends Controller
{
    public function index()
    {
        $advances = AdvanceReport::all();
        return $advances;
    }

    public function detail($id)
    {
        $advance = AdvanceReport::where('id', $id)->get();
        return $advance;
    }
}
