<header style="
    height:56px;
        background: #252525;
    color:#f9fafb;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 24px;
    box-shadow:0 1px 2px rgba(0,0,0,0.2);
">

    {{-- ESQUERDA --}}
    <div style="font-weight:600; font-size:15px;">
        System • Painel Administrativo
    </div>

    {{-- DIREITA --}}
    <div style="
        display:flex;
        align-items:center;
        gap:16px;
        font-size:14px;
    ">
        <span style="color:#e5e7eb;">
            {{ auth()->user()->name ?? 'Usuário' }}
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <input type="hidden" name="app" value="system">

            <button type="submit" style="
                background:#111827;
                border:1px solid #374151;
                color:#f9fafb;
                padding:6px 12px;
                border-radius:6px;
                cursor:pointer;
            ">
                Sair
            </button>
        </form>
    </div>
</header>
