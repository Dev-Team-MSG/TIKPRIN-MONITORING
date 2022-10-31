<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Imports\UsersImport;
use Laravel\Sanctum\HasApiTokens;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name'     => $row[1],
            'email'    => $row[2],
            'username'    => $row[3],
            'password' => \Hash::make($row[4]),
            'roles' => $row[5],
            'phone' => $row[6],
            'kanim_id' => $row[7]

            // 'phone'    => $row[2],
            // 'password' => Hash::make($row[3]),
        ]);
    }
}
