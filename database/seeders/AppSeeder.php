<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;

class AppSeeder extends Seeder
{
    public function run(): void
    {
        Application::updateOrCreate(
            ['code' => 'system'],
            [
                'name' => 'System',
                'description' => 'Backoffice / Governança do sistema.',
            ]
        );

        Application::updateOrCreate(
            ['code' => 'vendas'],
            [
                'name' => 'Vendas',
                'description' => 'Operações comerciais e vendas.',
            ]
        );
    }
}
