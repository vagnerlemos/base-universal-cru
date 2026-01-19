<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\System\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::query()->orderBy('name')->paginate(15);

        return view('system.clients.index', [
            'app' => 'system',
            'clients' => $clients,
        ]);
    }

    public function create()
    {
        return view('system.clients.create', [
            'app' => 'system',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:20', 'unique:clients,cpf'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:255'],
        ]);

        Client::create($data);

        return redirect()->route('system.clients.index');
    }

    public function edit(Client $client)
    {
        return view('system.clients.edit', [
            'app' => 'system',
            'client' => $client,
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:20', 'unique:clients,cpf,' . $client->id],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'city' => ['nullable', 'string', 'max:255'],
        ]);

        $client->update($data);

        return redirect()->route('system.clients.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('system.clients.index');
    }
}
