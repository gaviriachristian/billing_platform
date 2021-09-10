<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\NachaReportImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\NachaReport;

class NachaController extends Controller
{
    public function index()
    {
        $nacha = NachaReport::all('id','name','routing_number','account_number','amount','trans_id','trace_number','filename');
        return $nacha;
    }

    public function detail($id)
    {
        $nacha = NachaReport::where('id', $id)->get();
        $nacha[0]['modal_title'] = $nacha[0]['name'];
        return $nacha;
    }
    
    public function nachaReport()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "Nacha"], ['name' => "Report"]];
        return view('/content/nacha/report', ['breadcrumbs' => $breadcrumbs]);
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importCsv(Request $request) 
    {
        // $validatedData = $request->validate([
        //    'file' => 'required',
        // ]);
        
        NachaReport::truncate();

        $this->removeLines($request->file('file'),[0,1]);
        $this->removeLastLines($request->file('file'),12);
        Excel::import(new NachaReportImport, $request->file('file'));
        //return back();
        //return redirect('payment-details-report')->with('status', 'The file has been imported in laravel 8');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function removeLines($tmpPath, $rowNumbers) 
    {
        $fileOut = file($tmpPath);
        foreach ($rowNumbers as $rowNumber) {
            unset($fileOut[$rowNumber]);
        }
        file_put_contents($tmpPath, implode("", $fileOut));
    }
    
    public function removeLastLines($tmpPath, $numberLines) 
    {
        $fileOut = file($tmpPath);
        $totalLines = count($fileOut);
        $line = $totalLines-$numberLines;
        for ($i = $line; $i < $totalLines; $i++) {
            unset($fileOut[$i]);
        }
       // dd(implode("", $fileOut));
        file_put_contents($tmpPath, implode("", $fileOut));
    }
}
