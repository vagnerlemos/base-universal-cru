@extends('system.layouts.app')

@section('title', 'Detalhe do Log')

@section('content')

{{-- CABEÇALHO --}}
<div style="margin-bottom:20px;">
    <h1 style="margin:0; font-size:22px;">
        Detalhe do Log
    </h1>


</div>

{{-- CARD --}}
<div style="
    background:#ffffff;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    padding:20px;
    max-width:900px;
">

    <table width="100%" cellpadding="0" cellspacing="0"
           style="border-collapse:collapse; font-size:14px;">

        <tbody>

            <tr style="border-bottom:1px solid #e5e7eb;">
                <th style="text-align:left; padding:10px; width:180px; color:#475569;">
                    ID
                </th>
                <td style="padding:10px;">
                    {{ $log->id }}
                </td>
            </tr>

            <tr style="border-bottom:1px solid #e5e7eb;">
                <th style="text-align:left; padding:10px; color:#475569;">
                    Usuário
                </th>
                <td style="padding:10px;">
                    {{ $log->user?->name ?? '—' }}
                </td>
            </tr>

            <tr style="border-bottom:1px solid #e5e7eb;">
                <th style="text-align:left; padding:10px; color:#475569;">
                    Ação
                </th>
                <td style="padding:10px;">
                    {{ $log->action }}
                </td>
            </tr>

            <tr style="border-bottom:1px solid #e5e7eb;">
                <th style="text-align:left; padding:10px; color:#475569;">
                    Recurso
                </th>
                <td style="padding:10px;">
                    {{ $log->resource }}
                </td>
            </tr>

            <tr style="border-bottom:1px solid #e5e7eb;">
                <th style="text-align:left; padding:10px; color:#475569;">
                    IP
                </th>
                <td style="padding:10px; font-family:monospace;">
                    {{ $log->ip }}
                </td>
            </tr>

            <tr style="border-bottom:1px solid #e5e7eb;">
                <th style="text-align:left; padding:10px; color:#475569;">
                    URL
                </th>
                <td style="padding:10px; word-break:break-all; color:#334155;">
                    {{ $log->url }}
                </td>
            </tr>

            <tr style="border-bottom:1px solid #e5e7eb;">
                <th style="text-align:left; padding:10px; color:#475569;">
                    Método
                </th>
                <td style="padding:10px; font-weight:600;">
                    {{ $log->method }}
                </td>
            </tr>

            <tr>
                <th style="text-align:left; padding:10px; color:#475569;">
                    Data
                </th>
                <td style="padding:10px;">
                    {{ $log->created_at->format('d/m/Y H:i:s') }}
                </td>
            </tr>

        </tbody>
    </table>

</div>

@endsection
