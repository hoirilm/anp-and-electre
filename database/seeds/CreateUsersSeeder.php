<?php

use App\User;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newUser = [
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'is_admin' => '1',
            ],
            [
                'name' => 'Penguji',
                'username' => 'penguji',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'is_admin' => '0',
            ],
            [
                'name' => 'Penguji2',
                'username' => 'penguji2',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'is_admin' => '0',
            ],
            [
                'name' => 'Penguji3',
                'username' => 'penguji3',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'is_admin' => '0',
            ],
            [
                'name' => 'Penguji4',
                'username' => 'penguji4',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'is_admin' => '0',
            ],
            [
                'name' => 'Penguji5',
                'username' => 'penguji5',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'is_admin' => '0',
            ],
            [
                'name' => 'Penguji6',
                'username' => 'penguji6',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'is_admin' => '0',
            ]
        ];

        foreach ($newUser as $key => $value) {
            User::create($value);
        }
    }
}
