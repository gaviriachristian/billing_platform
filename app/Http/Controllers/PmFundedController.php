<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PmFundedReportImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PmFundedReport;

class PmFundedController extends Controller
{
    public function index()
    {
        $pmfunded = PmFundedReport::all('id','contact_id','advance_id','funding_date','business_name','funding_amount','rtr','payment');
        return $pmfunded;
    }

    public function detail($id)
    {
        $pmfunded = PmFundedReport::where('id', $id)->get();
        $pmfunded[0]['modal_title'] = $pmfunded[0]['business_name'];
        return $pmfunded;
    }
    
    public function pmFundedReport()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "PM Funded"], ['name' => "Report"]];
        return view('/content/pm-funded/report', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importCsv(Request $request) 
    {
        $validatedData = $request->validate([
           'file' => 'required',
        ]);
        session()->forget('message');

        //PmFundedReport::truncate();

        // // Delete existing records        
        // $records = Excel::toArray(new PmFundedReportImport, $request->file('file'));
        // $ids = array_column($records[0], 'id');
        // $idsLimit = array_chunk($ids, 50000);
        // foreach ($idsLimit as $idsArray) {
        //     PmFundedReport::whereIn('id', $idsArray)->delete();
        // }

        $arrayImportFile = Excel::toArray(new PmFundedReportImport, $request->file('file'));
        $importFundedReport = new PmFundedReportImport;
        if($importFundedReport->validateImport($arrayImportFile[0])) {
            dd("OK");
            //Excel::import(new PmFundedReportImport, $request->file('file'));
        }

        return back();
        
        // throw ValidationException::withMessages([
        //     'Syndication percentage' => 'The percentage cannot be less than 100'
        // ]);

    }
}
