<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <title>System</title>

    <style>
        /* Correção global de forms */
        input,
        select,
        textarea {
            box-sizing: border-box;
        }
    </style>
</head>

<body style="
    margin:0;
    font-family:Inter, Arial, Helvetica, sans-serif;
    background:#f3f4f6;
">

{{-- TOPBAR FIXA --}}
@include('system.layouts.partials.topbar')

<div style="display:flex; height:calc(100vh - 56px);">

    {{-- SIDEBAR --}}
    @include('system.layouts.partials.sidebar')

    {{-- CONTEÚDO --}}
    <main style="
        flex:1;
        padding:32px;
        background:#ffffff;
        overflow:auto;
    ">
        @yield('content')
    </main>

</div>

</body>
</html>
