<?php

namespace App\Http\Controllers\Vendas;

use App\Http\Controllers\Controller;

class VendasController extends Controller
{
    public function index()
    {
        return view('vendas.dashboard', [
            'app' => 'vendas',
        ]);
    }
}
