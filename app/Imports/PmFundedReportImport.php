<?php

namespace App\Imports;

use App\Models\PmFundedReport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class PmFundedReportImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PmFundedReport([
            'contact_id' => isset($row['contact_id']) && is_numeric($row['contact_id']) ? $row['contact_id'] : null,
            'advance_id' => isset($row['advance_id']) && is_numeric($row['advance_id']) ? $row['advance_id'] : null,
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
            'syndicators_name' => $row['syndicators_name'],
            'syndicators_amt' => isset($row['syndicators_amt']) && is_numeric($row['syndicators_amt']) ? $row['syndicators_amt'] : null,
            'syndicators_rtr' => isset($row['syndicators_rtr']) && is_numeric($row['syndicators_rtr']) ? $row['syndicators_rtr'] : null,
            'syn_of_adv' => isset($row['syn_of_adv']) && is_numeric($row['syn_of_adv']) ? $row['syn_of_adv'] : null,
            'syn_servicing_fee' => isset($row['syn_servicing_fee']) && is_numeric($row['syn_servicing_fee']) ? $row['syn_servicing_fee'] : null,
            'address' => $row['address'],
            'city' => $row['city'],
            'state' => $row['state'],
            'zip_code' => isset($row['zip_code']) && is_numeric($row['zip_code']) ? $row['zip_code'] : null,
            'email' => $row['e_mail'],
            'cell_phone' => isset($row['cell_phone']) && is_numeric($row['cell_phone']) ? $row['cell_phone'] : null,
        ]);
    }
}
