@extends('system.layouts.app')

@section('title', $role->exists ? 'Editar Role' : 'Nova Role')

@section('content')

{{-- CABEÇALHO --}}
<div style="margin-bottom:20px;">
    <h1 style="margin:0; font-size:22px;">
        {{ $role->exists ? 'Editar Role' : 'Nova Role' }}
    </h1>

    <div style="margin-top:6px;">
        <a href="{{ route('system.roles.index') }}"
           style="font-size:13px; color:#475569; text-decoration:none;">
            ← Voltar para roles
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
">

<form method="POST"
      action="{{ $role->exists
            ? route('system.roles.update', $role)
            : route('system.roles.store') }}">

    @csrf
    @if($role->exists)
        @method('PUT')
    @endif

    {{-- DADOS BÁSICOS --}}
    <div style="max-width:600px; margin-bottom:24px;">

        <div style="margin-bottom:14px;">
            <label style="font-size:14px; color:#374151;">Nome</label><br>
            <input type="text"
                   name="name"
                   value="{{ old('name', $role->name) }}"
                   required
                   style="
                       width:100%;
                       padding:8px 10px;
                       border-radius:6px;
                       border:1px solid #d1d5db;
                   ">
        </div>

        <div style="margin-bottom:14px;">
            <label style="font-size:14px; color:#374151;">Descrição</label><br>
            <input type="text"
                   name="description"
                   value="{{ old('description', $role->description) }}"
                   style="
                       width:100%;
                       padding:8px 10px;
                       border-radius:6px;
                       border:1px solid #d1d5db;
                   ">
        </div>
    </div>

    {{-- PERMISSÕES --}}
    <div style="margin-bottom:28px;">
        <h3 style="margin-bottom:12px; font-size:16px;">Permissões</h3>

        @foreach($permissions as $resource => $items)
            <div style="margin-bottom:16px;">
                <strong style="font-size:14px; color:#374151;">
                    {{ ucfirst($resource) }}
                </strong>

                <div style="
                    margin-top:8px;
                    padding-left:12px;
                    display:grid;
                    grid-template-columns:repeat(auto-fill, minmax(220px, 1fr));
                    gap:6px;
                ">
                    @foreach($items as $permission)
                        <label style="font-size:13px; color:#334155;">
                            <input type="checkbox"
                                   name="permissions[]"
                                   value="{{ $permission->id }}"
                                   {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                            {{ $permission->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- GRANULARIDADES --}}
    <div style="margin-bottom:28px;">
        <h3 style="margin-bottom:12px; font-size:16px;">
            Granularidades <span style="font-size:12px; color:#6b7280;">(negações)</span>
        </h3>

        @foreach($granularities as $resource => $items)
            <div style="margin-bottom:16px;">
                <strong style="font-size:14px; color:#374151;">
                    {{ ucfirst($resource) }}
                </strong>

                <div style="
                    margin-top:8px;
                    padding-left:12px;
                    display:grid;
                    grid-template-columns:repeat(auto-fill, minmax(220px, 1fr));
                    gap:6px;
                ">
                    @foreach($items as $granularity)
                        <label style="font-size:13px; color:#334155;">
                            <input type="checkbox"
                                   name="granularities[]"
                                   value="{{ $granularity->id }}"
                                   {{ $role->granularities->contains($granularity) ? 'checked' : '' }}>
                            {{ $granularity->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    {{-- AÇÕES --}}
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-top:24px;
    ">
        <a href="{{ route('system.roles.index') }}"
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
            {{ $role->exists ? 'Atualizar role' : 'Criar role' }}
        </button>
    </div>

</form>
</div>

@endsection
