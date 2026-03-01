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
                        <h1>Tentang LPP</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ====== Banner End ====== -->

    <!-- ====== About Start ====== -->
    <section id="custom-about" class="custom-about-section">
        <div class="container">
            @if ($about)
                <div class="custom-about-wrapper wow fadeInUp" data-wow-delay=".2s">

                    <!-- Gambar di atas tengah -->
                    <div class="custom-about-image text-center mb-4">
                        <img src="{{ asset('storage/' . $about->image) }}" alt="about-image" />
                    </div>

                    <!-- Teks di bawah gambar rata kiri -->
                    <div class="custom-about-content">
                        <span class="tag">{{ $about->name ?? '-' }}</span>
                        <h2>Tentang {{ $about->name ?? '-' }}</h2>
                        <div style="text-align: justify">{!! $about->description ?? '-' !!}</div>

                    </div>

                    <div class="contact-info mt-3 ms-3">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="ri-map-pin-2-fill me-2 text-primary"></i>
                                {{ $about->address ?? 'Alamat belum diisi' }}
                            </li>
                            <li class="mb-2">
                                <i class="ri-mail-fill me-2 text-primary"></i>
                                {{ $about->email ?? 'Email belum diisi' }}
                            </li>
                            <li class="mb-2">
                                <i class="ri-phone-fill me-2 text-primary"></i>
                                {{ $about->phone ?? 'Telepon belum diisi' }}
                            </li>
                            <li class="mb-2">
                                <i class="ri-instagram-fill me-2 text-primary"></i>
                                <a href="{{ $about->instagram_link ?? '#' }}" target="_blank">LPP - UPY</a>
                            </li>
                            <li class="mb-2">
                                <i class="ri-youtube-fill me-2 text-danger"></i>
                                <a href="{{ $about->youtube_link ?? '#' }}" target="_blank">LPP - UPY</a>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
                <div class="text-center">
                    <p>Belum ada Content About.</p>
                </div>
            @endif
        </div>
    </section>
    <!-- ====== About End ====== -->



</x-landingpage.layout>
