<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'nim'           => '164231062',
            'nama'          => 'Primarizki Ahmad Hariyono',
            'email'         => 'oki@ftmm.unair.ac.id',
            'jenis_kelamin' => 'Laki-laki',
            'tempat_lahir'  => 'Surabaya',
            'tanggal_lahir' => '1990-01-15',
            'alamat'        => 'Wonorejo',
            'nomor_telepon' => '08123456789',
            'jenis_pekerjaan_id'     => '1',
            'prodi_id'     => '1',
            'angkatan'     => '2023',
            'password'      => Hash::make('123456'),
        ]);

        // $faker = Faker::create('id_ID');

        // // Mahasiswa
        // User::create([
        //     'nim'                 => '166231062',
        //     'email'               => 'budi@ftmm.unair.ac.id',
        //     'prodi_id'            => '5',
        //     'angkatan'            => '2023',
        //     'nama'                => 'Budi Setiawan',
        //     'jenis_kelamin'       => 'Laki-laki',
        //     'tempat_lahir'        => $faker->city(),
        //     'tanggal_lahir'       => $faker->dateTimeBetween('-24 years', '-19 years')->format('Y-m-d'),
        //     'alamat'              => $faker->address(),
        //     'nomor_telepon'       => $faker->numerify('08##########'),
        //     'jenis_pekerjaan_id'  => '1',
        //     'password'            => Hash::make('123456'),
        // ]);

        // User::create([
        //     'nim'                 => '162231062',
        //     'email'               => 'citra@ftmm.unair.ac.id',
        //     'prodi_id'            => '2',
        //     'angkatan'            => '2023',
        //     'nama'                => 'Citra Lestari', // <-- Ganti namanya
        //     'jenis_kelamin'       => 'Perempuan',
        //     'tempat_lahir'        => $faker->city(),
        //     'tanggal_lahir'       => $faker->dateTimeBetween('-24 years', '-19 years')->format('Y-m-d'),
        //     'alamat'              => $faker->address(),
        //     'nomor_telepon'       => $faker->numerify('08##########'),
        //     'jenis_pekerjaan_id'  => '1',
        //     'password'            => Hash::make('123456'),
        // ]);

        // User::create([
        //     'nim'                 => '163231062',
        //     'email'               => 'andi@ftmm.unair.ac.id',
        //     'prodi_id'            => '3',
        //     'angkatan'            => '2023',
        //     'nama'                => 'Andi Wijaya',
        //     'jenis_kelamin'       => 'Laki-laki',
        //     'tempat_lahir'        => $faker->city(),
        //     'tanggal_lahir'       => $faker->dateTimeBetween('-24 years', '-19 years')->format('Y-m-d'),
        //     'alamat'              => $faker->address(),
        //     'nomor_telepon'       => $faker->numerify('08##########'),
        //     'jenis_pekerjaan_id'  => '1',
        //     'password'            => Hash::make('123456'),
        // ]);

        // User::create([
        //     'nim'                 => '165231062',
        //     'email'               => 'faris@ftmm.unair.ac.id',
        //     'prodi_id'            => '4',
        //     'angkatan'            => '2023',
        //     'nama'                => 'Faris Ramadhan',
        //     'jenis_kelamin'       => 'Laki-laki',
        //     'tempat_lahir'        => $faker->city(),
        //     'tanggal_lahir'       => $faker->dateTimeBetween('-24 years', '-19 years')->format('Y-m-d'),
        //     'alamat'              => $faker->address(),
        //     'nomor_telepon'       => $faker->numerify('08##########'),
        //     'jenis_pekerjaan_id'  => '1',
        //     'password'            => Hash::make('123456'),
        // ]);

        $faker = Faker::create('id_ID');

        $angkatanList = [2021, 2022, 2023, 2024, 2025];
        $prodiList    = [1, 2, 3, 4, 5];
        $genderList   = ['Laki-laki', 'Perempuan'];

        // Loop 1: Angkatan
        foreach ($angkatanList as $angkatan) {

            $tahunDuaDigit = substr($angkatan, -2); // 2023 -> '23'
            $kodeAngkatan = $tahunDuaDigit . '1';   // '231'
            
            // --- PERBAIKAN 1: Reset Counter DI SINI (Per Angkatan), bukan Per Prodi ---
            // Jadi dalam 1 angkatan, nomor urut akan jalan terus dari 61 sampai 70 (karena 5 prodi x 2 orang)
            // Ini mencegah ada dua orang punya akhiran '062' di angkatan yang sama.
            $counterNim = 60; 

            // Loop 2: Prodi
            foreach ($prodiList as $prodiId) {

                // Loop 3: Gender
                foreach ($genderList as $gender) {
                    
                    $counterNim++; 
                    
                    $nomorUrut = str_pad($counterNim, 3, '0', STR_PAD_LEFT);
                    $nim = "16{$prodiId}{$kodeAngkatan}{$nomorUrut}";

                    if ($gender == 'Laki-laki') {
                        $firstName = $faker->firstNameMale();
                        $lastName  = $faker->lastName();
                    } else {
                        $firstName = $faker->firstNameFemale();
                        $lastName  = $faker->lastName();
                    }
                    $fullName = $firstName . ' ' . $lastName;

                    $email = strtolower($firstName) . $tahunDuaDigit . $nomorUrut . '@ftmm.unair.ac.id';

                    User::create([
                        'nim'                => $nim,
                        'nama'               => $fullName,
                        'email'              => $email,
                        'jenis_kelamin'      => $gender,
                        'tempat_lahir'       => $faker->city(),
                        'tanggal_lahir'      => $faker->dateTimeBetween('-22 years', '-18 years')->format('Y-m-d'),
                        'alamat'             => $faker->address(),
                        'nomor_telepon'      => $faker->numerify('08##########'),
                        'jenis_pekerjaan_id' => '1',
                        'prodi_id'           => $prodiId,
                        'angkatan'           => $angkatan,
                        'password'           => Hash::make('123456'),
                    ]);
                }
            }
        }
    }
}