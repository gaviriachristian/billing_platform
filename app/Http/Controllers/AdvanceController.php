<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Imports\AdvanceReportImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AdvanceReport;
use App\Models\PaymentDetailReport;

class AdvanceController extends Controller
{
    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Advance"], ['name' => "Index"]];
        return view('/content/advance/index', ['breadcrumbs' => $breadcrumbs]);
    }

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
        //AdvanceReport::truncate();
        $validatedData = $request->validate([
           'file' => 'required',
        ]);
        
        AdvanceReport::truncate();
        
        Excel::import(new AdvanceReportImport, $request->file('file'));
        return back();
        // Excel::import(new AdvanceReportImport,$request->file('file'));
        // return redirect('advances-report')->with('status', 'The file has been imported in laravel 8');
    }
   
    public function detailView($id)
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/advances/index", 'name' => "Advances"], ['name' => "Detail"]];
        $advance = AdvanceReport::where('id', $id)->get();
        $advance[0]['modal_title'] = $advance[0]['business_name'];
        $advanceReport = $advance[0]->attributesToArray();
        $payments = PaymentDetailReport::where('advance_id', $advanceReport['advance_id'])->get();
        return view('/content/advance/detail', ['id' => $id, 'advance' => $advanceReport, 'payments' => $payments, 'breadcrumbs' => $breadcrumbs]);
    }
}
