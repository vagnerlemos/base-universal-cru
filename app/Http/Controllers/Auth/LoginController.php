<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\ActivityLogger;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        $app = (string) $request->route('app');

        return view('auth.login', [
            'app' => $app,
        ]);
    }
    /**
     * Processa o login COM validação de app antes de criar sessão
     */
    public function login(Request $request)
    {
        $app = (string) $request->route('app');
        // 1) Validação básica
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
        // 2) Buscar usuário pelo email
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Credenciais inválidas.',
                ]);
        }
        // 3) Validar senha SEM criar sessão
        if (!Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Credenciais inválidas.',
                ]);
        }

        // 4) Validar acesso ao app ANTES de autenticar
        $hasAppAccess = $user->applications()
            ->where('code', $app)
            ->exists();

        if (!$hasAppAccess) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors([
                    'email' => 'Usuário sem autorização para acessar este aplicativo.',
                ]);
        }

        // 5) Tudo OK → autenticar e criar sessão
        Auth::login($user);
        ActivityLogger::log('login');

        $request->session()->regenerate();

        return redirect('/' . $app);
    }

    public function logout(Request $request)
    {
        $app = (string) $request->input('app');

        ActivityLogger::log('logout');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/' . $app . '/login');
    }
}
