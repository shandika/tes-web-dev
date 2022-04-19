<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class CreateProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Program::create([
            'sumber_dana'   => 'Zakat',
            'program'       => 'Zakat Fitrah',
            'keterangan'    => 'Ada'
        ]);

        Program::create([
            'sumber_dana'   => 'Zakat',
            'program'       => 'Zakat Penghasilan',
            'keterangan'    => 'Ada'
        ]);

        Program::create([
            'sumber_dana'   => 'Infaq Shodaqoh Terikat',
            'program'       => 'Berbagi Pendidikan SMP',
            'keterangan'    => 'Ada'
        ]);

        Program::create([
            'sumber_dana'   => 'Infaq Shodaqoh Tidak Terikat',
            'program'       => 'Charity Box Personal',
            'keterangan'    => 'Tidak Ada'
        ]);
    }
}
