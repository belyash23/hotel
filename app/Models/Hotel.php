<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function owner() {
        return $this->hasOne(User::class, 'id', 'owner_id');
    }
    public function director() {
        return $this->hasOne(User::class, 'id', 'director_id');
    }
}
