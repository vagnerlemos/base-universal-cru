@extends('system.layouts.app')

@section('title', $user->exists ? 'Editar Usuário' : 'Novo Usuário')

@section('content')

{{-- CABEÇALHO --}}
<div style="margin-bottom:20px;">
    <h1 style="margin:0; font-size:22px;">
        {{ $user->exists ? 'Editar Usuário' : 'Novo Usuário' }}
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
    max-width:900px;
">

<form method="POST"
      action="{{ $user->exists
            ? route('system.users.update', $user)
            : route('system.users.store') }}">

    @csrf
    @if($user->exists)
        @method('PUT')
    @endif

    {{-- DADOS BÁSICOS --}}
    <div style="
        border:1px solid #e5e7eb;
        border-radius:10px;
        padding:14px;
        margin-bottom:16px;
        background:#ffffff;
    ">
        <div style="font-weight:600; color:#111827; margin-bottom:12px;">
            Dados do usuário
        </div>

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

        {{-- SENHA --}}
        <div style="margin-bottom:14px;">
            <label style="font-size:14px; color:#374151;">
                Senha
                @if($user->exists)
                    <span style="font-size:12px; color:#6b7280;">
                        (deixe em branco para manter)
                    </span>
                @endif
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

        {{-- ATIVO (se existir coluna) --}}
        @if(\Illuminate\Support\Facades\Schema::hasColumn('users', 'active'))
            <div style="margin-top:10px;">
                <label style="font-size:14px; color:#374151; display:flex; gap:10px; align-items:center;">
                    <input type="checkbox"
                           name="active"
                           value="1"
                           {{ old('active', $user->active) ? 'checked' : '' }}>
                    Usuário ativo
                </label>
            </div>
        @endif
    </div>

    {{-- GOVERNANÇA --}}
    <div style="
        border:1px solid #e5e7eb;
        border-radius:10px;
        padding:14px;
        margin-bottom:16px;
        background:#ffffff;
    ">
        <div style="font-weight:600; color:#111827; margin-bottom:12px;">
            Governança (Apps, Roles e Granularidades)
        </div>

        {{-- APPS --}}
        <div style="
            border:1px solid #e5e7eb;
            border-radius:10px;
            padding:12px;
            margin-bottom:12px;
            background:#f9fafb;
        ">
            <div style="font-weight:600; color:#111827; margin-bottom:8px;">
                Aplicativos permitidos
            </div>

            <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:8px;">
                @foreach($apps as $app)
                    <label style="
                        display:flex;
                        gap:10px;
                        align-items:flex-start;
                        font-size:14px;
                        color:#374151;
                        background:#ffffff;
                        border:1px solid #e5e7eb;
                        padding:10px;
                        border-radius:8px;
                    ">
                        <input type="checkbox"
                               name="apps[]"
                               value="{{ $app->id }}"
                               style="margin-top:2px;"
                               {{ in_array(
                                    $app->id,
                                    old('apps', $user->applications->pluck('id')->toArray())
                                  ) ? 'checked' : '' }}>
                        <span>
                            <strong style="color:#111827;">{{ $app->code }}</strong>
                            <span style="color:#6b7280;">— {{ $app->name }}</span>
                        </span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- ROLES --}}
        <div style="
            border:1px solid #e5e7eb;
            border-radius:10px;
            padding:12px;
            margin-bottom:12px;
            background:#f9fafb;
        ">
            <div style="font-weight:600; color:#111827; margin-bottom:8px;">
                Cargos (Roles)
            </div>

            @foreach($roles as $appCode => $rolesByApp)
                <div style="
                    background:#ffffff;
                    border:1px solid #e5e7eb;
                    border-radius:10px;
                    padding:12px;
                    margin-bottom:10px;
                ">
                    <div style="font-weight:600; color:#111827; margin-bottom:8px;">
                        App: {{ $appCode }}
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:8px;">
                        @foreach($rolesByApp as $role)
                            <label style="
                                display:flex;
                                gap:10px;
                                align-items:flex-start;
                                font-size:14px;
                                color:#374151;
                                border:1px solid #e5e7eb;
                                padding:10px;
                                border-radius:8px;
                                background:#ffffff;
                            ">
                                <input type="checkbox"
                                       name="roles[]"
                                       value="{{ $role->id }}"
                                       style="margin-top:2px;"
                                       {{ in_array(
                                            $role->id,
                                            old('roles', $user->roles->pluck('id')->toArray())
                                          ) ? 'checked' : '' }}>
                                <span>
                                    <strong style="color:#111827;">{{ $role->name }}</strong>
                                    @if(!empty($role->description))
                                        <div style="color:#6b7280; font-size:12px; margin-top:2px;">
                                            {{ $role->description }}
                                        </div>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- GRANULARIDADES --}}
        <div style="
            border:1px solid #e5e7eb;
            border-radius:10px;
            padding:12px;
            background:#f9fafb;
        ">
            <div style="font-weight:600; color:#111827; margin-bottom:6px;">
                Granularidades (Restrições / Negações)
            </div>

            <div style="font-size:12px; color:#6b7280; margin-bottom:10px;">
                Marque apenas o que deve ser <strong>negado</strong> ao usuário.
            </div>

            @foreach($granularities as $appCode => $granByApp)
                <div style="
                    background:#ffffff;
                    border:1px solid #e5e7eb;
                    border-radius:10px;
                    padding:12px;
                    margin-bottom:10px;
                ">
                    <div style="font-weight:600; color:#111827; margin-bottom:8px;">
                        App: {{ $appCode }}
                    </div>

                    <div style="display:grid; grid-template-columns:repeat(2, minmax(0, 1fr)); gap:8px;">
                        @foreach($granByApp as $gran)
                            <label style="
                                display:flex;
                                gap:10px;
                                align-items:flex-start;
                                font-size:14px;
                                color:#374151;
                                border:1px solid #e5e7eb;
                                padding:10px;
                                border-radius:8px;
                                background:#ffffff;
                            ">
                                <input type="checkbox"
                                       name="granularities[]"
                                       value="{{ $gran->id }}"
                                       style="margin-top:2px;"
                                       {{ in_array(
                                            $gran->id,
                                            old('granularities', $user->granularities->pluck('id')->toArray())
                                          ) ? 'checked' : '' }}>
                                <span>
                                    <strong style="color:#111827;">{{ $gran->resource }}</strong>
                                    <span style="color:#6b7280;">:: {{ $gran->code }}</span>
                                    @if(!empty($gran->name) || !empty($gran->description))
                                        <div style="color:#6b7280; font-size:12px; margin-top:2px;">
                                            {{ $gran->name ?? '' }}
                                            @if(!empty($gran->description))
                                                <span>— {{ $gran->description }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- AÇÕES --}}
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
    ">
        <a href="{{ route('system.users.index') }}"
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
            {{ $user->exists ? 'Atualizar usuário' : 'Criar usuário' }}
        </button>
    </div>

</form>
</div>

@endsection
