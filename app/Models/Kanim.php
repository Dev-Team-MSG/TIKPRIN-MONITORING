<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kanim extends Model
{
    protected $table = 'kanims';
    protected $fillable = [
        'name', 'network'
    ];
}
