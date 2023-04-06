<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
    $user = new User();
    
        $user->name = $row[1];
        $user->email = $row[2];
        $user->username = $row[3];
        $user->password = \Hash::make($row[4]);
        // $user->password = $row[4];
        $user->syncRoles($row[5]);
        $user->phone = $row[6];
        $user->kanim_id = $row[7];
        
        return $user;
    
    }
}
