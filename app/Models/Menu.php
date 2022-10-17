<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public function roles() {
        return $this->belongsToMany(Role::class, "user_access", "menu_id", "role_id");
    }
}
