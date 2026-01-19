@extends('system.layouts.app')

@section('title', 'Editar Cliente')

@section('content')

{{-- CABEÇALHO --}}
<div style="margin-bottom:20px;">
    <h1 style="margin:0; font-size:22px;">
        Editar Cliente
    </h1>


</div>

{{-- ERROS --}}
@if ($errors->any())
    <div style="
        background:#fee;
        border:1px solid #fca5a5;
        color:#7f1d1d;
        padding:12px;
        border-radius:8px;
        margin-bottom:16px;
        font-size:14px;
    ">
        <strong>Erros encontrados:</strong>
        <ul style="margin-top:6px; padding-left:18px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- CARD --}}
<div style="
    background:#ffffff;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    padding:20px;
    max-width:700px;
">

<form method="POST" action="{{ route('system.clients.update', $client) }}">
    @csrf
    @method('PUT')

    {{-- NOME --}}
    <div style="margin-bottom:14px;">
        <label style="font-size:14px; color:#374151;">Nome</label><br>
        <input name="name"
               value="{{ old('name', $client->name) }}"
               required
               style="
                   width:100%;
                   padding:8px 10px;
                   border-radius:6px;
                   border:1px solid #d1d5db;
               ">
    </div>

    {{-- CPF --}}
    <div style="margin-bottom:14px;">
        <label style="font-size:14px; color:#374151;">CPF</label><br>
        <input name="cpf"
               value="{{ old('cpf', $client->cpf) }}"
               required
               style="
                   width:100%;
                   padding:8px 10px;
                   border-radius:6px;
                   border:1px solid #d1d5db;
               ">
    </div>

    {{-- EMAIL --}}
    <div style="margin-bottom:14px;">
        <label style="font-size:14px; color:#374151;">E-mail</label><br>
        <input type="email"
               name="email"
               value="{{ old('email', $client->email) }}"
               style="
                   width:100%;
                   padding:8px 10px;
                   border-radius:6px;
                   border:1px solid #d1d5db;
               ">
    </div>

    {{-- TELEFONE --}}
    <div style="margin-bottom:14px;">
        <label style="font-size:14px; color:#374151;">Telefone</label><br>
        <input name="phone"
               value="{{ old('phone', $client->phone) }}"
               style="
                   width:100%;
                   padding:8px 10px;
                   border-radius:6px;
                   border:1px solid #d1d5db;
               ">
    </div>

    {{-- CIDADE --}}
    <div style="margin-bottom:18px;">
        <label style="font-size:14px; color:#374151;">Cidade</label><br>
        <input name="city"
               value="{{ old('city', $client->city) }}"
               style="
                   width:100%;
                   padding:8px 10px;
                   border-radius:6px;
                   border:1px solid #d1d5db;
               ">
    </div>

    {{-- AÇÕES --}}
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
    ">
        <a href="{{ route('system.clients.index') }}"
           style="font-size:14px; color:#6b7280; text-decoration:none;">
            Cancelar
        </a>

        <button type="submit"
                style="
                    background:#0f172a;
                    color:#ffffff;
                    padding:10px 18px;
                    border:none;
                    border-radius:8px;
                    font-size:14px;
                    cursor:pointer;
                ">
            Atualizar cliente
        </button>
    </div>

</form>
</div>

@endsection
