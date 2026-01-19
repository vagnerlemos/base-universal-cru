<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        $apps = Application::query()
            ->orderBy('code')
            ->paginate(15);

        return view('system.apps.index', [
            'app' => 'system',
            'apps' => $apps,
        ]);
    }

    public function edit(Application $application)
    {
        return view('system.apps.edit', [
            'app' => 'system',
            'application' => $application,
        ]);
    }

    public function update(Request $request, Application $application)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $application->update($data);

        return redirect()
            ->route('system.apps.index')
            ->with('success', 'App atualizado com sucesso.');
    }
}
