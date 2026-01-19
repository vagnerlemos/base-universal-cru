<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;

class SystemController extends Controller
{
    public function index()
    {
        return view('system.dashboard', [
            'app' => 'system',
        ]);
    }
}
