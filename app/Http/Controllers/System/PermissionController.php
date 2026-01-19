<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::query()
            ->whereHas('app', function ($q) {
                $q->where('code', 'system');
            })
            ->orderBy('resource')
            ->orderBy('code')
            ->paginate(30);

        return view('system.permissions.index', [
            'app' => 'system',
            'permissions' => $permissions,
        ]);
    }

    public function edit(Permission $permission)
    {
        return view('system.permissions.edit', [
            'app' => 'system',
            'permission' => $permission,
        ]);
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $permission->update($data);

        return redirect()
            ->route('system.permissions.index')
            ->with('success', 'Permissão atualizada com sucesso.');
    }
}
