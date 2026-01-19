<?php

/**
 * Criado por Wagner Lemos
 *
 * Middleware responsável por garantir o CONTEXTO DE APLICAÇÃO (APP)
 * em um sistema Laravel monolítico multi-app baseado em prefixo de rota.
 *
 * Funções principais:
 *
 * 1) Identificar o app atual (system, vendas, etc.) a partir:
 *    - do default('app') definido na rota (forma canônica)
 *    - ou, como fallback, do primeiro segmento da URL
 *
 * 2) Controlar o fluxo de acesso ao app:
 *    - Permitir acesso à rota de login do app
 *    - Redirecionar usuários autenticados que tentem acessar novamente o login
 *
 * 3) Proteger todas as rotas internas do app:
 *    - Exigir autenticação (session/web guard)
 *    - Redirecionar usuários não autenticados para /{app}/login
 *
 * 4) Validar o acesso do usuário ao app via banco de dados:
 *    - Tabela apps
 *    - Tabela pivô app_user
 *
 * 5) Bloquear acesso quando:
 *    - a rota não define corretamente o contexto do app
 *    - o usuário não possui vínculo com o app solicitado
 *
 * Este middleware é a PRIMEIRA CAMADA DE GOVERNAÇA do sistema,
 * executada antes de roles e permissions, garantindo que:
 *
 * - O usuário só entra em apps que possui acesso explícito
 * - Não existe acesso global ou implícito entre apps
 * - O contexto do app é sempre conhecido e validado
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ActivityLogger;

class EnsureContextIsAccessible
{
    public function handle(Request $request, Closure $next): Response
    {
        $appCode = $request->route()?->defaults['app'] ?? null;

        // Fallback opcional por prefixo (apenas se necessário)
        if (!$appCode) {
            $seg1 = (string) $request->segment(1);
            if (in_array($seg1, ['system', 'vendas'], true)) {
                $appCode = $seg1;
            }
        }

        if (!$appCode) {
            abort(500, 'Erro de configuração: rota sem defaults(app).');
        }

        $isLoginRoute = $request->is($appCode . '/login');

        // Rotas de login do app
        if ($isLoginRoute) {
            if (auth()->check()) {
                return redirect('/' . $appCode);
            }
            return $next($request);
        }

        // Rotas internas do app (/{app} e /{app}/...)
        if (!auth()->check()) {
            return redirect('/' . $appCode . '/login');
        }

        // Validar acesso ao app via BD (apps + app_user)
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $hasAccess = $user->applications()
            ->where('code', $appCode)
            ->exists();

        if (!$hasAccess) {
            abort(403);
        }

        // A PARTIR DAQUI o acesso é válido
        ActivityLogger::log(
            'access',
            'route',
            null,
            [
                'route' => $request->route()?->getName(),
            ]
        );

        return $next($request);
    }
}
