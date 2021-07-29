<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Imports\AdvanceReportImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AdvancesReport;

class AdvanceController extends Controller
{
    public function advancesReport()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Advance"], ['name' => "Report"]];
        return view('/content/advance/report', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importCsv(Request $request) 
    {
        $validatedData = $request->validate([
           'file' => 'required',
        ]);
        Excel::import(new AdvanceReportImport, $request->file('file'));
        return back();
        // Excel::import(new AdvanceReportImport,$request->file('file'));
        // return redirect('advances-report')->with('status', 'The file has been imported in laravel 8');


    }
}
