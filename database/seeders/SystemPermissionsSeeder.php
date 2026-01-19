<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\Permission;

class SystemPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Recupera o app "system"
        /*
         *  SELECT * FROM applications
            WHERE code = 'system'
            LIMIT 1;//->first()


            objeto Eloquent
            $systemApp
            │
            ├── id = 1
            ├── code = "system"
            ├── name = "Sistema"
            ├── description = "Aplicação administrativa"
            ├── created_at = 2026-01-10 09:15:00
            ├── updated_at = 2026-01-10 09:15:00
            │
            ├── exists = true
            ├── wasRecentlyCreated = false
            │
            └── relations = []

         */
        $systemApp = Application::where('code', 'system')->first();

        if (! $systemApp) {
            // Segurança: app precisa existir
            return;
        }

        // 2️⃣ Catálogo de permissões do resource "apps"
        $permissions = [
            //usuários
            [
                'resource' => 'users',
                'code' => 'users.view',
                'name' => 'Visualizar usuários',
                'description' => 'Permite listar e visualizar usuários.',
            ],
            [
                'resource' => 'users',
                'code' => 'users.create',
                'name' => 'Criar usuários',
                'description' => 'Permite criar novos usuários.',
            ],
            [
                'resource' => 'users',
                'code' => 'users.update',
                'name' => 'Editar usuários',
                'description' => 'Permite editar dados de usuários.',
            ],
            [
                'resource' => 'users',
                'code' => 'users.delete',
                'name' => 'Excluir usuários',
                'description' => 'Permite excluir usuários.',
            ],


            //aplicativos
            [
                'resource' => 'apps',
                'code' => 'apps.view',
                'name' => 'Visualizar aplicações',
                'description' => 'Permite listar e visualizar aplicações do sistema.',
            ],
            [
                'resource' => 'apps',
                'code' => 'apps.update',
                'name' => 'Editar aplicações',
                'description' => 'Permite editar dados das aplicações do sistema.',
            ],
            //permissões
            [
                'resource' => 'permissions',
                'code' => 'permissions.view',
                'name' => 'Visualizar permissões',
                'description' => 'Permite listar e visualizar permissões do sistema.',
            ],
            /*
            [
                'resource' => 'permissions',
                'code' => 'permissions.create',
                'name' => 'Criar permissões',
                'description' => 'Permite criar novas permissões no sistema.',
            ],*/
            [
                'resource' => 'permissions',
                'code' => 'permissions.update',
                'name' => 'Editar permissões',
                'description' => 'Permite editar dados das permissões do sistema.',
            ],
            /*
            [
                'resource' => 'permissions',
                'code' => 'permissions.delete',
                'name' => 'Excluir permissões',
                'description' => 'Permite excluir permissões do sistema.',
            ],*/
            //granularidade
            [
                'resource' => 'granularity',
                'code' => 'granularity.view',
                'name' => 'Visualizar granularidade',
                'description' => 'Permite visualizar a estrutura de papéis e permissões do sistema.',
            ],
            [
                'resource' => 'granularity',
                'code' => 'granularity.update',
                'name' => 'Editar granularidade',
                'description' => 'Permite editar os nomes da granularidade do sistema.',
            ],

            //roles
            [
                'resource' => 'roles',
                'code' => 'roles.view',
                'name' => 'Visualizar papéis',
                'description' => 'Permite listar e visualizar os papéis (roles) do sistema.',
            ],
            [
                'resource' => 'roles',
                'code' => 'roles.create',
                'name' => 'Criar papéis',
                'description' => 'Permite criar novos papéis no sistema.',
            ],
            [
                'resource' => 'roles',
                'code' => 'roles.update',
                'name' => 'Editar papéis',
                'description' => 'Permite editar dados dos papéis do sistema.',
            ],
            [
                'resource' => 'roles',
                'code' => 'roles.delete',
                'name' => 'Excluir papéis',
                'description' => 'Permite excluir papéis do sistema.',
            ],
            //activity_logs
            [
                'resource' => 'activity_logs',
                'code' => 'activity_logs.view',
                'name' => 'Visualizar logs de atividades',
                'description' => 'Permite visualizar os registros de atividades do sistema.',
            ],
            /*
            [
                'resource' => 'activity_logs',
                'code' => 'activity_logs.export',
                'name' => 'Exportar logs de atividades',
                'description' => 'Permite exportar os registros de atividades do sistema.',
            ],
            [
                'resource' => 'activity_logs',
                'code' => 'activity_logs.purge',
                'name' => 'Limpar logs de atividades',
                'description' => 'Permite remover ou limpar registros antigos de atividades do sistema.',
            ],
            */
            //clients
            [
                'resource' => 'clients',
                'code' => 'clients.view',
                'name' => 'Visualizar clientes',
                'description' => 'Permite listar e visualizar clientes.',
            ],
            /*
            [
                'resource' => 'clients',
                'code' => 'clients.create',
                'name' => 'Criar clientes',
                'description' => 'Permite cadastrar novos clientes.',
            ],*/
            [
                'resource' => 'clients',
                'code' => 'clients.update',
                'name' => 'Editar clientes',
                'description' => 'Permite editar dados de clientes.',
            ],
            /*
            [
                'resource' => 'clients',
                'code' => 'clients.delete',
                'name' => 'Excluir clientes',
                'description' => 'Permite excluir clientes.',
            ],
            */






        ];

        // 3️⃣ Persistência no banco (idempotente)
        /*
            🧠 O que significa idempotente

            Uma operação idempotente é aquela que você pode executar várias vezes e o resultado final será sempre o mesmo.

            Em português direto:
            👉 rodar 1 vez ou 10 vezes dá no mesmo efeito no banco.
        */
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                [
                    'app_id' => $systemApp->id,
                    'code'   => $permission['code'],
                ],
                [
                    'resource'    => $permission['resource'],
                    'name'        => $permission['name'],
                    'description' => $permission['description'],
                ]
            );
        }
    }
}
