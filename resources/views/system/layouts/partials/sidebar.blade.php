<aside style="
    width:260px;
    background: #252525;
    color:#e5e7eb;
    padding:24px 16px;
    border-right:1px solid #111827;
">

    {{-- TÍTULO --}}
    <div style="
        font-weight:600;
        font-size:14px;
        margin-bottom:24px;
        color:#f9fafb;
    ">
        Navegação
    </div>

    {{-- GOVERNANÇA --}}
    <div style="margin-bottom:24px;">
        <div style="
            font-size:11px;
            letter-spacing:0.08em;
            color:#9ca3af;
            margin-bottom:12px;
        ">
            GOVERNANÇA
        </div>

        <ul style="list-style:none; padding:0; margin:0;">

            @canPermission('users.view')
            <li style="padding:8px 12px; border-radius:6px; margin-bottom:6px; cursor:pointer;">
                <a href="{{ route('system.users.index') }}"
                   style="color:#ffffff; text-decoration:none;">
                    Usuários
                </a>
            </li>
            @endcanPermission

            @canPermission('roles.view')
            <li style="padding:8px 12px; border-radius:6px; margin-bottom:6px; cursor:pointer;">
                <a href="{{ route('system.roles.index') }}"
                   style="color:#ffffff; text-decoration:none;">
                    Roles
                </a>
            </li>
            @endcanPermission

            @canPermission('permissions.view')
            <li style="padding:8px 12px; border-radius:6px; margin-bottom:6px; cursor:pointer;">
                <a href="{{ route('system.permissions.index') }}"
                   style="color:#ffffff; text-decoration:none;">
                    Permissões
                </a>
            </li>
            @endcanPermission

            @canPermission('granularity.view')
            <li style="padding:8px 12px; border-radius:6px; margin-bottom:6px; cursor:pointer;">
                <a href="{{ route('system.granularities.index') }}"
                   style="color:#ffffff; text-decoration:none;">
                    Granularidades
                </a>
            </li>
            @endcanPermission

            @canPermission('apps.view')
            <li style="padding:8px 12px; border-radius:6px; margin-bottom:6px; cursor:pointer;">
                <a href="{{ route('system.apps.index') }}"
                   style="color:#ffffff; text-decoration:none;">
                    Aplicativos
                </a>
            </li>
            @endcanPermission

            @canPermission('activity_logs.view')
            <li style="padding:8px 12px; border-radius:6px; margin-bottom:6px; cursor:pointer;">
                <a href="{{ route('system.activity_logs.index') }}"
                   style="color:#ffffff; text-decoration:none;">
                    Logs de Atividades
                </a>
            </li>
            @endcanPermission

        </ul>
    </div>

    {{-- OUTROS --}}
    @canPermission('clients.view')
    <div>
        <div style="font-size:11px; letter-spacing:0.08em; color:#9ca3af; margin-bottom:12px;">
            OUTROS
        </div>

        <ul style="list-style:none; padding:0; margin:0;">
            <li style="padding:8px 12px; border-radius:6px; cursor:pointer;">
                <a href="{{ route('system.clients.index') }}"
                   style="color:#ffffff; text-decoration:none;">
                    Clientes
                </a>
            </li>
        </ul>
    </div>
    @endcanPermission

</aside>
