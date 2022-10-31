<?php

namespace App\Imports;

use App\Models\Printer;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Imports\PrintersImport;

class PrintersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Printer([
            'serial_number'     => $row[0],
            'mac_address'    => $row[1],
            'created_by'    => \Auth::user()->id 
            // 'phone'    => $row[2],
            // 'password' => Hash::make($row[3]),
        ]);
    }
}
