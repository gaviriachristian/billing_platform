<?php

namespace App\Imports;

use Session;
use App\Models\PaymentDetailReport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PaymentDetailReportImport implements ToModel, WithHeadingRow
{

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
        
        foreach ($importData as $row) {
            $contactId = isset($row['contact_id']) && is_numeric($row['contact_id']) ? $row['contact_id'] : null;
            $advanceId = isset($row['advance_id']) && is_numeric($row['advance_id']) ? $row['advance_id'] : null;

            if(isset($row['trans_type']) && !is_string($row['trans_type'])) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>Transaction type \"".$row['trans_type']."\" is invalid (Contact: ".$contactId.". Advance: ".$advanceId.").</div></div>";
                $errors = true;
                Log::channel('paymentdetails')->error('Transaction type "'.$row['trans_type'].'" is invalid. ', [
                    'contact_id' => $contactId,
                    'advance_id' => $advanceId
                ]);
            }
            if(isset($row['amount']) && is_string($row['amount'])) {
                $row['amount'] = str_replace(',','',$row['amount']);
            }
            if(isset($row['amount']) && !is_numeric($row['amount'])) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>Amount \"".$row['amount']."\" is invalid (Contact: ".$contactId.". Advance: ".$advanceId.").</div></div>";
                $errors = true;
                Log::channel('paymentdetails')->error('Amount "'.$row['amount'].'" is invalid. ', [
                    'contact_id' => $contactId,
                    'advance_id' => $advanceId
                ]);
            }
            if(isset($row['balance']) && is_string($row['balance'])) {
                $row['balance'] = str_replace(',','',$row['balance']);
            }
            if(isset($row['balance']) && !is_numeric($row['balance'])) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>Balance \"".$row['balance']."\" is invalid (Contact: ".$contactId.". Advance: ".$advanceId.").</div></div>";
                $errors = true;
                Log::channel('paymentdetails')->error('Balance "'.$row['balance'].'" is invalid. ', [
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
        $paymentAmount = (isset($row['amount']) && is_string($row['amount'])) ? floatval(str_replace(',','',$row['amount'])) : $row['amount'];
        $paymentBalance = (isset($row['balance']) && is_string($row['balance'])) ? floatval(str_replace(',','',$row['balance'])) : $row['balance'];
        $id = isset($row['id']) && is_numeric($row['id']) ? $row['id'] : null;
        
        if (!PaymentDetailReport::where('id', '=', $id)->exists()) {
            return new PaymentDetailReport([
                'contact_id' => isset($row['contact_id']) && is_numeric($row['contact_id']) ? $row['contact_id'] : null,
                'id' => $id,
                'trans_id' => isset($row['trans_id']) && is_numeric($row['trans_id']) ? $row['trans_id'] : null,
                'advance_id' => isset($row['advance_id']) && is_numeric($row['advance_id']) ? $row['advance_id'] : null,
                'funding_date' => isset($row['funding_date']) && $row['funding_date']!='null' ? Carbon::parse($row['funding_date'])->format('Y-m-d') : null,
                'process_date' => isset($row['process_date']) && $row['process_date']!='null' ? Carbon::parse($row['process_date'])->format('Y-m-d') : null,
                'cleared_date' => isset($row['cleared_date']) && $row['cleared_date']!='null' ? Carbon::parse($row['cleared_date'])->format('Y-m-d') : null,
                'amount' => is_numeric($paymentAmount) ? $paymentAmount : null,
                'status' => $row['status'],
                'balance' => is_numeric($paymentBalance) ? $paymentBalance : null,
                'sub_type' => $row['sub_type'],
                'memo' => $row['memo'],
                'return_code' => $row['return_code'],
                'return_date' => isset($row['return_date']) && $row['return_date']!='null' ? Carbon::parse($row['return_date'])->format('Y-m-d') : null,
                'return_reason' => $row['return_reason'],
                'trans_type' => $row['trans_type'],
                'custodial_account' => $row['custodial_account'],
            ]);
        }
    }
}
