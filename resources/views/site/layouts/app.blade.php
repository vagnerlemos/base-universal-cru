<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">

    <title>
        @yield('title', 'Site')
    </title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSS básico do site (pode evoluir depois) --}}
    <style>
        body {
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: #f9fafb;
            color: #111827;
        }

        header {
            background: #0f172a;
            color: #ffffff;
            padding: 16px 24px;
        }

        header h1 {
            margin: 0;
            font-size: 18px;
        }

        nav ul {
            list-style: none;
            margin: 12px 0 0;
            padding: 0;
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        nav a {
            color: #e5e7eb;
            text-decoration: none;
            font-size: 14px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            max-width: 960px;
            margin: 24px auto;
            padding: 0 16px;
        }

        footer {
            margin-top: 48px;
            padding: 16px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }
    </style>
</head>
<body>

<header>
    <h1>Site Institucional</h1>

    <nav>
        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/sobre') }}">Sobre</a></li>
            <li><a href="{{ url('/contato') }}">Contato</a></li>
            <li><a href="{{ url('/system') }}">System</a></li>
            <li><a href="{{ url('/vendas') }}">Vendas</a></li>
        </ul>
    </nav>
</header>

<main>
    @yield('content')
</main>

<footer>
    © {{ date('Y') }} — Site Institucional
</footer>

</body>
</html>
