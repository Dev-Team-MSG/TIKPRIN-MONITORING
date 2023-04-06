<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'kode_menu';
    public $incrementing = false;
    protected $keyType = 'string';
}
