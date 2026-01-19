@extends('system.layouts.app')

@section('title', 'Editar Permissão')

@section('content')

{{-- CABEÇALHO --}}
<div style="margin-bottom:20px;">
    <h1 style="margin:0; font-size:22px;">
        Editar Permissão
    </h1>

    <div style="margin-top:6px;">
        <a href="{{ route('system.permissions.index') }}"
           style="font-size:13px; color:#475569; text-decoration:none;">
            ← Voltar para permissões
        </a>
    </div>
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
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
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
    max-width:600px;
">

<form method="POST"
      action="{{ route('system.permissions.update', $permission) }}">

    @csrf
    @method('PUT')

    {{-- NOME --}}
    <div style="margin-bottom:14px;">
        <label style="font-size:14px; color:#374151;">Nome</label><br>
        <input type="text"
               name="name"
               value="{{ old('name', $permission->name) }}"
               required
               style="
                   width:100%;
                   padding:8px 10px;
                   border-radius:6px;
                   border:1px solid #d1d5db;
               ">
    </div>

    {{-- DESCRIÇÃO --}}
    <div style="margin-bottom:18px;">
        <label style="font-size:14px; color:#374151;">Descrição</label><br>
        <input type="text"
               name="description"
               value="{{ old('description', $permission->description) }}"
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
        <a href="{{ route('system.permissions.index') }}"
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
            Salvar alterações
        </button>
    </div>

</form>
</div>

@endsection
