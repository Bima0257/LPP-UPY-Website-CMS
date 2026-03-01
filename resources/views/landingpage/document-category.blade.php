<x-landingpage.layout title="{{ $title }}">

    <!-- ====== Banner Start ====== -->
    <section class="ud-page-banner"
        style="background-image: url('{{ !empty($banner) && !empty($banner->banner_background)
            ? asset('storage/' . $banner->banner_background)
            : asset('assets/images/background/background-default.jpg') }}');">
        <div class="row">
            <div class="col-lg-12">
                <div class="ud-banner-content">
                    <h1>News & Information</h1>
                    <h4 class="text-white mt-3">Kategori - {!! $category->name !!}</h4>
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
                        <span>Informasi</span>
                        <h2>Dokumen Terbaru</h2>
                        <p>
                            Temukan berbagai dokumen terbaru yang baru saja diunggah oleh LPP untuk memberikan informasi
                            terkini kepada Anda.
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
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="form-control search-input"
                                    placeholder="Cari dokumen berdasarkan judul, deskripsi, atau kategori..."
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
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <div class="ud-single-feature wow fadeInUp" data-wow-delay=".1s">
                            <div class="ud-feature-icon">
                                <i class="mdi {{ $document->icon_class }}"></i>
                            </div>
                            <div class="ud-feature-content">
                                <h3 class="ud-feature-title">{!! $document->title !!}</h3>
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
                                <a href="#" class="ud-feature-link">
                                    Download
                                </a>
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
    </section>
    <!-- ====== Features End ====== -->

    @push('scripts')
        <script src="{{ asset('js/document-page.js') }}" data-category="{{ $category->slug }}"></script>
    @endpush

</x-landingpage.layout>
