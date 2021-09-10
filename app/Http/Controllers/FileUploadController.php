<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\AdvanceReportImport;
use App\Imports\PaymentDetailReportImport;
use App\Imports\PmFundedReportImport;
use App\Imports\NachaReportImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PmFundedReport;
use App\Http\Controllers\NachaController;
use Illuminate\Support\Facades\Log;
use Session;

class FileUploadController extends Controller
{
    /** 
     * Generate Upload View 
     * 
     * @return void 
    */  
    public  function dropzoneUi()  
    {  
        return view('dropzone-file-upload');  
    }  

    /**
    * @param array $headers
    *
    * @return bool
    */
    public function validateImportType(array $headers)
    {
        $headerAdvance = ["contact_id", "advance_id", "business_name", "full_name", "funding_date", "last_history_date", "funding_amount", "rtr", "payment", "freq", "factor", "term_days", "term_months", "holdback", "origination_fee", "days_since_funding_bus", "advance_type", "method", "modified", "advance_status", "balance", "est_payoff_date", "received", "last_merchant_cleared_date", "ach_drafting", "paused", "assigned_company", "account_number", "routing_number", "first_name", "last_name", "nbroker", "broker_upfront_amount", "gateway", "nportfolio", "of_payments", "bitty_renewals_manager"];
        $headerPaymentDetails = ["contact_id", "id", "trans_id", "advance_id", "funding_date", "process_date", "cleared_date", "amount", "status", "balance", "sub_type", "memo", "return_code", "return_date", "return_reason", "trans_type", "custodial_account"];
        $headerFunded = ["contact_id", "advance_id", "funding_date", "business_name", "last_name", "first_name", "funding_amount", "rtr", "payment", "freq", "factor", "term_days", "term_months", "holdback", "origination_fee", "program_fee", "wire_fee", "other_fee_merchant", "net_funding_amt", "balance_payoff", "advance_type", "account_number", "routing_number", "nbroker", "broker_upfront_amount", "broker_upfront_percent", "funder", "syndicators_name", "syndicators_amt", "syndicators_rtr", "syn_of_adv", "syn_servicing_fee", "address", "city", "state", "zip_code", "e_mail", "cell_phone"];
        //$headerNacha = ["log_date", "type_code", "trans_code", "routing_number", "account_number", "amount", "trans_id", "name", "dis_data", "trace_number", "filename", "processed"];

        if (!array_diff($headers,$headerAdvance)) {
            return "Advance";
        } elseif (!array_diff($headers,$headerPaymentDetails)) {
            return "PaymentDetails";
        } elseif (!array_diff($headers,$headerFunded)) {
            return "Funded";
        } else {
            $headerNacha = explode("_", $headers[0]);
            if(trim($headerNacha[count($headerNacha)-1]) == "payliance") {
                return "Nacha";
            }
        }

        return false;
    }

    /** 
     * File Upload Method 
     * 
     * @return void 
     */  
    public  function dropzoneFileUpload(Request $request)  
    {  
        if ($request->file('file') != null) {
            $file = $request->file('file');
            $fileType = $file->getClientOriginalExtension();
            $fileName = $file->getClientOriginalName(); 
            Session::flash('fileName', $fileName);
            
            Session::flash('count', Session::has('count') ? Session::get('count')+1 : 1);
            if (Session::get('count') <=  4) {

                if (!in_array($fileType, ['csv','txt','xls'])) {
                    $message = "<div class='alert alert-warning' role='alert'><div class='alert-body'>Unsupported file type,  \"".$fileName."\".</div></div>";
                    Session::flash('message', Session::has('message') ? $message.Session::get('message') : $message);
                    $response = [
                        'status' => 'error',
                        'info'   => 'Unsupported file type.',
                        'filename' => $fileName
                    ];
                    Log::channel('failed')->error('Unsupported file type, "'.$fileName.'".');

                } else {
                    
                    $arrayImportFile = Excel::toArray(new AdvanceReportImport, $request->file('file'));
                    $headers = $headers = array_keys($arrayImportFile[0][0]);
                    $importType = $this->validateImportType($headers);

                    if ($importType=="Advance") {
                        $importReport = new AdvanceReportImport;
                        $arrayImportFile = Excel::toArray(new AdvanceReportImport, $request->file('file'));
                    } elseif ($importType=="PaymentDetails") {
                        $importReport = new PaymentDetailReportImport;
                        $arrayImportFile = Excel::toArray(new PaymentDetailReportImport, $request->file('file'));
                    } elseif ($importType=="Funded") {
                        $importReport = new PmFundedReportImport;
                        $arrayImportFile = Excel::toArray(new PmFundedReportImport, $request->file('file'));
                    } elseif ($importType=="Nacha") {
                        $importReport = new NachaReportImport;
                        $arrayImportFile = Excel::toArray(new NachaReportImport, $request->file('file'));
                    } 
                    
                    if (isset($importReport) && $importReport->validateImport($arrayImportFile[0],$fileName)) {

                        if ($importType=="Advance") {
                            Excel::import(new AdvanceReportImport, $request->file('file')); ;
                        } elseif ($importType=="PaymentDetails") {
                            Excel::import(new PaymentDetailReportImport, $request->file('file')); ;
                        } elseif ($importType=="Funded") {
                            Excel::import(new PmFundedReportImport, $request->file('file'));
                        } elseif ($importType=="Nacha") {
                            $nachaController = new NachaController;
                            $nachaController->importCsv($request);
                        }
                        
                        $tmpName = $request->filename; 
                        $file->move(public_path('uploads'),$tmpName);  
                        $response = [
                            'status'    => 'success',
                            'file_link' => 'Successfully uploaded file.',
                            'filename' => $fileName
                        ];
                    } else {
                        $response = [
                            'status' => 'error',
                            'info'   => 'File validation has failed.',
                            'filename' => $fileName
                        ];
                        Log::channel(strtolower($importType))->error('File validation has failed "'.$fileName.'".');
                    }
                }
            } elseif (Session::get('count') == 5) {
                $message = "<div class='alert alert-warning' role='alert'><div class='alert-body'>You can't upload more than 4 files.</div></div>";
                Session::flash('message', Session::has('message') ? $message.Session::get('message') : $message);
                $response = [
                    'status' => 'error',
                    'info'   => 'You can\'t upload more than 4 files.',
                    'filename' => $fileName
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'info'   => 'File not found.',
                'filename' => $fileName
            ];
        }

        return json_encode($response);
        exit;
    }    
}
