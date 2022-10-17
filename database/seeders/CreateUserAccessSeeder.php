<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\UserAccess;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CreateUserAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_id = [1,2,3];
        $menu_id = [1,2];
        foreach($role_id as $role) {
            foreach($menu_id as $menu) {
                if($role==1) {
                    UserAccess::create([
                        "role_id" => $role,
                        "menu_id" => $menu,
                        "view" => 1,
                        "add" => 1,
                        "edit" => 1,
                        "delete" => 1
                    ]);
                }else if($role == 2) {
                    if($menu == 2) {
                        UserAccess::create([
                            "role_id" => $role,
                            "menu_id" => $menu,
                            "view" => 1,
                            "edit" => 1
                        ]);
                    }else {
                        UserAccess::create([
                            "role_id" => $role,
                            "menu_id" => $menu,
                        ]);
                    }
                }else {
                    UserAccess::create([
                        "role_id" => $role,
                        "menu_id" => $menu,
                        "view" => 1,
                        "add" => 1,
                        "edit" => 1,
                        "delete" => 1
                    ]);
                }
            }
        }
        
    }
}
