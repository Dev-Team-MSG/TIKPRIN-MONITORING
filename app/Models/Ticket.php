<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "category_id",
        "assign_to",
        "severity",
        "title",
        "description",
        "status_id",
    ];
    protected $hidden = [
        'category_ticket_id',
        'severity_id',
    ];

    protected static function boot(){
        parent::boot();
     
        static::created(function ($model) {
          $model->no_ticket = "Tiket-" . $model->id;
          $model->save();
        });
      }

    public function category() {
        return $this->belongsTo(CategoryTicket::class, "category_ticket_id");
    }

    public function severity() {
        return $this->belongsTo(Severity::class, "severity_id");
    }
    public function assign_to() {
        return $this->belongsTo(AssignTiket::class, "assign_to");
    }

    public function owner() {
        return $this->belongsTo(User::class, "owner");
    }

    public function comments() {
        return $this->hasMany(Comment::class, "no_ticket", "no_ticket");
    }

    public function files() {
        return $this->morphMany(File::class, "fileable");
    }
}
