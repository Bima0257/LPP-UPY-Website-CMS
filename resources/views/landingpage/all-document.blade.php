<x-landingpage.layout title="{{ $title }}">

    <!-- ====== Banner Start ====== -->
    <section class="ud-page-banner"
        style="background-image: url('{{ !empty($banner) && !empty($banner->banner_background)
            ? asset('storage/' . $banner->banner_background)
            : asset('assets/images/background/background-default.jpg') }}');">
        <div class="row">
            <div class="col-lg-12">
                <div class="ud-banner-content">
                    <h1>{{ $title }}</h1>
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
            </div>

            <!-- ====== Search Bar ====== -->
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto mb-5">
                    <div class="search-wrapper">
                        <form
                            action="{{ isset($category) ? route('document.category', $category->slug) : route('document.all') }}"
                            method="GET" class="search-form">
                            <div class="search-input-wrapper">
                                <input type="text" name="search" class="form-control search-input"
                                    data-suggest-url="{{ isset($category) ? route('document.suggestions', $category->slug) : route('document.suggestions') }}"
                                    autocomplete="off">

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
                </div>
            </div>

            <div class="row">
                @forelse ($all_document as $document)
                    <div class="col-xl-3 col-lg-3 col-md-4 col-6 mb-4">
                        <div class="ud-single-feature wow fadeInUp" data-wow-delay=".1s">
                            <div class="ud-feature-icon">
                                <i class="mdi {{ $document->icon_class }}"></i>
                            </div>
                            <div class="ud-feature-content">
                                <h3 class="ud-feature-title">{!! $document->title !!}</h3>
                                <p class="ud-feature-desc">
                                    @if (optional($document->category)->slug)
                                        <a href="{{ route('document.category', optional($document->category)->slug) }}">
                                            {{ optional($document->category)->name }}
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                </p>
                                <p class="text-muted small">
                                    {{ $document->created_at ? $document->created_at->format('d M Y') : '-' }}
                                </p>

                                <p class="ud-feature-desc mb-2">
                                    {!! Str::limit(strip_tags($document->description), 55) !!}
                                </p>

                                <button class="btn btn-link text-primary p-0 mb-3 see-more-btn" data-bs-toggle="modal"
                                    data-bs-target="#modalDesc{{ $document->id }}">
                                    Lihat Selengkapnya
                                </button>

                                <div class="modal fade custom-modal" id="modalDesc{{ $document->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Deskripsi Dokumen</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                <p id="modal-description">{!! $document->description !!}</p>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <!-- Tombol Aksi -->
                                <div class="d-flex gap-2">
                                    @if ($document->is_protected)
                                        <button class="btn btn-sm btn-primary text-white" data-bs-toggle="modal"
                                            data-bs-target="#passwordModal" data-id="{{ $document->id }}">
                                            <i class="mdi mdi-shield-lock"></i> Download
                                        </button>
                                    @else
                                        <a href="{{ route('documents.download', $document->id) }}"
                                            class="btn btn-sm btn-success text-white">
                                            <i class="mdi mdi-download-circle"></i> Download
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
            <!-- ===== Pagination ===== -->
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $all_document->links('pagination::bootstrap-5') }}
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
                                <label for="access_password" class="form-label fw-semibold">Password Dokumen</label>

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
