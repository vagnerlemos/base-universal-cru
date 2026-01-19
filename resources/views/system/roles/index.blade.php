@extends('system.layouts.app')

@section('title', 'Roles')

@section('content')

{{-- CABEÇALHO --}}
<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
">
    <h1 style="margin:0; font-size:22px;">
        Roles
    </h1>

    @canPermission('roles.create')
        <a href="{{ route('system.roles.create') }}"
           style="
               background:#0f172a;
               color:#ffffff;
               padding:8px 14px;
               border-radius:8px;
               text-decoration:none;
               font-size:14px;
           ">
            + Nova role
        </a>
    @endcanPermission
</div>

{{-- CARD --}}
<div style="
    background:#ffffff;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    padding:16px;
">

    <table width="100%" cellpadding="0" cellspacing="0"
           style="border-collapse:collapse;">

        <thead>
            <tr style="background:#f8fafc;">
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">Nome</th>
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">Código</th>
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">Descrição</th>
                <th style="text-align:right; padding:12px; font-size:13px; color:#475569;">Ações</th>
            </tr>
        </thead>

        <tbody>
        @forelse($roles as $role)
            <tr style="border-top:1px solid #e5e7eb;">
                <td style="padding:12px; font-size:14px;">{{ $role->name }}</td>
                <td style="padding:12px; font-size:14px; color:#475569;">{{ $role->code }}</td>
                <td style="padding:12px; font-size:14px; color:#475569;">
                    {{ $role->description }}
                </td>
                <td style="padding:12px; text-align:right;">

                    @canPermission('roles.update')
                        <a href="{{ route('system.roles.edit', $role) }}"
                           style="
                               font-size:13px;
                               margin-right:10px;
                               color:#0f172a;
                               text-decoration:none;
                           ">
                            Editar
                        </a>
                    @endcanPermission

                    @canPermission('roles.delete')
                        <form method="POST"
                              action="{{ route('system.roles.destroy', $role) }}"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Remover esta role?')"
                                    style="
                                        background:none;
                                        border:none;
                                        color:#b91c1c;
                                        font-size:13px;
                                        cursor:pointer;
                                    ">
                                Excluir
                            </button>
                        </form>
                    @endcanPermission

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" style="padding:20px; text-align:center; color:#6b7280;">
                    Nenhuma role encontrada.
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>
</div>

{{-- PAGINAÇÃO --}}
<div style="margin-top:16px;">
    {{ $roles->links('system.layouts.partials.pagination') }}
</div>

@endsection
