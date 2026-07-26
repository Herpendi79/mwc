<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AnggotaModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserAnggotaSeeder extends Seeder
{
    public function run(): void
    {
        // Data contoh
        $data = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta',
                'telpon' => '081234567890',
                'status' => 'aktif',
                'keterangan' => 'Anggota baru cabang Jakarta'
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@example.com',
                'alamat' => 'Jl. Diponegoro No. 5, Bandung',
                'telpon' => '081398765432',
                'status' => 'menunggu validasi',
                'keterangan' => 'Menunggu verifikasi KTP'
            ]
        ];

        DB::transaction(function () use ($data) {
            foreach ($data as $item) {
                // 1. Buat User
                $user = User::create([
                    'name'              => $item['name'],
                    'email'             => $item['email'],
                    'role'              => 'anggota',
                    'email_verified_at' => now(),
                    'password'          => Hash::make('password123'), // Default password
                ]);

                // 2. Buat Anggota (relasi dengan user_id)
                AnggotaModel::create([
                    'user_id'    => $user->id,
                    'alamat'     => $item['alamat'],
                    'telpon'     => $item['telpon'],
                    'status'     => $item['status'],
                    'keterangan' => $item['keterangan'],
                ]);
            }
        });
    }
}
