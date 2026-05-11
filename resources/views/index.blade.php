<x-landingpage.layout :title='$title'>

    <!-- ====== Hero Carousel Full-Width Start ====== -->
    <section id="home">
        <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">

                @if ($carousels->isEmpty())
                    <!-- Default Slide -->
                    <div class="carousel-item active"
                        style="background: url('{{ asset('assets/images/default/default1.jpg') }}') center/cover no-repeat; height: 100vh;">
                    </div>
                @else
                    @foreach ($carousels as $index => $carousel)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">

                            {{-- Gambar --}}
                            <img src="{{ $carousel->image ? asset('storage/' . $carousel->image) : asset('assets/images/blog/blog-01.jpg') }}"
                                class="d-block w-100" alt="{{ $carousel->title ?? '' }}">

                            {{-- Overlay gradient --}}
                            <div class="carousel-item__overlay"></div>

                            {{-- Teks: judul + deskripsi (tengah vertikal) --}}
                            <div class="carousel-item__text">
                                <div class="container">
                                    <h1>{!! $carousel->title ?? '' !!}</h1>
                                    <p>{!! Str::limit(strip_tags($carousel->description ?? ''), 120) !!}</p>
                                </div>
                            </div>

                            {{-- Tombol: menempel di atas pagination --}}
                            <div class="carousel-item__btn">
                                <a href="{{ filter_var($carousel?->btn_link, FILTER_VALIDATE_URL) ? $carousel->btn_link : '#' }}"
                                    class="btn ud-main-btn">Show More</a>
                            </div>

                        </div>
                    @endforeach
                @endif

            </div>

            {{-- Pagination & Kontrol --}}
            <div class="carousel-controls">
                <div class="carousel-controls__inner">

                    {{-- Tombol Prev --}}
                    <button class="carousel-control-prev position-static" type="button" data-bs-target="#heroCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    {{-- Dots --}}
                    <div class="carousel-indicators position-static m-0">
                        @if ($carousels->isEmpty())
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"
                                aria-current="true"></button>
                        @else
                            @foreach ($carousels as $index => $carousel)
                                <button type="button" data-bs-target="#heroCarousel"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                    {{ $index === 0 ? 'aria-current=true' : '' }}></button>
                            @endforeach
                        @endif
                    </div>

                    {{-- Tombol Next --}}
                    <button class="carousel-control-next position-static" type="button" data-bs-target="#heroCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                </div>
            </div>

        </div>
    </section>
    <!-- ====== Hero Carousel Full-Width End ====== -->

    <!-- ====== About Start ====== -->
    <section id="about" class="ud-about">
        <div class="container">
            <!-- Layout Flex -->
            <div class="ud-about-flex d-flex align-items-start gap-4">

                <!-- Gambar About -->
                <div class="ud-about-image flex-shrink-0">
                    <img src="{{ $about && $about->thumbnail ? asset('storage/' . $about->thumbnail) : asset('assets/images/background/brandi-redd-aJTiW00qqtI-unsplash.jpg') }}"
                        alt="about-image" class="about-image" />
                </div>

                <!-- Konten About -->
                <div class="ud-about-content-wrapper flex-grow-1 position-relative">
                    <div class="ud-about-content">
                        <span class="tag">About - {{ $about->name ?? 'LPP-UPY' }}</span>
                        <div class="custom-about-content">
                            <h2 style="text-align: justify">{!! Str::limit($about->description ?? '-', 400, '...') !!}</h2>
                        </div>
                    </div>
                    <a href="/abouts" class="ud-main-btn learn-more-btn">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== About End ====== -->

    <!-- ====== Document Start ====== -->
    <section id="document" class="ud-features">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title mx-auto text-center mb-5">
                        <span>Dokumen</span>
                        <h2>Dokumen Terbaru</h2>
                        <p>
                            Temukan dokumen terbaru yang Anda butuhkan. Jika terdapat dokumen yang terkunci, silakan
                            menghubungi Tim LPP
                            - UPY
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($documents as $document)
                    <!-- col-6 untuk mobile (2 kolom), col-sm-6 untuk tablet, col-lg-3 untuk desktop -->
                    <div class="col-6 col-sm-6 col-lg-3 mb-4">
                        <div class="ud-single-feature wow fadeInUp" data-wow-delay=".1s">
                            <div class="ud-feature-icon">
                                <i class="mdi {{ $document->icon_class ?? '-' }}"></i>
                            </div>
                            <div class="ud-feature-content">
                                <!-- Judul Dokumen -->
                                <h3 class="ud-feature-title mb-2">
                                    {!! \Illuminate\Support\Str::limit($document->title ?? '-', 20, '...') !!}
                                </h3>

                                <!-- Kategori -->
                                <p class="ud-feature-desc text-muted mb-1">
                                    {{ $document->category->name ?? '-' }}
                                </p>

                                <p class="text-muted small">
                                    {{ \Carbon\Carbon::parse($document->date)->translatedFormat('d F Y') }}
                                </p>

                                <p class="ud-feature-desc mb-2">
                                    {!! Str::limit(strip_tags($document->description), 55) !!}
                                </p>

                                <button class="btn btn-link text-primary p-0 mb-3 see-more-btn" data-bs-toggle="modal"
                                    data-bs-target="#detailModal" data-title="{{ $document->title }}"
                                    data-description="{!! htmlspecialchars($document->description) !!}"
                                    data-category="{{ $document->category->name ?? '-' }}"
                                    data-date="{{ \Carbon\Carbon::parse($document->date)->translatedFormat('d F Y') }}">
                                    Lihat Selengkapnya
                                </button>

                                <!-- Tombol Aksi -->
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
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="lni lni-files fs-1 text-muted mb-3"></i>
                            <h5 class="fw-semibold text-muted">Belum ada dokumen tersedia</h5>
                            <p class="text-secondary mb-0">Dokumen baru akan muncul di sini setelah diunggah.</p>
                        </div>
                    </div>
                @endforelse


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
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Tutup</button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Tombol Show More -->
                <div class="col-12 show-more-wrapper mt-5">
                    <div class="text-center">
                        <a href="{{ route('document.all') }}" class="btn ud-main-btn">
                            Show More
                        </a>
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
    <!-- ====== Document End ====== -->


    <!-- ====== Blog Start ====== -->
    <section class="ud-blog-grids" id="news">
        <div class="container">
            <!-- Section Header -->
            <div class="ud-section-title mx-auto text-center mb-5">
                <span>Artikel</span>
                <h2>Berita & Kegiatan</h2>
                <p>Temukan berbagai berita, kegiatan, dan informasi terbaru <br> LPP-UPY</p>
            </div>

            @if ($posts->isNotEmpty())
                <!-- Carousel Desktop (3 posts per slide) -->
                <div id="blogCarousel" class="carousel slide d-none d-md-block" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @forelse ($posts->chunk(3) as $chunkIndex => $chunk)
                            <div class="carousel-item {{ $chunkIndex === 0 ? 'active' : '' }}">
                                <div class="row g-4">
                                    @foreach ($chunk as $post)
                                        <div class="col-md-6 col-lg-4">
                                            <div class="ud-single-blog h-100">
                                                <div class="ud-blog-image">
                                                    <a href="{{ route('post.show', $post->slug ?? '-') }}">
                                                        <img src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : asset('assets/images/default/default1.jpg') }}"
                                                            class="img-fluid rounded w-100"
                                                            alt="{!! $post->title ?? '-' !!}">
                                                    </a>
                                                </div>

                                                <div class="ud-blog-content p-3">
                                                    <span class="ud-blog-date small mb-1">
                                                        {{ \Carbon\Carbon::parse($post->date)->translatedFormat('d F Y') }}
                                                    </span>
                                                    <span class="d-block small mb-2">
                                                        By: {!! $post->author->name ?? 'Anonim' !!} —
                                                        {!! $post->category->name ?? 'Tanpa Kategori' !!}
                                                    </span>
                                                    <h3 class="ud-blog-title h6 fw-bold mb-2">
                                                        <a href="{{ route('post.show', $post->slug) ?? '#' }}"
                                                            class="text-dark text-decoration-none">
                                                            {!! \Illuminate\Support\Str::limit($post->title ?? '-', 23, '...') !!}
                                                        </a>
                                                    </h3>

                                                    <div class="ud-blog-desc small mb-0 text-muted">
                                                        {!! Str::words(strip_tags($post->content ?? '-'), 15, '...') !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <div class="row justify-content-center py-4">
                                    <p class="text-center text-muted mb-0">
                                        Belum ada postingan yang dipublikasikan.
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Carousel Mobile (1 post per slide) -->
                <div id="blogCarouselMobile" class="carousel slide d-md-none" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @forelse ($posts as $postIndex => $post)
                            <div class="carousel-item {{ $postIndex === 0 ? 'active' : '' }}">
                                <div class="row g-4 justify-content-center">
                                    <div class="col-12">
                                        <div class="ud-single-blog h-100">
                                            <div class="ud-blog-image">
                                                <a href="{{ route('post.show', $post->slug) ?? '#' }}">
                                                    <img src="{{ $post->thumbnail ? asset('storage/' . $post->thumbnail) : asset('assets/images/background/brandi-redd-aJTiW00qqtI-unsplash.jpg') }}"
                                                        class="img-fluid rounded w-100"
                                                        alt="{{ $post->title ?? '-' }}">
                                                </a>
                                            </div>

                                            <div class="ud-blog-content p-3">
                                                <span class="ud-blog-date small mb-1">
                                                    {{ $post->created_at->format('M d, Y') ?? '-' }}
                                                </span>
                                                <span class="d-block small mb-2">
                                                    By: {{ $post->author->name ?? 'Anonim' }} —
                                                    {{ $post->category->name ?? 'Tanpa Kategori' }}
                                                </span>
                                                <h3 class="ud-blog-title h6 fw-bold mb-2">
                                                    <a href="{{ route('post.show', $post->slug) ?? '#' }}"
                                                        class="text-dark text-decoration-none">
                                                        {{ $post->title ?? '-' }}
                                                    </a>
                                                </h3>

                                                <p class="ud-blog-desc small mb-0 text-muted">
                                                    {!! Str::words(strip_tags($post->content) ?? '-', 15, '...') !!}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <div class="row justify-content-center py-4">
                                    <p class="text-center text-muted mb-0">
                                        Belum ada postingan yang dipublikasikan.
                                    </p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Carousel Controls Desktop -->
                <div
                    class="post-carousel-controls d-none d-md-flex justify-content-center align-items-center mt-4 gap-4">
                    <button class="post-carousel-prev position-static btn btn-primary shadow-sm rounded-circle"
                        type="button" data-bs-target="#blogCarousel" data-bs-slide="prev" aria-label="Sebelumnya">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>

                    <div class="post-carousel-indicators position-static m-0 d-flex gap-2">
                        @foreach ($posts->chunk(3) as $index => $chunk)
                            <button type="button" data-bs-target="#blogCarousel"
                                data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <button class="post-carousel-next position-static btn btn-primary shadow-sm rounded-circle"
                        type="button" data-bs-target="#blogCarousel" data-bs-slide="next" aria-label="Selanjutnya">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>

                <!-- Carousel Controls Mobile -->
                <div
                    class="post-carousel-controls d-md-none d-flex justify-content-center align-items-center mt-4 gap-4">
                    <button class="post-carousel-prev position-static btn btn-primary shadow-sm rounded-circle"
                        type="button" data-bs-target="#blogCarouselMobile" data-bs-slide="prev"
                        aria-label="Sebelumnya">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>

                    <div class="post-carousel-indicators position-static m-0 d-flex gap-2">
                        @foreach ($posts as $index => $post)
                            <button type="button" data-bs-target="#blogCarouselMobile"
                                data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"
                                aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                                aria-label="Slide {{ $index + 1 }}"></button>
                        @endforeach
                    </div>

                    <button class="post-carousel-next position-static btn btn-primary shadow-sm rounded-circle"
                        type="button" data-bs-target="#blogCarouselMobile" data-bs-slide="next"
                        aria-label="Selanjutnya">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                </div>

                <!-- Tombol Show More -->
                <div class="row mt-3">
                    <div class="col-lg-12 show-more-wrapper mt-5">
                        <a href="{{ route('post.all') }}" class="btn ud-main-btn">
                            Show More
                        </a>
                    </div>
                </div>
            @else
                <p class="text-center text-muted">Belum ada postingan.</p>
            @endif
        </div>
    </section>
    <!-- ====== Blog End ====== -->


    <!-- ====== Team Start ====== -->
    <section id="team" class="ud-team">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title mx-auto text-center">
                        <span>Struktur Organisasi</span>
                        <h2>Lembaga Pengembangan Pendidikan UPY</h2>
                        <p>
                            LPP UPY terdiri atas tim yang berkomitmen mengembangkan kualitas pembelajaran dan inovasi
                            pendidikan.
                        </p>
                    </div>
                </div>
                @forelse ($members as $member)
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <div class="ud-single-team wow fadeInUp" data-wow-delay=".1s">
                            <div class="ud-team-image-wrapper">
                                <div class="ud-team-image">
                                    <img src="{{ asset('storage/' . $member->foto) }}" alt="team"
                                        style="height: 180px; width: 180px;" />
                                </div>
                                <img src="{{ asset('assets/images/team/shape-2.svg') }}" alt="shape"
                                    class="shape shape-2" />
                            </div>
                            <div class="ud-team-info">
                                <h5>{{ $member->nama }}</h5>
                                <h6>{{ $member->divisi }}</h6>
                            </div>
                            <ul class="ud-team-socials">
                                @if (!empty($member->facebook_link) && filter_var($member?->facebook_link, FILTER_VALIDATE_URL))
                                    <li>
                                        <a href="{{ $member->facebook_link }}" target="_blank">
                                            <i class="lni lni-facebook-filled"></i>
                                        </a>
                                    </li>
                                @endif

                                @if (!empty($member->linkedin_link) && filter_var($member?->linkedin_link, FILTER_VALIDATE_URL))
                                    <li>
                                        <a href="{{ $member->linkedin_link }}" target="_blank">
                                            <i class="lni lni-linkedin-original"></i>
                                        </a>
                                    </li>
                                @endif

                                @if (!empty($member->instagram_link) && filter_var($member?->instagram_link, FILTER_VALIDATE_URL))
                                    <li>
                                        <a href="{{ $member->instagram_link }}" target="_blank">
                                            <i class="lni lni-instagram-filled"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                @empty
                    <div class="col-12">
                        <div class="text-center py-4">
                            <p class="mb-0">
                                Belum ada anggota tim yang ditambahkan.
                            </p>
                        </div>
                    </div>
                @endforelse

                <!-- Tombol Show More -->
                <div class="col-lg-12 show-more-wrapper mt-5">
                    <a href="{{ route('organizational-structure.index') }}" class="btn ud-main-btn">
                        Show More
                    </a>
                </div>
            </div>

        </div>
    </section>
    <!-- ====== Team End ====== -->

    <!-- ====== Service Start ====== -->
    <section id="service" class="ud-faq">
        <div class="shape">
            <img src="assets/images/faq/shape.svg" alt="shape" />
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ud-section-title text-center mx-auto">
                        <span>Layanan</span>
                        <h2>Daftar Layanan LPP UPY</h2>
                        <p>
                            Temukan informasi dan tautan akses menuju berbagai layanan pengembangan pendidikan yang
                            tersedia di LPP UPY.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse ($services as $key => $service)
                    <div class="col-lg-6 mb-3">
                        <div class="ud-single-faq wow fadeInUp" data-wow-delay=".{{ $key * 1.5 }}s">
                            <div class="accordion">
                                <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $key }}">
                                    <span class="icon flex-shrink-0">
                                        <i class="lni lni-chevron-down"></i>
                                    </span>
                                    <span>{{ $service->name }}</span>
                                </button>
                                <div id="collapse{{ $key }}" class="accordion-collapse collapse">
                                    <div class="ud-faq-body">
                                        {{-- Deskripsi --}}
                                        <p class="mb-2">
                                            {!! $service->description !!}
                                        </p>

                                        {{-- Tombol Akses --}}
                                        @if (filter_var($service?->link, FILTER_VALIDATE_URL))
                                            <a href="{{ $service->link }}" target="_blank"
                                                class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2">
                                                <i class="ri-external-link-line"></i>
                                                Akses Layanan
                                            </a>
                                        @else
                                            <button class="btn btn-secondary btn-sm" disabled>
                                                Link tidak tersedia
                                            </button>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-6">
                        <div class="ud-single-faq wow fadeInUp" data-wow-delay=".1s">
                            <div class="accordion">
                                <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne">
                                    <span class="icon flex-shrink-0">
                                        <i class="lni lni-chevron-down"></i>
                                    </span>
                                    <span>How to use UIdeck?</span>
                                </button>
                                <div id="collapseOne" class="accordion-collapse collapse">
                                    <div class="ud-faq-body">
                                        Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's
                                        standard dummy text ever since the 1500s, when an unknown
                                        printer took a galley of type and scrambled it to make a
                                        type specimen book.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ud-single-faq wow fadeInUp" data-wow-delay=".15s">
                            <div class="accordion">
                                <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo">
                                    <span class="icon flex-shrink-0">
                                        <i class="lni lni-chevron-down"></i>
                                    </span>
                                    <span>How to download icons from Lineicons?</span>
                                </button>
                                <div id="collapseTwo" class="accordion-collapse collapse">
                                    <div class="ud-faq-body">
                                        Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's
                                        standard dummy text ever since the 1500s, when an unknown
                                        printer took a galley of type and scrambled it to make a
                                        type specimen book.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ud-single-faq wow fadeInUp" data-wow-delay=".2s">
                            <div class="accordion">
                                <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree">
                                    <span class="icon flex-shrink-0">
                                        <i class="lni lni-chevron-down"></i>
                                    </span>
                                    <span>Is GrayGrids part of UIdeck?</span>
                                </button>
                                <div id="collapseThree" class="accordion-collapse collapse">
                                    <div class="ud-faq-body">
                                        Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's
                                        standard dummy text ever since the 1500s, when an unknown
                                        printer took a galley of type and scrambled it to make a
                                        type specimen book.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ud-single-faq wow fadeInUp" data-wow-delay=".1s">
                            <div class="accordion">
                                <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour">
                                    <span class="icon flex-shrink-0">
                                        <i class="lni lni-chevron-down"></i>
                                    </span>
                                    <span>Can I use this template for commercial project?</span>
                                </button>
                                <div id="collapseFour" class="accordion-collapse collapse">
                                    <div class="ud-faq-body">
                                        Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's
                                        standard dummy text ever since the 1500s, when an unknown
                                        printer took a galley of type and scrambled it to make a
                                        type specimen book.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ud-single-faq wow fadeInUp" data-wow-delay=".15s">
                            <div class="accordion">
                                <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive">
                                    <span class="icon flex-shrink-0">
                                        <i class="lni lni-chevron-down"></i>
                                    </span>
                                    <span>Do you have plan releasing Play Pro?</span>
                                </button>
                                <div id="collapseFive" class="accordion-collapse collapse">
                                    <div class="ud-faq-body">
                                        Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's
                                        standard dummy text ever since the 1500s, when an unknown
                                        printer took a galley of type and scrambled it to make a
                                        type specimen book.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ud-single-faq wow fadeInUp" data-wow-delay=".2s">
                            <div class="accordion">
                                <button class="ud-faq-btn collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix">
                                    <span class="icon flex-shrink-0">
                                        <i class="lni lni-chevron-down"></i>
                                    </span>
                                    <span>Where and how to host this template?</span>
                                </button>
                                <div id="collapseSix" class="accordion-collapse collapse">
                                    <div class="ud-faq-body">
                                        Lorem Ipsum is simply dummy text of the printing and
                                        typesetting industry. Lorem Ipsum has been the industry's
                                        standard dummy text ever since the 1500s, when an unknown
                                        printer took a galley of type and scrambled it to make a
                                        type specimen book.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse

            </div>
            <!-- Tombol Show More -->
            <div class="row">
                <div class="col-lg-12 show-more-wrapper mt-5">
                    <a href="/service" class="btn ud-main-btn">
                        Show More
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Service End ====== -->

    <!-- ====== Contact Start ====== -->
    <section id="contact" class="ud-contact">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-8 col-lg-7">
                    <div class="ud-contact-content-wrapper">
                        <div class="ud-contact-title">
                            <span>Kontak - BIMA</span>
                            <p>
                                Jika Anda membutuhkan informasi lebih lanjut mengenai layanan atau informasi lainnya,
                                silakan menghubungi kami melalui kontak BIMA – Bantuan, Informasi, Masukan, dan
                                Aspirasi.
                            </p>
                        </div>
                        <div class="ud-contact-info-wrapper">
                            <div class="ud-single-info">
                                <div class="ud-info-icon">
                                    <i class="lni lni-map-marker"></i>
                                </div>
                                <div class="ud-info-meta">
                                    <h5>Alamat</h5>
                                    <p>{{ $about->address ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="ud-single-info">
                                <div class="ud-info-icon">
                                    <i class="lni lni-envelope"></i>
                                </div>
                                <div class="ud-info-meta">
                                    <h5>E-mail</h5>
                                    <p>{{ $about->email ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="ud-single-info">
                                <div class="ud-info-icon">
                                    <i class="ri-phone-line"></i>
                                </div>
                                @php
                                    $contact = $about?->phone;

                                    // ambil hanya angka
                                    $number = preg_replace('/[^0-9]/', '', $contact);

                                    // ubah jika diawali 0 → ganti jadi 62
                                    if (Str::startsWith($number, '0')) {
                                        $number = '62' . substr($number, 1);
                                    }

                                    // pastikan hanya dibuat jika ada isi
                                    $waLink = !empty($number) ? "https://wa.me/{$number}" : null;
                                @endphp

                                <div class="ud-info-meta">
                                    <h5>Kontak</h5>

                                    @if ($waLink)
                                        <p>
                                            <a href="{{ $waLink }}" class="text-dark" target="_blank">
                                                {{ $about?->phone }}
                                            </a>
                                        </p>
                                    @else
                                        <p>-</p>
                                    @endif
                                </div>
                            </div>
                            <div class="ud-single-info">
                                <div class="ud-info-icon">
                                    <i class="ri-instagram-line"></i>
                                </div>
                                <div class="ud-info-meta">
                                    <h5>Instagram</h5>
                                    <a href="{{ filter_var($about?->instagram_link, FILTER_VALIDATE_URL) ? $about->instagram_link : '#' }}"
                                        target="_blank">
                                        <p>LPP - UPY</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5">
                    <div class="ud-contact-form-wrapper wow fadeInUp" data-wow-delay=".2s">
                        <h3 class="ud-contact-form-title">Kirim Pesan</h3>
                        <form class="ud-contact-form" action="{{ route('messages.store') }}" method="POST">
                            @csrf
                            <div class="ud-form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="name" id="name" placeholder="LPP UPY"
                                    required />
                            </div>

                            <div class="ud-form-group">
                                <label for="origin">Asal</label>
                                <input type="text" name="origin" id="origin"
                                    placeholder="Universitas PGRI Yogyakarta" required />
                            </div>

                            <div class="ud-form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email"
                                    placeholder="example@yourmail.com" required />
                            </div>

                            <div class="ud-form-group">
                                <label for="phone">No - Handphone</label>
                                <input type="phone" name="phone" id="phone" placeholder="082344532233"
                                    required />
                            </div>

                            <div class="ud-form-group">
                                <label for="message">Pesan</label>
                                <textarea name="message" id="message" rows="3" placeholder="Ketik pesan disini..." required></textarea>
                            </div>

                            <div class="ud-form-group mb-0">
                                <button type="submit" class="ud-main-btn">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Contact End ====== -->

    @push('scripts')
        <script src="{{ asset('js/home-page.js') }}"></script>
    @endpush

</x-landingpage.layout>

<script>
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || performance.getEntriesByType("navigation")[0]?.type === "back_forward") {
            document.querySelectorAll('form').forEach(form => form.reset());
        }
    });
    $(document).on('click', '.see-more-btn', function() {
        $('#modalTitle').text($(this).data('title'));
        $('#modalDescription').html($(this).data('description'));
        $('#modalCategory').text($(this).data('category'));
        $('#modalDate').text($(this).data('date'));
    });
</script>
