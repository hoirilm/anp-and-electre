<?php

use App\Jurusan;
use Illuminate\Database\Seeder;

class CreateJurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newJurusan = [
            [
                'jurusan' => 'Teknik Informatika',
            ],
            [
                'jurusan' => 'Teknik Industri',
            ],
            [
                'jurusan' => 'Teknik Sistem Informasi',
            ],
            [
                'jurusan' => 'Teknik Elektro',
            ],
            [
                'jurusan' => 'Teknik Mesin',
            ],
            [
                'jurusan' => 'Teknik Mekatronika',
            ],
        ];

        foreach ($newJurusan as $key => $value) {
            Jurusan::create($value);
        }
    }
}
