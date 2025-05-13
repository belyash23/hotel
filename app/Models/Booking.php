<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function guest() {
        return $this->belongsTo(Guest::class);
    }
    public function room() {
        return $this->belongsTo(Room::class);
    }
}
