<?php

namespace App\Imports;

use Session;
use App\Models\NachaReport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NachaReportImport implements ToModel
{

    /**
    * @param string $row
    *
    * @return array
    */
    public function parseImportData(string $row)
    {    
        $parseRow['log_date'] = date("Y-m-d H:i:s");
        $parseRow['type_code'] = substr($row,0,1);
        $parseRow['trans_code'] = substr($row,1,2);
        $parseRow['routing_number'] = substr($row,3,9);
        $parseRow['account_number'] = substr($row,12,17);
        $amount = substr($row,29,10);
        $parseRow['amount'] = number_format(substr($amount, 0, -2).'.'.substr($amount, -2), 2);
        $parseRow['trans_id'] = substr($row,39,15);
        $parseRow['name'] = substr($row,54,22);
        $parseRow['dis_data'] = substr($row,76,3);
        $parseRow['trace_number'] = substr($row,79,15);
        $parseRow['processed'] = 1;
        return $parseRow;
    }

    /**
    * @param array $importData
    * @param string $fileName
    *
    * @return bool
    */
    public function validateImport(array $importData, $fileName="Undefined")
    {
        $count=0;
        $message = "";
        $errors = false;
        
        unset($importData[0]);
        unset($importData[1]);
        for($i=count($importData); $i > (count($importData)-21); $i--) {
            unset($importData[$i+1]);
        }

        foreach ($importData as $row) {
            
            $rowNacha = $this->parseImportData($row[0]);

            $traceNumber = isset($rowNacha['trace_number']) && is_numeric($rowNacha['trace_number']) ? $rowNacha['trace_number'] : null;

            if(isset($rowNacha['name']) && !ereg("^[a-zA-Z\-_]$", $rowNacha['name'])) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>Business name ".$rowNacha['name']." is invalid (Trace number: ".$traceNumber.".).</div></div>";
                $errors = true;
                Log::channel('nacha')->error('Business name '.$rowNacha['name'].' is invalid. ', [
                    'contact_id' => $contactId,
                    'advance_id' => $advanceId
                ]);
            }
            if(isset($rowNacha['amount']) && !is_numeric($rowNacha['amount'])) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>Amount ".$rowNacha['name']." is invalid (Trace number: ".$traceNumber.".).</div></div>";
                $errors = true;
                Log::channel('nacha')->error('Amount '.$rowNacha['name'].' is invalid. ', [
                    'contact_id' => $contactId,
                    'advance_id' => $advanceId
                ]);
            }
        }
        
        if(!$errors) {
            $message = "<div class='alert alert-success' role='alert'><div class='alert-body'>The file \"".$fileName."\" has been imported successfully.</div></div>";
            Session::flash('message', Session::has('message') ? $message.Session::get('message') : $message);
            return true;
        } else {
            $message = "<div class='validateText'>Validate the following errors in the \"".$fileName."\" imported file:</div>".$message;
            Session::flash('message', Session::has('message') ? Session::get('message').$message : $message);
            return false;
        }
    }
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $rowNacha = $this->parseImportData($row[0]);

        return new NachaReport([
            'log_date' => isset($rowNacha['log_date']) && $rowNacha['log_date']!='null' ? Carbon::parse($rowNacha['log_date'])->format('Y-m-d H:i:s') : null,
            'type_code' => $rowNacha['type_code'],
            'trans_code' => $rowNacha['trans_code'],
            'routing_number' => isset($rowNacha['routing_number']) && is_numeric($rowNacha['routing_number']) ? $rowNacha['routing_number'] : null,
            'account_number' => isset($rowNacha['account_number']) && is_numeric($rowNacha['account_number']) ? $rowNacha['account_number'] : 0,
            'amount' => $rowNacha['amount'],
            'trans_id' => isset($rowNacha['trans_id']) && is_numeric($rowNacha['trans_id']) ? $rowNacha['trans_id'] : null,
            'name' => $rowNacha['name'],
            'dis_data' => $rowNacha['dis_data'],
            'trace_number' => isset($rowNacha['trace_number']) && is_numeric($rowNacha['trace_number']) ? $rowNacha['trace_number'] : null,
            'processed' => isset($rowNacha['processed']) && is_numeric($rowNacha['processed']) ? $rowNacha['processed'] : null,
        ]);
    }
}
