<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Spatie\Permission\Models\Kanim as KanimSpatie;
class Kanim extends Model
{
    use HasFactory;
    public $table = 'kanims';
    protected $fillable = [
        'name', 'alamat', 'telp', 'longitude', 'latitude', 'network'
    ];

    public function printer() {
        return $this->hasMany(Printer::class);

    }
}
