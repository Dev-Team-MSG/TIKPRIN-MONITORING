<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPrinter extends Model
{
    use HasFactory;
    protected $table = 'log_printer';
    // protected $fillable = [
    //     'kanim_id', 'printer_id'
    // ];


    public function location_lama(){
        return $this->belongsTo('App\Models\Kanim','kanim_lama');
    }
    public function location_baru(){
        return $this->belongsTo('App\Models\Kanim','kanim_baru');
    }
}
