@if ($paginator->hasPages())
<nav style="margin-top:16px; display:flex; justify-content:center;">
    <ul style="
        list-style:none;
        display:flex;
        gap:6px;
        padding:0;
        margin:0;
        font-size:13px;
    ">

        {{-- Botão Anterior --}}
        @if ($paginator->onFirstPage())
            <li style="padding:6px 10px; color:#9ca3af;">‹</li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}"
                   style="
                       padding:6px 10px;
                       border-radius:6px;
                       text-decoration:none;
                       color:#0f172a;
                       border:1px solid #e5e7eb;
                   ">
                    ‹
                </a>
            </li>
        @endif

        {{-- Páginas --}}
        @foreach ($elements as $element)

            {{-- "..." --}}
            @if (is_string($element))
                <li style="padding:6px 10px; color:#9ca3af;">
                    {{ $element }}
                </li>
            @endif

            {{-- Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li style="
                            padding:6px 10px;
                            border-radius:6px;
                            background:#0f172a;
                            color:#ffffff;
                        ">
                            {{ $page }}
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}"
                               style="
                                   padding:6px 10px;
                                   border-radius:6px;
                                   text-decoration:none;
                                   color:#0f172a;
                                   border:1px solid #e5e7eb;
                               ">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif

        @endforeach

        {{-- Botão Próximo --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}"
                   style="
                       padding:6px 10px;
                       border-radius:6px;
                       text-decoration:none;
                       color:#0f172a;
                       border:1px solid #e5e7eb;
                   ">
                    ›
                </a>
            </li>
        @else
            <li style="padding:6px 10px; color:#9ca3af;">›</li>
        @endif

    </ul>
</nav>
@endif
