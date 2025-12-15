<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DimProfilSeeder extends Seeder
{
    public function run()
    {
        DB::connection('olap')->table('dim_profil')->updateOrInsert(
            ['sk_profil' => -1],
            [
                'angkatan'  => '0', 
                'nama_prodi'      => 'Tidak Diketahui',
                'jenis_kelamin'   => 'NA',
                'nama_pekerjaan' => 'Tidak Diketahui',
            ]
        );
        
        $this->command->info('Data Profil Anonim (ID -1) berhasil ditanam di Database OLAP!');
    }
}
