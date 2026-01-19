@extends('system.layouts.app')

@section('title', 'Logs de Atividade')

@section('content')

{{-- CABEÇALHO --}}
<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
">
    <h1 style="margin:0; font-size:22px;">
        Logs de Atividade
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
                <th style="padding:12px; font-size:13px; color:#475569; text-align:left;">
                    ID
                </th>
                <th style="padding:12px; font-size:13px; color:#475569; text-align:left;">
                    Usuário
                </th>
                <th style="padding:12px; font-size:13px; color:#475569; text-align:left;">
                    Ação
                </th>
                <th style="padding:12px; font-size:13px; color:#475569; text-align:left;">
                    Recurso
                </th>
                <th style="padding:12px; font-size:13px; color:#475569; text-align:left;">
                    Data
                </th>
                <th style="padding:12px; font-size:13px; color:#475569; text-align:right;">
                    Ação
                </th>
            </tr>
        </thead>

        <tbody>
        @forelse($logs as $log)
            <tr style="border-top:1px solid #e5e7eb;">
                <td style="padding:12px; font-size:13px; color:#475569;">
                    {{ $log->id }}
                </td>

                <td style="padding:12px; font-size:14px;">
                    {{ $log->user?->name ?? '—' }}
                </td>

                <td style="padding:12px; font-size:14px; color:#334155;">
                    {{ $log->action }}
                </td>

                <td style="padding:12px; font-size:14px; color:#334155;">
                    {{ $log->resource }}
                </td>

                <td style="padding:12px; font-size:13px; color:#475569;">
                    {{ $log->created_at->format('d/m/Y H:i') }}
                </td>

                <td style="padding:12px; text-align:right;">
                    @canPermission('activity_logs.view')
                        <a href="{{ route('system.activity_logs.show', $log) }}"
                           style="
                               font-size:13px;
                               color:#0f172a;
                               text-decoration:none;
                           ">
                            Ver
                        </a>
                    @endcanPermission
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6"
                    style="padding:20px; text-align:center; color:#6b7280;">
                    Nenhum log encontrado.
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>
</div>

{{-- PAGINAÇÃO --}}
<div style="margin-top:16px;">
    {{ $logs->links('system.layouts.partials.pagination') }}
</div>

@endsection
