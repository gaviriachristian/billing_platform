<?php

namespace App\Imports;

use App\Models\NachaReport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class NachaReportImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $rowNacha['log_date'] = date("Y-m-d H:i:s");
        $rowNacha['type_code'] = substr($row[0],0,1);
        $rowNacha['trans_code'] = substr($row[0],1,2);
        $rowNacha['routing_number'] = substr($row[0],3,9);
        $rowNacha['account_number'] = substr($row[0],12,17);
        $amount = substr($row[0],29,10);
        $rowNacha['amount'] = number_format(substr($amount, 0, -2).'.'.substr($amount, -2), 2);
        $rowNacha['trans_id'] = substr($row[0],39,15);
        $rowNacha['name'] = substr($row[0],54,22);
        $rowNacha['dis_data'] = substr($row[0],76,3);
        $rowNacha['trace_number'] = substr($row[0],79,15);
        $rowNacha['processed'] = 1;

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
