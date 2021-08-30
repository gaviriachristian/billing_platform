<?php

namespace App\Imports;

use Session;
use App\Models\PmFundedReport;
use App\Models\SyndicateDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class PmFundedReportImport implements ToModel, WithHeadingRow
{


    
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
        
        /*
        $foo =serialize($array_foo);
        $bar =serialize($array_bar);
        if ($foo == $bar) echo "Foo and bar are equal";

        foreach ($importData as $row) {
            $contactId = isset($row['contact_id']) && is_numeric($row['contact_id']) ? $row['contact_id'] : null;
            $advanceId = isset($row['advance_id']) && is_numeric($row['advance_id']) ? $row['advance_id'] : null;
            
            $syndicatorsAmt = isset($row['syndicators_amt']) && is_numeric($row['syndicators_amt']) ? $row['syndicators_amt'] : 0;
            if(isset($syndicatorsAmtSum[$contactId.'_'.$advanceId])) {
                $syndicatorsAmtSum[$contactId.'_'.$advanceId] += $syndicatorsAmt; 
            } else {
                $syndicatorsAmtSum[$contactId.'_'.$advanceId] = $syndicatorsAmt; 
            }

            if(!isset($netFundingAmt[$contactId.'_'.$advanceId]) || $netFundingAmt[$contactId.'_'.$advanceId]==0) {
                $netFundingAmt[$contactId.'_'.$advanceId] = isset($row['net_funding_amt']) && is_numeric($row['net_funding_amt']) ? $row['net_funding_amt'] : 0;
                $businessName[$contactId.'_'.$advanceId] = $row['business_name'];
            }

            $synOfAdv = isset($row['syn_of_adv']) && is_numeric($row['syn_of_adv']) ? $row['syn_of_adv'] : 0;
            if($synOfAdv < 1) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>Syn % Of Adv in ".$row['syndicators_name']." is less than 100% (Contact: ".$contactId.". Advance: ".$advanceId.").</div></div>";
            }
        }
        
        foreach ($syndicatorsAmtSum as $index => $syndicatorsAmtTotal) {
            if ($syndicatorsAmtTotal != $netFundingAmt[$index]) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>The sum for Syndicators Amount (".$syndicatorsAmtTotal.") in ".$businessName[$index]." is not equal to Net Funding Amount (".$netFundingAmt[$index]."). (Contact: ".$contactId.". Advance: ".$advanceId.").</div></div>";
            }
        }
        
        if(empty($message) || $message==$comparisonMessage) {
            $message = "<div class='alert alert-success' role='alert'><div class='alert-body'>The file \"".$fileName."\" has been imported successfully.</div></div>".$message;
            Session::flash('message', $message); 
            return true;
        } else {
            $message = "<div class='validateText'>Validate the following errors in the \"".$fileName."\" imported file:</div>".$message;
            Session::flash('message', $message); 
            return false;
        }*/

        return true;
    }

    /**
    * @param array $importData
    * @param string $fileName
    *
    * @return bool
    */
    public function validateImport(array $importData, $fileName="Undefined")
    {
        $netFundingAmt = [];
        $syndicatorsAmtSum = [];
        $count=0;
        $message = "";
        $errors = false;
        
        foreach ($importData as $row) {
            $contactId = isset($row['contact_id']) && is_numeric($row['contact_id']) ? $row['contact_id'] : null;
            $advanceId = isset($row['advance_id']) && is_numeric($row['advance_id']) ? $row['advance_id'] : null;
            
            $syndicatorsAmt = isset($row['syndicators_amt']) && is_numeric($row['syndicators_amt']) ? $row['syndicators_amt'] : 0;
            if(isset($syndicatorsAmtSum[$contactId.'_'.$advanceId])) {
                $syndicatorsAmtSum[$contactId.'_'.$advanceId] += $syndicatorsAmt; 
            } else {
                $syndicatorsAmtSum[$contactId.'_'.$advanceId] = $syndicatorsAmt; 
            }

            if(!isset($netFundingAmt[$contactId.'_'.$advanceId]) || $netFundingAmt[$contactId.'_'.$advanceId]==0) {
                $netFundingAmt[$contactId.'_'.$advanceId] = isset($row['net_funding_amt']) && is_numeric($row['net_funding_amt']) ? $row['net_funding_amt'] : 0;
                $businessName[$contactId.'_'.$advanceId] = $row['business_name'];
            }

            $synOfAdv = isset($row['syn_of_adv']) && is_numeric($row['syn_of_adv']) ? $row['syn_of_adv'] : 0;
            if($synOfAdv < 1) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>Syn % Of Adv in ".$row['syndicators_name']." is less than 100% (Contact: ".$contactId.". Advance: ".$advanceId.").</div></div>";
                $errors = true;
            }
        }
        
        foreach ($syndicatorsAmtSum as $index => $syndicatorsAmtTotal) {
            if ($syndicatorsAmtTotal != $netFundingAmt[$index]) {
                $message .= "<div class='alert alert-danger' role='alert'><div class='alert-body'>The sum for Syndicators Amount (".$syndicatorsAmtTotal.") in ".$businessName[$index]." is not equal to Net Funding Amount (".$netFundingAmt[$index]."). (Contact: ".$contactId.". Advance: ".$advanceId.").</div></div>";
                $errors = true;
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
        $contactId = isset($row['contact_id']) && is_numeric($row['contact_id']) ? $row['contact_id'] : null;
        $advanceId = isset($row['advance_id']) && is_numeric($row['advance_id']) ? $row['advance_id'] : null;

        if (!PmFundedReport::where('contact_id', '=', $contactId)->where('advance_id', '=', $advanceId)->exists()) {
            return new PmFundedReport([
                'contact_id' => $contactId,
                'advance_id' => $advanceId,
                'funding_date' => isset($row['funding_date']) && $row['funding_date']!='null' ? Carbon::parse($row['funding_date'])->format('Y-m-d') : null,
                'business_name' => $row['business_name'],
                'last_name' => $row['last_name'],
                'first_name' => $row['first_name'],
                'funding_amount' => isset($row['funding_amount']) && is_numeric($row['funding_amount']) ? $row['funding_amount'] : null,
                'rtr' => isset($row['rtr']) && is_numeric($row['rtr']) ? $row['rtr'] : null,
                'payment' => isset($row['payment']) && is_numeric($row['payment']) ? $row['payment'] : null,
                'freq' => $row['freq'],
                'factor' => isset($row['factor']) && is_numeric($row['factor']) ? $row['factor'] : null,
                'term_days' => isset($row['term_days']) && is_numeric($row['term_days']) ? $row['term_days'] : null,
                'term_months' => isset($row['term_months']) && is_numeric($row['term_months']) ? $row['term_months'] : null,
                'holdback' => isset($row['holdback']) && is_numeric($row['holdback']) ? $row['holdback'] : null,
                'origination_fee' => isset($row['origination_fee']) && is_numeric($row['origination_fee']) ? $row['origination_fee'] : null,
                'program_fee' => isset($row['program_fee']) && is_numeric($row['program_fee']) ? $row['program_fee'] : null,
                'wire_fee' => isset($row['wire_fee']) && is_numeric($row['wire_fee']) ? $row['wire_fee'] : null,
                'other_fee_merchant' => isset($row['other_fee_merchant']) && is_numeric($row['other_fee_merchant']) ? $row['other_fee_merchant'] : null,
                'net_funding_amt' => isset($row['net_funding_amt']) && is_numeric($row['net_funding_amt']) ? $row['net_funding_amt'] : null,
                'balance_payoff' => isset($row['balance_payoff']) && is_numeric($row['balance_payoff']) ? $row['balance_payoff'] : null,
                'advance_type' => $row['advance_type'],
                'account_number' => isset($row['account_number']) && is_numeric($row['account_number']) ? $row['account_number'] : null,
                'routing_number' => isset($row['routing_number']) && is_numeric($row['routing_number']) ? $row['routing_number'] : null,
                'broker' => $row['nbroker'],
                'broker_upfront_amount' => isset($row['broker_upfront_amount']) && is_numeric($row['broker_upfront_amount']) ? $row['broker_upfront_amount'] : null,
                'broker_upfront_percent' => isset($row['broker_upfront_percent']) && is_numeric($row['broker_upfront_percent']) ? $row['broker_upfront_percent'] : null,
                'funder' => $row['funder'],
                'address' => $row['address'],
                'city' => $row['city'],
                'state' => $row['state'],
                'zip_code' => isset($row['zip_code']) && is_numeric($row['zip_code']) ? $row['zip_code'] : null,
                'email' => $row['e_mail'],
                'cell_phone' => isset($row['cell_phone']) && is_numeric($row['cell_phone']) ? $row['cell_phone'] : null,
            ]);
        }

        //$fundedReport = PmFundedReport::latest('id')->first();
        $fundedReport = PmFundedReport::where('contact_id', '=', $contactId)->where('advance_id', '=', $advanceId)->get('id');
        $fundedReportId = $fundedReport[0]->id;
        if (!empty($fundedReportId)) {
            return new SyndicateDetail([
                'funded_report_id' => $fundedReportId,
                'syndicators_name' => $row['syndicators_name'],
                'syndicators_amt' => isset($row['syndicators_amt']) && is_numeric($row['syndicators_amt']) ? $row['syndicators_amt'] : null,
                'syndicators_rtr' => isset($row['syndicators_rtr']) && is_numeric($row['syndicators_rtr']) ? $row['syndicators_rtr'] : null,
                'syn_of_adv' => isset($row['syn_of_adv']) && is_numeric($row['syn_of_adv']) ? $row['syn_of_adv'] : null,
                'syn_servicing_fee' => isset($row['syn_servicing_fee']) && is_numeric($row['syn_servicing_fee']) ? $row['syn_servicing_fee'] : null,
            ]);
        }
    }
}
