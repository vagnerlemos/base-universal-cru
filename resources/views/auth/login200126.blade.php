<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login — {{ strtoupper($app) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @php
        $brand = [
            'system' => ['title' => 'System', 'color' => '#0f172a'],
            'vendas' => ['title' => 'Vendas', 'color' => '#14532d'],
        ][$app] ?? ['title' => strtoupper($app), 'color' => '#111827'];
    @endphp

    <style>
        body { font-family: Arial, sans-serif; background:#f3f4f6; margin:0; padding:0; }
        .wrap { max-width: 420px; margin: 60px auto; background: #fff; border-radius: 10px; overflow:hidden; box-shadow: 0 10px 30px rgba(0,0,0,.08); }
        .top { padding: 18px 20px; color:#fff; }
        .content { padding: 20px; }
        label { display:block; font-size: 12px; margin-top: 12px; color:#374151; }
        input { width:100%; padding: 10px; border:1px solid #d1d5db; border-radius: 8px; margin-top: 6px; }
        button { width:100%; margin-top: 16px; padding: 10px; border:0; border-radius: 8px; color:#fff; cursor:pointer; }
        .error { background:#fee2e2; border:1px solid #fecaca; color:#991b1b; padding: 10px; border-radius: 8px; margin-bottom: 10px; }
        .hint { font-size: 12px; color:#6b7280; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="wrap">
        <div class="top" style="background: {{ $brand['color'] }};">
            <strong>Login — {{ $brand['title'] }}</strong>
        </div>

        <div class="content">
            @if ($errors->any())
                <div class="error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="/{{ $app }}/login">
                @csrf

                <label for="email">E-mail</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>

                <label for="password">Senha</label>
                <input id="password" name="password" type="password" required>

                <button type="submit" style="background: {{ $brand['color'] }};">Entrar</button>

                <div class="hint">
                    Contexto atual: <strong>{{ $app }}</strong>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
