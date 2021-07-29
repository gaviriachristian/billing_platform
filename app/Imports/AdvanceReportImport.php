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
            'contact_id'        => $row['contact_id'],
            'advance_id'        => $row['advance_id'], 
            'business_name'     => $row['business_name'], 
            'full_name'         => $row['full_name'], 
            'funding_date'      => Carbon::parse($row['funding_date'])->format('Y-m-d'),
            'last_history_date' => Carbon::parse($row['last_history_date'])->format('Y-m-d H:i:s'),
            'funding_amount'    => $row['funding_amount'], 
            'rtr'               => $row['rtr'], 
            'payment'           => $row['payment'],
        ]);
    }
}
