<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $guarded = [
    ];

    public function booking(){
        return $this->hasMany(booking::class);
    }

    public function schedule(){
        return $this->hasMany(schedule::class);
    }

    public function room(){
        return $this->hasMany(room::class);
    }

    public function type(){
        return $this->belongsTo(type::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
