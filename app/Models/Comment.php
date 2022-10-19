<?php

namespace App\Models;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "no_ticket",
        "body"
    ];

    public function ticket() {
        return $this->belongsTo(Ticket::class, "no_ticket", "no_ticket");
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
