<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Severity extends Model
{
    use HasFactory;
    protected $fillable = ["severity"];

    public function ticket() {
        return $this->hasMany(Ticket::class);
    }
}
