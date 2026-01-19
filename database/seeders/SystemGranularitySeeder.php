<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\Granularity;

class SystemGranularitySeeder extends Seeder
{
    public function run(): void
    {
        $system = Application::where('code', 'system')->first();

        Granularity::updateOrCreate(
            [
                'app_id' => $system->id,
                'code' => 'users.field.cpf.hide',
            ],
            [
                'resource' => 'users',
                'name' => 'Ocultar CPF',
                'description' => 'Impede visualização e edição do CPF do usuário',
            ]
        );
    }
}
