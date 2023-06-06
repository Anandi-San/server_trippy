<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class room extends Model
{
    use HasFactory;

    protected $guarded = [
    ];

    public function scopeFilter($query, array $filters){


        $query->when($filters['check_in'] ?? false, function($query, $check_in){
            $tanggal = date('Y-m-d', strtotime($check_in));
            return $query->whereDate('rooms.check_in', '=', $tanggal);
        });

        $query->when($filters['description'] ?? false, function($query, $desk){
            return $query->whereHas('products', function($query) use ($desk){
                $query->where('products.description', 'like', $desk);
            });
        });

        $query->whereDate('rooms.check_in', '>=', now()->toDateString());
        $query->where('rooms.amount', '>', 0);


    }

    public function produk(){
        return $this->belongsTo(produk::class);
    }

    public function booking(){
        return $this->hasMany(booking::class);
    }
}
