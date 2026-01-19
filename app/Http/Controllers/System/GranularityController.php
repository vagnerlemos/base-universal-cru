<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Granularity;
use Illuminate\Http\Request;

class GranularityController extends Controller
{
    public function index()
    {
        $granularities = Granularity::query()
            ->whereHas('app', function ($q) {
                $q->where('code', 'system');
            })
            ->orderBy('resource')
            ->orderBy('code')
            ->paginate(30);

        return view('system.granularities.index', [
            'app' => 'system',
            'granularities' => $granularities,
        ]);
    }

    public function edit(Granularity $granularity)
    {
        return view('system.granularities.edit', [
            'app' => 'system',
            'granularity' => $granularity,
        ]);
    }

    public function update(Request $request, Granularity $granularity)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $granularity->update($data);

        return redirect()
            ->route('system.granularities.index')
            ->with('success', 'Granularidade atualizada com sucesso.');
    }
}
