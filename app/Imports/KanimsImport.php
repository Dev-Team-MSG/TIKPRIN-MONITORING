<?php

namespace App\Imports;

use App\Models\Kanim;
// use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Illuminate\Support\Facades\Validator;

// use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Illuminate\Support\Facades\Validator;

class KanimsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        //  Validator::make($rows->toArray(), [
        //      '*.name' => 'required|unique:kanims',
        //      '*.network' => 'required|unique:kanims',
        //     //  '*.password' => 'required',
        //  ])->validate();
  
        // foreach ($rows as $row) {
        //     Kanim::create([
        //         'name' => $row['name'],
        //         'network' => $row['network'],
        //         // 'password' => bcrypt($row['password']),
        //     ]);
        // }
        $kanim = new Kanim();
    
        $kanim->name = $row[1];
        $kanim->network = $row[2];
        
        return $kanim;
    }
  
}


// class KanimsImport implements ToModel
// {
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//     public function model(array $row)
//     {
//         return new Kanim([
//             'name'  => $row[1],
//             'network' => $row[2],
//         ]);
//         // return new Kanim([
//         //     'name'      => $row['name'],
//         //     'network'     => $row['network'], 
//         //     // 'password'  => Hash::make($row['password']),
//         // ]);
//     }
// }
