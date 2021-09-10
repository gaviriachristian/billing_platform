<?php

namespace App\Imports;

use Session;
use App\Models\AdvanceReport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdvanceReportImport implements ToModel, WithHeadingRow
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

            if(isset($row['business_name']) && !is_string($row['business_name'])) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>Business name \"".$row['business_name']."\" is invalid (Contact: ".$contactId.". Advance: ".$advanceId.").</div></div>";
                $errors = true;
                Log::channel('advance')->error('Business name "'.$row['business_name'].'" is invalid.', [
                    'contact_id' => $contactId,
                    'advance_id' => $advanceId
                ]);
            }
            if(isset($row['funding_amount']) && !is_numeric($row['funding_amount'])) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>Funding amount \"".$row['funding_amount']."\" is invalid (Contact: ".$contactId.". Advance: ".$advanceId.").</div></div>";
                $errors = true;
                Log::channel('advance')->error('Funding amount "'.$row['funding_amount'].'" is invalid.', [
                    'contact_id' => $contactId,
                    'advance_id' => $advanceId
                ]);
            }
            if(isset($row['payment']) && !is_numeric($row['payment'])) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>Payment \"".$row['payment']."\" is invalid (Contact: ".$contactId.". Advance: ".$advanceId.").</div></div>";
                $errors = true;
                Log::channel('advance')->error('Payment "'.$row['payment'].'" is invalid.', [
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
        return new AdvanceReport([
            'contact_id' => isset($row['contact_id']) && is_numeric($row['contact_id']) ? $row['contact_id'] : null,
            'advance_id' => isset($row['advance_id']) && is_numeric($row['advance_id']) ? $row['advance_id'] : null,
            'business_name' => $row['business_name'], 
            'full_name' => $row['full_name'], 
            'funding_date' => isset($row['funding_date']) && $row['funding_date']!='null' ? Carbon::parse($row['funding_date'])->format('Y-m-d') : null,
            'last_history_date' => isset($row['last_history_date']) && $row['last_history_date']!='null' ? Carbon::parse($row['last_history_date'])->format('Y-m-d H:i:s') : null,
            'funding_amount' => isset($row['funding_amount']) && is_numeric($row['funding_amount']) ? $row['funding_amount'] : null,
            'rtr' => isset($row['rtr']) && is_numeric($row['rtr']) ? $row['rtr'] : null,
            'payment' => isset($row['payment']) && is_numeric($row['payment']) ? $row['payment'] : null,
            'freq' => $row['freq'],
            'factor' => isset($row['factor']) && is_numeric($row['factor']) ? $row['factor'] : null,
            'term_days' => isset($row['term_days']) && is_numeric($row['term_days']) ? $row['term_days'] : null,
            'term_months' => isset($row['term_months']) && is_numeric($row['term_months']) ? $row['term_months'] : null,
            'holdback' => isset($row['holdback']) && is_numeric($row['holdback']) ? $row['holdback'] : null,
            'origination_fee' => isset($row['origination_fee']) && is_numeric($row['origination_fee']) ? $row['origination_fee'] : null,
            'days_since_funding' => isset($row['days_since_funding_bus']) && is_numeric($row['days_since_funding_bus']) ? $row['days_since_funding_bus'] : null,
            'advance_type' => $row['advance_type'],
            'method' => $row['method'],
            'modified' => isset($row['modified']) && $row['modified']!='null' ? Carbon::parse($row['modified'])->format('Y-m-d H:i:s') : null,
            'advance_status' => $row['advance_status'],
            'balance' => isset($row['balance']) && is_numeric($row['balance']) ? $row['balance'] : null,
            'est_payoff_date' => isset($row['est_payoff_date']) && $row['est_payoff_date']!='null' ? Carbon::parse($row['est_payoff_date'])->format('Y-m-d') : null,
            'received' => isset($row['received']) && is_numeric($row['received']) ? $row['received'] : null,
            'last_merchant_cleared' => isset($row['last_merchant_cleared_date']) && $row['last_merchant_cleared_date']!='null' ? Carbon::parse($row['last_merchant_cleared_date'])->format('Y-m-d') : null,
            'ach_drafting' => isset($row['ach_drafting']) && $row['ach_drafting']=="On" ? true : false,
            'paused' => isset($row['paused']) && $row['paused']=="Yes" ? true : false,
            'assigned' => $row['assigned_company'],
            'account_number' => isset($row['account_number']) && is_numeric($row['account_number']) ? $row['account_number'] : null,
            'routing_number' => isset($row['routing_number']) && is_numeric($row['routing_number']) ? $row['routing_number'] : null,
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'broker' => $row['nbroker'],
            'broker_upfront_amount' => isset($row['broker_upfront_amount']) && is_numeric($row['broker_upfront_amount']) ? $row['broker_upfront_amount'] : null,
            'gateway' => $row['gateway'],
            'portfolio' => $row['nportfolio'],
            'number_of_payments' => isset($row['of_payments']) && is_numeric($row['of_payments']) ? $row['of_payments'] : null,
            'bitty_renewals_manager' => $row['bitty_renewals_manager']
        ]);
    }
}