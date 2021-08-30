<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PmFundedReportImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\PmFundedReport;
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
     * File Upload Method 
     * 
     * @return void 
     */  
    public  function dropzoneFileUpload(Request $request)  
    {  
        if ($request->file('file') != null) {
            $arrayImportFile = Excel::toArray(new PmFundedReportImport, $request->file('file'));
            $importFundedReport = new PmFundedReportImport;

            $file = $request->file('file');
            $fileType = $file->getClientOriginalExtension();
            $fileName = $file->getClientOriginalName(); 
            
            Session::flash('count', Session::has('count') ? Session::get('count')+1 : 1);
            if (Session::get('count') <= 4) {
                if (!in_array($fileType, ['csv','txt','xls'])) {
                    $message = "<div class='alert alert-warning' role='alert'><div class='alert-body'>Unsupported file type,  \"".$fileName."\".</div></div>";
                    Session::flash('message', Session::has('message') ? $message.Session::get('message') : $message);
                    $response = [
                        'status' => 'error',
                        'info'   => 'Unsupported file type.'
                    ];
                } else {
                    if ($importFundedReport->validateImport($arrayImportFile[0],$fileName)) {
                        Excel::import(new PmFundedReportImport, $request->file('file'));
                        $tmpName = $request->filename; 
                        $file->move(public_path('uploads'),$tmpName);  
                        $response = [
                            'status'    => 'success',
                            'file_link' => 'Successfully uploaded file.'
                        ];
                    } else {
                        $response = [
                            'status' => 'error',
                            'info'   => 'File validation has failed.'
                        ];
                    }
                }
            } elseif (Session::get('count') == 5) {
                $message = "<div class='alert alert-warning' role='alert'><div class='alert-body'>You can't upload more than 4 files.</div></div>";
                Session::flash('message', Session::has('message') ? $message.Session::get('message') : $message);
                $response = [
                    'status' => 'error',
                    'info'   => 'You can\'t upload more than 4 files.'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'info'   => 'File not found.'
            ];
        }
        
        return json_encode($response);
        exit;
    }    
}
