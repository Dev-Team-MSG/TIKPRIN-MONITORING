<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignTiket extends Model
{
    use HasFactory;
    protected $table = "users";
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function ticket() {
        return $this->hasMany(Ticket::class);
    }
}
