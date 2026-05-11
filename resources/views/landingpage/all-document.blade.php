<x-landingpage.layout title="{{ $title }}">

    <!-- ====== Banner Start ====== -->
    <section class="ud-page-banner"
        style="background-image: url('{{ !empty($banner) && !empty($banner->banner_background)
            ? asset('storage/' . $banner->banner_background)
            : asset('assets/images/background/background-default.jpg') }}');">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-banner-content">
                        <h1>{{ $title }}</h1>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- ====== Banner End ====== -->

    <!-- ====== Features Start ====== -->
    <section id="document" class="ud-features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title mx-auto text-center">
                        <span>Dokumen</span>
                        <h2>Dokumen Terbaru</h2>
                        <p>
                            Temukan dokumen yang Anda butuhkan dengan mengetikkan kata kunci pada kolom pencarian. Jika
                            terdapat dokumen yang terkunci, silakan menghubungi Tim LPP - UPY
                        </p>
                    </div>
                </div>
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-md-between gap-3 mb-4">
                    <!-- ====== Search Bar ====== -->
                    <div class="search-wrapper w-100" style="max-width: 500px;">
                        <form
                            action="{{ isset($category) ? route('document.category', $category->slug) : route('document.all') }}"
                            method="GET" class="search-form">
                            <div class="search-input-wrapper">
                                <input type="text" name="search" class="form-control search-input"
                                    data-suggest-url="{{ isset($category) ? route('document.suggestions', $category->slug) : route('document.suggestions') }}"
                                    placeholder="Cari Dokumen berdasarkan judul atau konten..." autocomplete="off">

                                <!-- Tombol reset (X) -->
                                <button type="button" class="reset-btn d-none" id="resetSearch"
                                    title="Hapus pencarian">
                                    <i class="mdi mdi-close-circle-outline"></i>
                                </button>
                            </div>

                            <!-- Tombol search -->
                            <button type="submit" class="btn btn-primary search-btn">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </form>

                        <!-- Box suggestion -->
                        <ul class="search-suggestions list-unstyled d-none"></ul>
                    </div>

                    <div class="filter-group">

                        <div class="dropdown">

                            <!-- 🔘 BUTTON -->
                            <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="mdi mdi-calendar-range"></i>

                                @if (request('date_from') && request('date_to'))
                                    {{ \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') }}
                                    -
                                    {{ \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') }}
                                @elseif(request('date_from'))
                                    Dari {{ \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') }}
                                @elseif(request('date_to'))
                                    Sampai {{ \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') }}
                                @else
                                    Tanggal
                                @endif
                            </button>

                            <!-- 📦 DROPDOWN -->
                            <div class="dropdown-menu p-3 dropdown-date">

                                <!-- 🏷 TITLE DI DALAM -->
                                <div class="mb-2 fw-semibold text-dark">
                                    Pilih Rentang Tanggal
                                </div>

                                <!-- 📝 FORM -->
                                <form method="GET" action="{{ route('document.all') }}">

                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                    <input type="hidden" name="sort" value="{{ request('sort') }}">

                                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                                        class="form-control mb-2">

                                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                                        class="form-control mb-2">

                                    <button class="btn btn-primary btn-sm w-100">
                                        Terapkan
                                    </button>
                                </form>
                            </div>

                        </div>

                        <!-- 📅 SORT -->
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="mdi mdi-sort"></i>
                                {{ request('sort') == 'asc' ? 'Terlama' : 'Terbaru' }}
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('document.all', array_merge(request()->except('sort'), ['sort' => 'desc'])) }}">
                                        Terbaru
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('document.all', array_merge(request()->except('sort'), ['sort' => 'asc'])) }}">
                                        Terlama
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- 🏷 CATEGORY -->
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">
                                <i class="mdi mdi-tag-outline"></i>
                                {{ request('category') ? $categories->firstWhere('slug', request('category'))->name ?? 'Kategori' : 'Kategori' }}
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('document.all') }}">
                                        Semua Kategori
                                    </a>
                                </li>

                                <li>
                                    <hr class="dropdown-divider">
                                </li>

                                @foreach ($categories as $cat)
                                    <li>
                                        <a class="dropdown-item"
                                            href="{{ route('document.all', array_merge(request()->except('category'), ['category' => $cat->slug])) }}">
                                            {{ $cat->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>


                        @if (request()->hasAny(['search', 'category', 'sort', 'date_from', 'date_to']))
                            <a href="{{ route('document.all') }}" class="btn btn-danger">
                                <i class="mdi mdi-refresh"></i> Reset
                            </a>
                        @endif

                    </div>
                </div>
            </div>

            <div class="document-page">

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <div class="view-toggle gap-2 btn-group mb-4">
                        <button class="btn btn-primary active" id="cardViewBtn">
                            <i class="mdi mdi-view-grid"></i> Grid
                        </button>

                        <button class="btn btn-primary" id="tableViewBtn">
                            <i class="mdi mdi-table"></i> Tabel
                        </button>
                    </div>
                </div>

                <div id="cardViewWrapper">
                    <div id="cardView" class="row">
                        @forelse ($all_document as $document)
                            <div class="col-xl-3 col-lg-3 col-md-4 col-6 mb-4">
                                <div class="ud-single-feature">
                                    <div class="ud-feature-icon">
                                        <i class="mdi {{ $document->icon_class }}"></i>
                                    </div>
                                    <div class="ud-feature-content">
                                        <h3 class="ud-feature-title">
                                            {!! \Illuminate\Support\Str::limit($document->title ?? '-', 20, '...') !!}
                                        </h3>
                                        <p class="ud-feature-desc">
                                            @if (optional($document->category)->slug)
                                                <a
                                                    href="{{ route('document.category', optional($document->category)->slug) }}">
                                                    {{ optional($document->category)->name }}
                                                </a>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </p>
                                        <p class="text-muted small">
                                            {{ \Carbon\Carbon::parse($document->date)->translatedFormat('d F Y') }}
                                        </p>

                                        <button class="btn btn-link text-primary p-0 mb-3 see-more-btn"
                                            data-bs-toggle="modal" data-bs-target="#detailModal"
                                            data-title="{{ $document->title }}"
                                            data-description="{!! htmlspecialchars($document->description) !!}"
                                            data-category="{{ $document->category->name ?? '-' }}"
                                            data-date="{{ \Carbon\Carbon::parse($document->date)->translatedFormat('d F Y') }}">
                                            Lihat Selengkapnya
                                        </button>


                                        <div class="d-flex gap-2">
                                            @if ($document->is_protected)
                                                <button
                                                    class="btn btn-sm btn-warning text-white d-inline-flex align-items-center gap-1 btn-action-mobile"
                                                    data-bs-toggle="modal" data-bs-target="#passwordModal"
                                                    data-id="{{ $document->id }}">
                                                    <i class="mdi mdi-shield-lock"></i>
                                                    <span>Terproteksi</span>
                                                </button>
                                            @else
                                                <a href="{{ route('documents.download', $document->id) }}"
                                                    class="btn btn-sm btn-success text-white d-inline-flex align-items-center gap-1 btn-action-mobile">
                                                    <i class="mdi mdi-download-circle"></i>
                                                    <span>Download</span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <h5 class="text-muted">
                                    <i class="mdi mdi-file-search-outline fs-2"></i><br>
                                    Tidak ada dokumen
                                    ditemukan{{ request('search') ? ' untuk pencarian "' . e(request('search')) . '"' : '' }}.
                                </h5>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- ===== Pagination ===== -->
                <div id="cardPagination" class="row mt-4">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="card-pagination-wrapper">
                            {{ $all_document->links('vendor.pagination.custom-3page') }}
                        </div>
                    </div>
                </div>

                <div id="tableView" class="d-none">
                    <table id="documentTable" class="table table-hover align-middle w-100" style="font-size: 13px;">
                        <thead class="table-light">
                            <tr>
                                <th>Dokumen</th>
                                <th>Kategori</th>
                                <th>Tanggal</th>
                                <th style="width: 120px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documentsAll as $doc)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="d-flex align-items-center justify-content-center rounded-2 bg-primary bg-opacity-10 flex-shrink-0"
                                                style="width:32px; height:32px;">
                                                <i class="mdi {{ $doc->icon_class }} text-primary"
                                                    style="font-size:15px;"></i>
                                            </div>
                                            <div style="min-width:0;">
                                                <div class="fw-semibold title-clamp">
                                                    {{ \Illuminate\Support\Str::limit($doc->title, 80) }}
                                                </div>
                                                <div class="text-muted desc-clamp">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($doc->description), 120) }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span
                                            class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary fw-normal border"
                                            style="font-size:11px;">
                                            {{ $doc->category->name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="text-muted" style="font-size:12px; white-space:nowrap;"
                                        data-order="{{ \Carbon\Carbon::parse($doc->date)->format('Y-m-d') }}">
                                        {{ \Carbon\Carbon::parse($doc->date)->format('d M Y') }}
                                    </td>

                                    <td>
                                        <div class="d-flex gap-2">

                                            <!-- Detail -->
                                            <button class="btn see-more-btn btn-sm btn-primary btn-action"
                                                data-bs-toggle="modal" data-bs-target="#detailModal"
                                                data-title="{{ $doc->title }}"
                                                data-description="{!! htmlspecialchars($doc->description) !!}"
                                                data-category="{{ $doc->category->name ?? '-' }}"
                                                data-date="{{ \Carbon\Carbon::parse($doc->date)->translatedFormat('d F Y') }}">
                                                <i class="mdi mdi-feature-search" style="font-size:13px;"></i>
                                            </button>

                                            @if ($doc->is_protected)
                                                <!-- Protected -->
                                                <button
                                                    class="btn btn-sm text-white btn-warning d-inline-flex align-items-center gap-1 btn-action"
                                                    data-bs-toggle="modal" data-bs-target="#passwordModal"
                                                    data-id="{{ $doc->id }}" style="font-size:12px;">
                                                    <i class="mdi mdi-lock" style="font-size:13px;"></i>
                                                </button>
                                            @else
                                                <!-- Download -->
                                                <a href="{{ route('documents.download', $doc->id) }}"
                                                    class="btn btn-sm btn-success d-inline-flex align-items-center gap-1 btn-action"
                                                    style="font-size:12px;">
                                                    <i class="mdi mdi-download" style="font-size:13px;"></i>
                                                </a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="modal fade custom-modal" id="detailModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <p id="modalDescription"></p>

                        <hr>

                        <small class="text-muted">
                            Kategori: <b id="modalCategory"></b><br>
                            Tanggal: <b id="modalDate"></b>
                        </small>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>

                </div>
            </div>
        </div>

        <!-- ===== Modal Password ===== -->
        <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="passwordModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <form id="passwordForm" method="POST" action="{{ route('documents.verifyPassword') }}"
                    data-verify-url="{{ route('documents.verifyPassword') }}" class="w-100">
                    @csrf

                    <!-- Hidden ID dokumen -->
                    <input type="hidden" name="document_id" id="document_id">

                    <div class="modal-content password-modal border-0 shadow-lg rounded-4">

                        <div class="modal-header border-0 text-center flex-column pb-0">
                            <div class="icon-wrapper mb-3">
                                <i class="ri-lock-fill"></i>
                            </div>
                            <h5 class="modal-title fw-bold text-primary" id="passwordModalLabel">
                                Akses Dokumen Terproteksi
                            </h5>
                            <button type="button" class="btn-close position-absolute end-0 me-3 mt-3"
                                data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body pt-0">
                            <p class="text-muted text-center mb-4">
                                Dokumen ini dilindungi password. Silakan masukkan password untuk melanjutkan proses
                                download.
                            </p>

                            <div class="mb-4">
                                <label for="access_password" class="form-label fw-semibold">Password
                                    Dokumen</label>

                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="ri-lock-fill text-secondary"></i>
                                    </span>

                                    <!-- Password Field Fix -->
                                    <input type="password" class="form-control border-start-0" id="access_password"
                                        name="access_password" placeholder="Masukkan Password..." />

                                    <!-- Eye Button -->
                                    <span class="input-group-text bg-light">
                                        <i class="ri-eye-close-line" id="togglePassword" style="cursor:pointer;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pt-0">
                            <button type="submit" class="btn btn-gradient w-100 py-2 fw-semibold">
                                Verifikasi & Download
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

    </section>
    <!-- ====== Features End ====== -->


    @push('scripts')
        <script src="{{ asset('js/document-page.js') }}" data-category=""></script>
    @endpush

</x-landingpage.layout>

<script>
    function updateSearchPlaceholder() {
        const searchInput = document.querySelector('.search-input');

        if (!searchInput) return;

        if (window.innerWidth <= 576) {
            searchInput.placeholder = 'Cari dokumen...';
        } else {
            searchInput.placeholder =
                'Cari Dokumen berdasarkan judul atau konten...';
        }
    }

    updateSearchPlaceholder();

    window.addEventListener('resize', updateSearchPlaceholder);

    function cleanUrlPage() {
        const url = new URL(window.location);
        if (url.searchParams.has('page')) {
            url.searchParams.delete('page');
            window.history.replaceState({}, '', url);
        }
    }

    function initDataTable() {
        if ($.fn.DataTable.isDataTable('#documentTable')) return;

        const isMobile = window.innerWidth <= 768;

        $('#documentTable').DataTable({
            paging: true,
            pagingType: "simple_numbers",
            searching: true,
            ordering: true,
            responsive: {
                details: {
                    type: 'column',
                    target: 'tr'
                }
            },
            autoWidth: false,
            deferRender: true,
            stateSave: false,
            pageLength: isMobile ? 5 : 10,
            lengthChange: !isMobile,
            info: !isMobile,
            scrollX: isMobile,
            dom: isMobile ?
                "<'row mb-2'<'col-12'f>>" +
                "<'row'<'col-12'tr>>" +
                "<'row mt-2'<'col-12 text-center'p>>" : "<'row mb-3'<'col-md-6'l><'col-md-6 text-end'f>>" +
                "<'row'<'col-12'tr>>" +
                "<'row mt-3'<'col-md-5'i><'col-md-7 text-end'p>>",
            language: {
                search: "",
                searchPlaceholder: "Cari dokumen...",
                lengthMenu: "Tampilkan _MENU_",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_",
                zeroRecords: "Tidak ada data",
                paginate: {
                    next: "›",
                    previous: "‹"
                }
            },
            columnDefs: [{
                    targets: [1, 2],
                    visible: !isMobile,
                    responsivePriority: 10001
                },
                {
                    targets: 0,
                    responsivePriority: 1
                },
                {
                    targets: 3,
                    responsivePriority: 2,
                    orderable: false
                }
            ],
            order: [
                [2, 'desc']
            ],

        });

    }

    $(document).ready(function() {

        function showCard() {
            $('#cardViewWrapper').removeClass('d-none');
            $('#tableView').addClass('d-none');
            $('#cardPagination').removeClass('d-none');
            $('.filter-group').removeClass('d-none');
        }

        function showTable() {
            cleanUrlPage();
            $('#cardViewWrapper').addClass('d-none');
            $('#tableView').removeClass('d-none');
            $('#cardPagination').addClass('d-none');
            $('.filter-group').addClass('d-none');
            initDataTable();
        }

        // ✅ selalu mulai dari card view
        showCard();
        $('#cardViewBtn').addClass('active');
        $('#tableViewBtn').removeClass('active');

        $('#cardViewBtn').click(function() {
            showCard();
            $(this).addClass('active');
            $('#tableViewBtn').removeClass('active');
        });

        $('#tableViewBtn').click(function() {
            showTable();
            $(this).addClass('active');
            $('#cardViewBtn').removeClass('active');
        });

        $(document).on('click', '.see-more-btn', function() {
            $('#modalTitle').text($(this).data('title'));
            $('#modalDescription').html($(this).data('description'));
            $('#modalCategory').text($(this).data('category'));
            $('#modalDate').text($(this).data('date'));
        });
    });
</script>
