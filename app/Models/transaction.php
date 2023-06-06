<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;

    protected $guarded = [
    ];

    public function scopeFilter($query, array $filters){

        $query->when($filters['username'] ?? false, function($query, $username){
            return $query->whereHas('User', function($query) use ($username){
                $query->where('name', 'like', "%" . $username . "%");
            });
        });
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
