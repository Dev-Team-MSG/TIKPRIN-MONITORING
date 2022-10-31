<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Printer extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'serial_number',
        'mac_address',
    ];

    public function creator(){
        return $this->belongsTo('App\Models\User','created_by');
    }

    public function editor(){
        return $this->belongsTo('App\Models\User','updated_by');
    }
}
