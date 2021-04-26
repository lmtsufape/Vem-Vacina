<?php

namespace Database\Seeders;

use App\Models\User;
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
            EtapaSeeder::class,
            OpcoesEtapaSeeder::class,
            OutrasInfoEtapaSeeder::class,
            ConfiguracaoSeeder::class,
            CandidatoSeeder::class,
        ]);

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'gabriel.uag.ufrpe@gmail.com',
            'tipo' => User::TIPO_ENUM['admin'],
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'gerente',
            'email' => 'gerente@admin.com',
            'tipo' => User::TIPO_ENUM['gerente'],
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'colaborador',
            'email' => 'colaborador@admin.com',
            'tipo' => User::TIPO_ENUM['colaborador'],
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);

        DB::table('users')->insert([
            'name' => 'secretaria',
            'email' => 'secretaria@admin.com',
            'tipo' => User::TIPO_ENUM['secretaria'],
            'password' => Hash::make('12345678'),
            'email_verified_at' => now(),
        ]);
    }
}
