@extends('system.layouts.app')

@section('title', 'Editar Usuário')

@section('content')

{{-- CABEÇALHO --}}
<div style="margin-bottom:20px;">
    <h1 style="margin:0; font-size:22px;">
        Editar Usuário
    </h1>

    <div style="margin-top:6px;">
        <a href="{{ route('system.users.index') }}"
           style="font-size:13px; color:#475569; text-decoration:none;">
            ← Voltar para usuários
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

{{-- GRANULARIDADE (INFO INTERNA) --}}
@allowGranularity('users.secret.internal_note')
    <div style="
        background:#f8fafc;
        border:1px dashed #cbd5f5;
        padding:12px;
        border-radius:8px;
        margin-bottom:16px;
        font-size:13px;
        color:#334155;
    ">
        Informação interna confidencial.
    </div>
@endallowGranularity

{{-- CARD --}}
<div style="
    background:#ffffff;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    padding:20px;
    max-width:600px;
">

<form method="POST" action="{{ route('system.users.update', $user) }}">
    @csrf
    @method('PUT')

    {{-- NOME --}}
    <div style="margin-bottom:14px;">
        <label style="font-size:14px; color:#374151;">Nome</label><br>
        <input type="text"
               name="name"
               value="{{ old('name', $user->name) }}"
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
               value="{{ old('email', $user->email) }}"
               required
               style="
                   width:100%;
                   padding:8px 10px;
                   border-radius:6px;
                   border:1px solid #d1d5db;
               ">
    </div>

    {{-- CPF (POR GRANULARIDADE) --}}
    @allowGranularity('users.field.cpf.hide')
        <div style="margin-bottom:14px;">
            <label style="font-size:14px; color:#374151;">CPF</label><br>
            <input type="text"
                   name="cpf"
                   value="{{ old('cpf', $user->cpf ?? '') }}"
                   style="
                       width:100%;
                       padding:8px 10px;
                       border-radius:6px;
                       border:1px solid #d1d5db;
                   ">
        </div>
    @endallowGranularity

    {{-- SENHA --}}
    <div style="margin-bottom:14px;">
        <label style="font-size:14px; color:#374151;">
            Senha <span style="font-size:12px; color:#6b7280;">(deixe em branco para manter)</span>
        </label><br>
        <input type="password"
               name="password"
               style="
                   width:100%;
                   padding:8px 10px;
                   border-radius:6px;
                   border:1px solid #d1d5db;
               ">
    </div>

    {{-- CONFIRMAR SENHA --}}
    <div style="margin-bottom:14px;">
        <label style="font-size:14px; color:#374151;">Confirmar senha</label><br>
        <input type="password"
               name="password_confirmation"
               style="
                   width:100%;
                   padding:8px 10px;
                   border-radius:6px;
                   border:1px solid #d1d5db;
               ">
    </div>

    @php
        $hasActive = \Illuminate\Support\Facades\Schema::hasColumn('users', 'active');
        $hasUserType = \Illuminate\Support\Facades\Schema::hasColumn('users', 'user_type');
    @endphp

    {{-- ATIVO --}}
    @if ($hasActive)
        <div style="margin-bottom:14px;">
            <label style="font-size:14px; color:#374151;">Ativo</label><br>
            <select name="active"
                    style="
                        width:100%;
                        padding:8px 10px;
                        border-radius:6px;
                        border:1px solid #d1d5db;
                    ">
                <option value="1" {{ (string)old('active', (string)($user->active ?? '1')) === '1' ? 'selected' : '' }}>
                    Sim
                </option>
                <option value="0" {{ (string)old('active', (string)($user->active ?? '1')) === '0' ? 'selected' : '' }}>
                    Não
                </option>
            </select>
        </div>
    @endif

    {{-- TIPO --}}
    @if ($hasUserType)
        <div style="margin-bottom:18px;">
            <label style="font-size:14px; color:#374151;">Tipo</label><br>
            <input type="text"
                   name="user_type"
                   value="{{ old('user_type', $user->user_type ?? '') }}"
                   placeholder="ex: user, root, super"
                   style="
                       width:100%;
                       padding:8px 10px;
                       border-radius:6px;
                       border:1px solid #d1d5db;
                   ">
        </div>
    @endif

    {{-- AÇÕES --}}
    <div style="display:flex; justify-content:flex-end;">
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
            Atualizar usuário
        </button>
    </div>

</form>
</div>

@endsection
