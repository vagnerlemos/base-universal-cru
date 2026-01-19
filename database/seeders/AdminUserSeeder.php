<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Recupera o app "system"
        $systemApp = Application::where('code', 'system')->first();

        if (! $systemApp) {
            // App precisa existir
            return;
        }

        // 2️⃣ Cria (ou garante) o role admin do system
        $adminRole = Role::updateOrCreate(
            [
                'app_id' => $systemApp->id,
                'code'   => 'admin',
            ],
            [
                'name' => 'Administrador',
            ]
        );

        // 3️⃣ Busca TODAS as permissões do system
        $permissionIds = Permission::where('app_id', $systemApp->id)
            ->pluck('id')
            ->toArray();

        // Segurança extra
        if (empty($permissionIds)) {
            return;
        }

        // 4️⃣ Vincula permissões ao role admin
        $adminRole->permissions()->sync($permissionIds);

        // 5️⃣ Atribui role admin ao primeiro usuário (bootstrap)
        $firstUser = User::orderBy('id')->first();

        if ($firstUser) {
            $firstUser->roles()->syncWithoutDetaching([$adminRole->id]);
        }
    }
}
