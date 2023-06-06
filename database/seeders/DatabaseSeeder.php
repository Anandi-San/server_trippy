<?php

namespace Database\Seeders;

use App\Models\product;
use App\Models\role;
use App\Models\room;
use App\Models\schedule;
use App\Models\transaction;
use App\Models\type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        role::create([
            'role'=> 'admin'
        ]);
        role::create([
            'role'=> 'mitra'
        ]);
        role::create([
            'role'=> 'pengguna'
        ]);

        User::create([
            'name'=> 'Fauzan',
            'email'=> 'fauzan123@gmail.com',
            'password'=> bcrypt('12345678'),
            'role_id'=> 13
        ]);

       
        User::create([
            'name'=> 'Sintia',
            'email'=> 'sintia123@gmail.com',
            'password'=> bcrypt('12345678'),
            'role_id'=> 14
        ]);


        User::create([
            'name'=> 'Agung',
            'email'=> 'agung1233@gmail.com',
            'password'=> bcrypt('12345678'),
            'role_id'=> 15
        ]);

        transaction::create([
            'user_id' => 12,
            'saldo_awal' => 0,
            'debit' => 0,
            'kredit' => 2000000,
            'saldo_akhir' => 2000000,
            'keterangan' => 'tip hotel'

        ]);

       transaction::create([
            'user_id' => 12,
            'saldo_awal' => 0,
            'debit' => 0,
            'kredit' => 5000000,
            'saldo_akhir' => 5000000,
            'keterangan' => 'tip pesawat'

        ]);

       transaction::create([
            'user_id' => 12,
            'saldo_awal' => 500000,
            'debit' => 0,
            'kredit' => 0,
            'saldo_akhir' => 500000,
            'keterangan' => 'topup perdana'

        ]);

        type::create([
            'type' => 'pesawat',
        ]);

        type::create([
            'type' => 'hotel',
        ]);

        product::create([
            'name_product'=> 'Citilink',
            'description'=> 'Ekonomi',
            'user_id' => 12,
            'types_id' => 5
        ]);

        product::create([
            'name_product'=> 'Lion Air',
            'description'=> 'Bisnis',
            'user_id' => 12,
            'types_id' => 5
        ]);

        product::create([
            'name_product'=> 'Banua Patra',
            'description'=> 'Bisnis',
            'user_id' => 12,
            'types_id' => 6
        ]);

        schedule::create([
            'product_id'=> 6,
            'kota_asal' => 'Jakarta',
            'kota_tiba' => 'Banjarmasin',
            'tgl_pergi' => '2023-06-12',
            'tgl_tiba' => '2023-06-12',
            'waktu_pergi' => '10:10:00',
            'waktu_tiba' => '13:30:00',
            'amount' => 3,
            'price' => 500000
        ]);

        schedule::create([
            'product_id'=> 7,
            'kota_asal' => 'Jakarta',
            'kota_tiba' => 'Balikpapan',
            'tgl_pergi' => '2023-06-12',
            'tgl_tiba' => '2023-06-12',
            'waktu_pergi' => '07:10:00',
            'waktu_tiba' => '10:30:00',
            'amount' => 1,
            'price' => 1000000
        ]);

        $now = Carbon::now();

        room::create([
            'product_id' => 6,
            'price' => 500000,
            'amount' => 1,
            'check_in' => '2023-06-20'
        ]);

        room::create([
            'product_id' => 8,
            'price' => 1000000,
            'amount' => 1,
            'check_in' => '2023-06-20'
        ]);
    }
}
