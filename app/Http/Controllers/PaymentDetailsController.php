<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PaymentDetailReportImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PaymentDetailReport;

class PaymentDetailsController extends Controller
{
    public function paymentDetailsReport()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Payment details"], ['name' => "Report"]];
        return view('/content/payment-details/report', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importCsv(Request $request) 
    {
        $validatedData = $request->validate([
           'file' => 'required',
        ]);
        
        // Delete existing records        
        $records = Excel::toArray(new PaymentDetailReportImport, $request->file('file'));
        $ids = array_column($records[0], 'id');
        $idsLimit = array_chunk($ids, 50000);
        foreach ($idsLimit as $idsArray) {
            PaymentDetailReport::whereIn('id', $idsArray)->delete();
        }
        
        Excel::import(new PaymentDetailReportImport, $request->file('file'));
        return back();
        //return redirect('payment-details-report')->with('status', 'The file has been imported in laravel 8');
    }
}

