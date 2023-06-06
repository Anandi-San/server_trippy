<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule extends Model
{
    use HasFactory;

    protected $guarded = [
    ];

    public function scopeFilter($query, array $filters){
        $query->when($filters['check_in'] ?? false, function($query, $check_in){
            $tanggal = date('Y-m-d', strtotime($check_in));
            return $query->whereDate('schedules.tgl_pergi', '=', $tanggal);

        });

        $query->when($filters['kota_asal'] ?? false, function($query, $kotaasal){
            return $query->whereHas('product', function($query) use ($kotaasal){
                $query->where('schedules.kota_asal', 'like', $kotaasal);
            });
        });

        $query->when($filters['kota_tiba'] ?? false, function($query, $kotatiba){
            return $query->whereHas('product', function($query) use ($kotatiba){
                $query->where('schedules.kota_tiba', 'like', $kotatiba);
            });
        });

        $query->where('schedules.amount', '>', 0);
    }

    public function product(){
        return $this->belongsTo(product::class);
    }

    public function booking(){
        return $this->hasMany(booking::class);
    }
}
