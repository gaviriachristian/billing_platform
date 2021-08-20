<?php

namespace App\Imports;

use App\Models\PaymentDetailReport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class PaymentDetailReportImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new PaymentDetailReport([
            'contact_id' => isset($row['contact_id']) && is_numeric($row['contact_id']) ? $row['contact_id'] : null,
            'id' => isset($row['id']) && is_numeric($row['id']) ? $row['id'] : null,
            'trans_id' => isset($row['trans_id']) && is_numeric($row['trans_id']) ? $row['trans_id'] : null,
            'advance_id' => isset($row['advance_id']) && is_numeric($row['advance_id']) ? $row['advance_id'] : null,
            'funding_date' => isset($row['funding_date']) && $row['funding_date']!='null' ? Carbon::parse($row['funding_date'])->format('Y-m-d') : null,
            'process_date' => isset($row['process_date']) && $row['process_date']!='null' ? Carbon::parse($row['process_date'])->format('Y-m-d') : null,
            'cleared_date' => isset($row['cleared_date']) && $row['cleared_date']!='null' ? Carbon::parse($row['cleared_date'])->format('Y-m-d') : null,
            'amount' => isset($row['amount']) && is_numeric($row['amount']) ? $row['amount'] : null,
            'status' => $row['status'],
            'balance' => isset($row['balance']) && is_numeric($row['balance']) ? $row['balance'] : null,
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
