<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrinterKanim extends Model
{
    use HasFactory;
    protected $table = 'printer_kanim';
    protected $fillable = [
        'kanim_id', 'printer_id'
    ];

    // public function printers() {
    //     return $this->belongsTo('App\Models\Printer', 'printer_id', 'id');
    // }
    public function printers(){
        return $this->belongsTo(Printer::class, 'printer_id', 'id');
    }

    public function kanims(){
        return $this->belongsTo(Kanim::class, 'kanim_id', 'id');
    }

    // public function kanims() {
    //     return $this->belongsTo('App\Models\Kanim', 'kanim_id', 'id');
    // }

    

    public function printeronkanim(){
        $printermapping = PrinterKanim::select('printer_id')->get();
        $printerId = Printer::select('id', 'serial_number', 'mac_address')->whereNotIn('id', $printermapping)->get();
        return $printerId;
    }


    public function scopeSearch($query, $keyword) {
        $printerId = Printer::select('id')->where('serial_number', 'iLIKE', "%$keyword%")->get()->toArray();
        $kanimId = Kanim::select('id')->where('name', 'iLIKE', "%$keyword%")->get()->toArray();
        if ($keyword!='') {
            $query->where(function ($query) use ($keyword, $printerId, $kanimId) {
                $query->whereIn("printer_id", $printerId)
                ->orWhereIn("kanim_id", $kanimId);
            });
        }
        return $query;
    }
}
