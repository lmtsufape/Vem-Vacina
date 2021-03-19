<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $this->call([
            LoteSeeder::class,
            PostoVacinacaoSeeder::class,
            // CandidatoSeeder::class,
        ]);
        DB::table('users')->insert([  //
            'name' => 'teste',
            'email' => 'teste@teste',
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

    }
}
