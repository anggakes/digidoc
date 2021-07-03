<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@digidoc.com',
            'password' => Hash::make('admin-password'),
            'is_admin' => true,
            'nip' => '9000000001',
        ]);

        // ---

        DB::table('departments')->insert([
            'name' => 'Kepala Kantor Cabang'
        ]);

        DB::table('departments')->insert([
            'name' => 'Bidang Umum & SDM'
        ]);

        DB::table('departments')->insert([
            'name' => 'Bidang Kepesertaan Program Khusus'
        ]);

        DB::table('departments')->insert([
            'name' => 'Bidang Kepesertaan KSI'
        ]);

        DB::table('departments')->insert([
            'name' => 'Bidang Pelayanan'
        ]);

        DB::table('departments')->insert([
            'name' => 'Bidang Keuangan'
        ]);



        // ---

        DB::table('job_positions')->insert([
            'label' => 'Kepala Kantor Cabang',
            'department_id' => 1,
        ]);

        DB::table('job_positions')->insert([
            'label' => 'Kepala Bidang Umum & SDM',
            'department_id' => 2,
        ]);

        DB::table('job_positions')->insert([
            'label' => 'Staff Bidang Umum & SDM',
            'department_id' => 2,
            'parent_id' => 2,
        ]);

        DB::table('job_positions')->insert([
            'label' => 'Kepala Bidang Kepesertaan Program Khusus',
            'department_id' => 3,
        ]);

        DB::table('job_positions')->insert([
            'label' => 'Kepala Bidang Kepesertaan KSI',
            'department_id' => 4,
        ]);

        DB::table('job_positions')->insert([
            'label' => 'Kepala Bidang Pelayanan',
            'department_id' => 5,
        ]);

        DB::table('job_positions')->insert([
            'label' => 'Kepala Bidang Keuangan',
            'department_id' => 6,
        ]);




        DB::table('users')->insert([
            'name' => 'Ady Hendrata',
            'email' => 'adyhendrata@bpjstk.co.id',
            'password' => Hash::make('password'),
            'job_position_id' => 1,
            'nip' => '9001',
        ]);

        DB::table('users')->insert([
            'name' => 'Yudi Arif Tama',
            'email' => 'yudi@bpjstk.co.id',
            'password' => Hash::make('password'),
            'job_position_id' => 2,
            'nip' => '123000000003',
        ]);

        DB::table('users')->insert([
            'name' => 'Aleza Putri',
            'email' => 'aleza@bpjstk.co.id',
            'password' => Hash::make('password'),
            'job_position_id' => 3,
            'nip' => '123000000004',
        ]);


        DB::table('document_classifications')->insert([
            'code' => 'DL 00.00',
            'archive_type' => 'Orientasi Persiapan Kerja',
            'description' => 'Naskah-naskah yang berkaitan dengan penyelenggaraan orientasi persiapan kerja',
        ]);


        DB::table('document_codes')->insert([
            'label' => 'Biasa',
            'code' => 'B',
            'type' => 'Surat Keluar',
        ]);

        DB::table('document_codes')->insert([
            'label' => 'Rahasia',
            'code' => 'R',
            'type' => 'Surat Keluar',
        ]);

        DB::table('document_codes')->insert([
            'label' => 'Surat Perintah',
            'code' => 'SPR',
            'type' => 'Surat Keluar',
        ]);

        DB::table('document_codes')->insert([
            'label' => 'Keterangan',
            'code' => 'KET',
            'type' => 'Surat Keluar',
        ]);

        DB::table('document_codes')->insert([
            'label' => 'Surat Tugas',
            'code' => 'ST',
            'type' => 'Surat Keluar',
        ]);


        DB::table('document_codes')->insert([
            'label' => 'Berita Acara',
            'code' => 'BA',
            'type' => 'Berita Acara',
        ]);

        DB::table('document_codes')->insert([
            'label' => 'Memo Internal',
            'code' => 'MI',
            'type' => 'Memo Internal',
        ]);



    }
}
