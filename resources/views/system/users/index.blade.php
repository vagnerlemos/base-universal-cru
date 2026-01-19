@extends('system.layouts.app')

@section('title', 'Usuários')

@section('content')

{{-- CABEÇALHO --}}
<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
">
    <h1 style="margin:0; font-size:22px;">
        Usuários
    </h1>

    @canPermission('users.create')
        <a href="{{ route('system.users.create') }}"
           style="
               background:#0f172a;
               color:#ffffff;
               padding:8px 14px;
               border-radius:8px;
               text-decoration:none;
               font-size:14px;
           ">
            + Novo usuário
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
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">ID</th>
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">Nome</th>
                <th style="text-align:left; padding:12px; font-size:13px; color:#475569;">E-mail</th>
                <th style="text-align:right; padding:12px; font-size:13px; color:#475569;">Ações</th>
            </tr>
        </thead>

        <tbody>
        @forelse ($users as $user)
            <tr style="border-top:1px solid #e5e7eb;">
                <td style="padding:12px; font-size:14px;">{{ $user->id }}</td>
                <td style="padding:12px; font-size:14px;">{{ $user->name }}</td>
                <td style="padding:12px; font-size:14px; color:#475569;">
                    {{ $user->email }}
                </td>
                <td style="padding:12px; text-align:right;">

                    @canPermission('users.update')
                        <a href="{{ route('system.users.edit', $user) }}"
                           style="
                               font-size:13px;
                               margin-right:10px;
                               color:#0f172a;
                               text-decoration:none;
                           ">
                            Editar
                        </a>
                    @endcanPermission

                    @canPermission('users.delete')
                        <form method="POST"
                              action="{{ route('system.users.destroy', $user) }}"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    onclick="return confirm('Confirma excluir este usuário?')"
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
                    Nenhum usuário encontrado.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

{{-- PAGINAÇÃO --}}
<div style="margin-top:16px;">
    {{ $users->links('system.layouts.partials.pagination') }}

</div>

@endsection
