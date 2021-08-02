<?php

namespace App\Imports;

use App\Models\AdvanceReport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class AdvanceReportImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AdvanceReport([
            'contact_id' => isset($row['contact_id']) && is_integer($row['contact_id']) ? $row['contact_id'] : null,
            'advance_id' => isset($row['advance_id']) && is_integer($row['advance_id']) ? $row['advance_id'] : null,
            'business_name' => $row['business_name'], 
            'full_name' => $row['full_name'], 
            'funding_date' => isset($row['funding_date']) && $row['funding_date']!='null' ? Carbon::parse($row['funding_date'])->format('Y-m-d') : null,
            'last_history_date' => isset($row['last_history_date']) && $row['last_history_date']!='null' ? Carbon::parse($row['last_history_date'])->format('Y-m-d H:i:s') : null,
            'funding_amount' => isset($row['funding_amount']) && is_integer($row['funding_amount']) ? $row['funding_amount'] : null,
            'rtr' => isset($row['rtr']) && is_integer($row['rtr']) ? $row['rtr'] : null,
            'payment' => isset($row['payment']) && is_numeric($row['payment']) ? $row['payment'] : null,
            'freq' => $row['freq'],
            'factor' => isset($row['factor']) && is_numeric($row['factor']) ? $row['factor'] : null,
            'term_days' => isset($row['term_days']) && is_integer($row['term_days']) ? $row['term_days'] : null,
            'term_months' => isset($row['term_months']) && is_integer($row['term_months']) ? $row['term_months'] : null,
            'holdback' => isset($row['holdback']) && is_integer($row['holdback']) ? $row['holdback'] : null,
            'origination_fee' => isset($row['origination_fee']) && is_integer($row['origination_fee']) ? $row['origination_fee'] : null,
            'days_since_funding' => isset($row['days_since_funding_bus']) && is_integer($row['days_since_funding_bus']) ? $row['days_since_funding_bus'] : null,
            'advance_type' => $row['advance_type'],
            'method' => $row['method'],
            'modified' => isset($row['modified']) && $row['modified']!='null' ? Carbon::parse($row['modified'])->format('Y-m-d H:i:s') : null,
            'advance_status' => $row['advance_status'],
            'balance' => isset($row['balance']) && is_numeric($row['balance']) ? $row['balance'] : null,
            'est_payoff_date' => isset($row['est_payoff_date']) && $row['est_payoff_date']!='null' ? Carbon::parse($row['est_payoff_date'])->format('Y-m-d') : null,
            'received' => isset($row['received']) && is_integer($row['received']) ? $row['received'] : null,
            'last_merchant_cleared' => isset($row['last_merchant_cleared_date']) && $row['last_merchant_cleared_date']!='null' ? Carbon::parse($row['last_merchant_cleared_date'])->format('Y-m-d') : null,
            'ach_drafting' => isset($row['ach_drafting']) && $row['ach_drafting']=="On" ? true : false,
            'paused' => isset($row['paused']) && $row['paused']=="Yes" ? true : false,
            'assigned' => $row['assigned_company'],
            'account_number' => isset($row['account_number']) && is_integer($row['account_number']) ? $row['account_number'] : null,
            'routing_number' => isset($row['routing_number']) && is_integer($row['routing_number']) ? $row['routing_number'] : null,
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'broker' => $row['nbroker'],
            'broker_upfront_amount' => isset($row['broker_upfront_amount']) && is_numeric($row['broker_upfront_amount']) ? $row['broker_upfront_amount'] : null,
            'gateway' => $row['gateway'],
            'portfolio' => $row['nportfolio'],
            'number_of_payments' => isset($row['of_payments']) && is_integer($row['of_payments']) ? $row['of_payments'] : null,
            'bitty_renewals_manager' => $row['bitty_renewals_manager']

        ]);
    }
}
