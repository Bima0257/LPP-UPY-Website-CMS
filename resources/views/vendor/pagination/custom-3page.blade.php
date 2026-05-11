@if ($paginator->hasPages())

    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();

        // Desktop
        $start = max(1, $current - 1);
        $end = min($last, $current + 1);
    @endphp

    <nav>

        {{-- ================= MOBILE ================= --}}
        <div class="d-flex d-sm-none justify-content-center">
            <ul class="pagination">

                {{-- Prev --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">‹</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                            ‹
                        </a>
                    </li>
                @endif

                {{-- First Page --}}
                @if ($current > 2)
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url(1) }}">
                            1
                        </a>
                    </li>

                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                @endif

                {{-- Current --}}
                <li class="page-item active">
                    <span class="page-link">{{ $current }}</span>
                </li>

                {{-- Next Number --}}
                @if ($current < $last)
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($current + 1) }}">
                            {{ $current + 1 }}
                        </a>
                    </li>
                @endif

                {{-- Last Page --}}
                @if ($current < $last - 2)
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>

                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($last) }}">
                            {{ $last }}
                        </a>
                    </li>
                @endif

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                            ›
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">›</span>
                    </li>
                @endif

            </ul>
        </div>

        {{-- ================= DESKTOP ================= --}}
        <div class="d-none d-sm-flex justify-content-center">
            <ul class="pagination">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">‹</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
                            ‹
                        </a>
                    </li>
                @endif

                {{-- Halaman pertama --}}
                @if ($current > 2)
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url(1) }}">
                            1
                        </a>
                    </li>

                    @if ($current > 3)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
                @endif

                {{-- Halaman tengah --}}
                @for ($page = $start; $page <= $end; $page++)
                    @if ($page == $current)
                        <li class="page-item active">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $paginator->url($page) }}">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endfor

                {{-- Halaman terakhir --}}
                @if ($current < $last - 1)

                    @if ($current < $last - 2)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif

                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->url($last) }}">
                            {{ $last }}
                        </a>
                    </li>

                @endif

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
                            ›
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">›</span>
                    </li>
                @endif

            </ul>
        </div>

        {{-- Info --}}
        <div class="text-muted small text-center mt-2">
            Menampilkan {{ $paginator->firstItem() }}
            - {{ $paginator->lastItem() }}
            dari {{ $paginator->total() }}
        </div>

    </nav>

@endif
