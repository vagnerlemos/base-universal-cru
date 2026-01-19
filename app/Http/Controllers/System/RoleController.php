<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Granularity;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('app')
            ->whereHas('app', fn($q) => $q->where('code', 'system'))
            ->orderBy('name')
            ->paginate(20);

        return view('system.roles.index', [
            'app' => 'system',
            'roles' => $roles,
        ]);
    }

    public function create()
    {
        return $this->form(new Role([
            'app_id' => Application::where('code', 'system')->first()->id
        ]));
    }

    public function edit(Role $role)
    {
        return $this->form($role);
    }

    protected function form(Role $role)
    {
        // --------------------------------------------------
        // Garantir relações SEMPRE existentes
        // --------------------------------------------------
        if (!$role->exists) {
            $role->setRelation('permissions', collect());
            $role->setRelation('granularities', collect());
        } else {
            $role->loadMissing(['permissions', 'granularities']);
        }

        $permissions = Permission::whereHas('app', fn($q) => $q->where('code', 'system'))
            ->orderBy('resource')
            ->orderBy('code')
            ->get()
            ->groupBy('resource');

        $granularities = Granularity::whereHas('app', fn($q) => $q->where('code', 'system'))
            ->orderBy('resource')
            ->orderBy('code')
            ->get()
            ->groupBy('resource');

        return view('system.roles.form', [
            'app' => 'system',
            'role' => $role,
            'permissions' => $permissions,
            'granularities' => $granularities,
        ]);
    }


    public function store(Request $request)
    {
        return $this->persist(new Role(), $request);
    }

    public function update(Request $request, Role $role)
    {
        return $this->persist($role, $request);
    }

    protected function persist(Role $role, Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'permissions' => ['array'],
            'granularities' => ['array'],
        ]);


        //------------------------------------------------------------------
        //verifica se ja existe o cargo
        $appId = Application::where('code', 'system')->first()->id;
        $code  = Str::slug($data['name']);

        $exists = Role::where('app_id', $appId)
            ->where('code', $code)
            ->when($role->exists, fn($q) => $q->where('id', '!=', $role->id))
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'Já existe um papel com um nome parecido. Não foi possível incluir.',
                ])
                ->withInput();
        }

        //------------------------------------------------------------------







        $role->fill($data);
        $role->code = Str::slug($data['name']); // 👈 AQUI ESTÁ A CHAVE
        $role->app_id = Application::where('code', 'system')->first()->id;
        $role->save();

        $role->permissions()->sync($data['permissions'] ?? []);
        $role->granularities()->sync($data['granularities'] ?? []);

        return redirect()
            ->route('system.roles.index')
            ->with('success', 'Role salvo com sucesso.');
    }

    public function destroy(Role $role)
    {
        $role->permissions()->detach();
        $role->granularities()->detach();
        $role->delete();

        return redirect()
            ->route('system.roles.index')
            ->with('success', 'Role removido.');
    }
}
