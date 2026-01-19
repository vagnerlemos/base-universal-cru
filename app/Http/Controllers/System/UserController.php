<?php

namespace App\Http\Controllers\System;

use Illuminate\Support\Facades\Gate;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Application;
use App\Models\Role;
use App\Models\Granularity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::orderBy('name')->paginate(15);

        return view('system.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return $this->form(new User());
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return $this->form($user);
    }

    protected function form(User $user)
    {
        // ------------------------------------------------------------------
        // Garantir que relações existam mesmo no CREATE
        // ------------------------------------------------------------------
        if (!$user->exists) {
            $user->setRelation('applications', collect());
            $user->setRelation('roles', collect());
            $user->setRelation('granularities', collect());
        } else {
            $user->loadMissing(['applications', 'roles', 'granularities']);
        }

        $apps = Application::orderBy('code')->get();

        $roles = Role::with('app')
            ->orderBy('name')
            ->get()
            ->groupBy(fn($role) => $role->app->code);

        $granularities = Granularity::with('app')
            ->orderBy('resource')
            ->orderBy('code')
            ->get()
            ->groupBy(fn($g) => $g->app->code);

        return view('system.users.form', [
            'user' => $user,
            'apps' => $apps,
            'roles' => $roles,
            'granularities' => $granularities,
        ]);
    }

    public function store(Request $request)
    {
        return $this->persist(new User(), $request);
    }

    public function update(Request $request, User $user)
    {
        return $this->persist($user, $request);
    }

    protected function persist(User $user, Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => [$user->exists ? 'nullable' : 'required'],
            'apps' => ['array'],
            'roles' => ['array'],
            'granularities' => ['array'],
        ];

        if (Schema::hasColumn('users', 'active')) {
            $rules['active'] = ['nullable'];
        }

        if (Schema::hasColumn('users', 'user_type')) {
            $rules['user_type'] = ['nullable', 'string'];
        }

        $data = $request->validate($rules);

        $user->name = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if (Schema::hasColumn('users', 'active')) {
            $user->active = (int) ($data['active'] ?? 0);
        }

        if (Schema::hasColumn('users', 'user_type')) {
            $user->user_type = $data['user_type'] ?? $user->user_type;
        }

        $user->save();

        // ----------------------------------------------------
        // GOVERNANÇA
        // ----------------------------------------------------

        // Apps permitidos
        $user->applications()->sync(
            $data['apps'] ?? []
        );

        // Roles
        $user->roles()->sync(
            $data['roles'] ?? []
        );

        // Granularidades diretas (negações)
        $user->granularities()->sync(
            $data['granularities'] ?? []
        );


        return redirect()
            ->route('system.users.index')
            ->with('success', 'Usuário salvo com sucesso.');
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorize('delete', $user);

        // Evita auto-exclusão
        if ((int) $request->user()->id === (int) $user->id) {
            return redirect()
                ->route('system.users.index')
                ->with('error', 'Você não pode excluir o próprio usuário logado.');
        }

        $user->delete();

        return redirect()
            ->route('system.users.index')
            ->with('success', 'Usuário excluído com sucesso.');
    }
}
