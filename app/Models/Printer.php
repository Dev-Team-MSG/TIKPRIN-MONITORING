<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Permission\Models\Printer as PrinterSpatie;


class Printer extends Model
{
    use HasFactory;
    // use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'serial_number',
        'mac_address',
        'tahun_pengadaan',
        'kanim_id',
        'created_by',
        'created_at',
        'updated_at'
    ];

    public function creator(){
        return $this->belongsTo('App\Models\User','created_by');
    }

    public function editor(){
        return $this->belongsTo('App\Models\User','updated_by');
    }

    public function location(){
        return $this->belongsTo('App\Models\Kanim','kanim_id');
    }

    
}
