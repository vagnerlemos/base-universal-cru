@extends('system.layouts.app')

@section('title', 'Permissões')

@section('content')

{{-- CABEÇALHO --}}
<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
">
    <h1 style="margin:0; font-size:22px;">
        Permissões
    </h1>
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
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">
                    Recurso
                </th>
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">
                    Código
                </th>
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">
                    Nome
                </th>
                <th style="text-align:right; padding:12px; font-size:13px; color:#475569;">
                    Ação
                </th>
            </tr>
        </thead>

        <tbody>
        @forelse ($permissions as $permission)
            <tr style="border-top:1px solid #e5e7eb;">
                <td style="padding:12px; font-size:14px;">
                    {{ $permission->resource }}
                </td>
                <td style="padding:12px; font-size:14px; color:#475569;">
                    {{ $permission->code }}
                </td>
                <td style="padding:12px; font-size:14px;">
                    {{ $permission->name }}
                </td>
                <td style="padding:12px; text-align:right;">
                    @canPermission('permissions.update')
                        <a href="{{ route('system.permissions.edit', $permission) }}"
                           style="
                               font-size:13px;
                               color:#0f172a;
                               text-decoration:none;
                           ">
                            Editar
                        </a>
                    @endcanPermission
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4"
                    style="padding:20px; text-align:center; color:#6b7280;">
                    Nenhuma permissão encontrada.
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>
</div>

{{-- PAGINAÇÃO --}}
<div style="margin-top:16px;">
    {{ $permissions->links('system.layouts.partials.pagination') }}
</div>

@endsection
