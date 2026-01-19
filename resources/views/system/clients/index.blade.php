@extends('system.layouts.app')

@section('title', 'Clientes')

@section('content')

{{-- CABEÇALHO --}}
<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
">
    <h1 style="margin:0; font-size:22px;">
        Clientes
    </h1>

    @canPermission('clients.create')
        <a href="{{ route('system.clients.create') }}"
           style="
               background:#0f172a;
               color:#ffffff;
               padding:8px 14px;
               border-radius:8px;
               text-decoration:none;
               font-size:14px;
           ">
            + Novo cliente
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
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">
                    Nome
                </th>
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">
                    CPF
                </th>
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">
                    Cidade
                </th>
                <th style="text-align:right; padding:12px; font-size:13px; color:#475569;">
                    Ações
                </th>
            </tr>
        </thead>

        <tbody>
        @forelse ($clients as $client)
            <tr style="border-top:1px solid #e5e7eb;">
                <td style="padding:12px; font-size:14px;">
                    {{ $client->name }}
                </td>

                <td style="padding:12px; font-size:14px; color:#475569;">
                    {{ $client->cpf }}
                </td>

                <td style="padding:12px; font-size:14px; color:#475569;">
                    {{ $client->city }}
                </td>

                <td style="padding:12px; text-align:right;">
                    @canPermission('clients.update')
                        <a href="{{ route('system.clients.edit', $client) }}"
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
                    Nenhum cliente encontrado.
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>
</div>

{{-- PAGINAÇÃO --}}
<div style="margin-top:16px;">
    {{ $clients->links('system.layouts.partials.pagination') }}
</div>

@endsection
