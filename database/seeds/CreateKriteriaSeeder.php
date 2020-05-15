<?php

use App\Kriteria;
use Illuminate\Database\Seeder;

class CreateKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newKriteria = [
            [
                'kriteria' => 'IND',
            ],
            [
                'kriteria' => 'ING',
            ],
            [
                'kriteria' => 'MAT',
            ],
            [
                'kriteria' => 'BIO',
            ],
            [
                'kriteria' => 'FIS',
            ],
            [
                'kriteria' => 'KIM',
            ],
        ];

        foreach ($newKriteria as $key => $value) {
            Kriteria::create($value);
        }
    }
}
