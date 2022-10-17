<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAccess extends Model
{
    use HasFactory;
    protected $table = "user_access";
    protected $fillable = [
        "role_id",
        "menu_id",
        "view",
        "add",
        "edit",
        "delete"
    ];
    
    public function roles() {
        return $this->belongsTo(Role::class, "role_id");
    }
}
