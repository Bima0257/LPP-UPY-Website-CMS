<!-- ====== Footer Start ====== -->
<footer class="ud-footer wow fadeInUp" data-wow-delay=".15s"
    style="background-image: url('{{ $banner?->footer_background ? asset('storage/' . $banner->footer_background) : asset('assets/images/background/background-default.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <div class="ud-footer-widgets">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="ud-widget">
                        <a href="/#home" class="ud-footer-logo">
                            <img src="{{ $about?->white_logo ? asset('storage/' . $about->white_logo) : asset('assets/images/logo/white_logo.png') }}"
                                alt="logo" />
                        </a>
                        <div class="ud-widget-desc">
                            {!! Str::words($about->description ?? '-', 15, '...') !!}
                        </div>
                        <ul class="list-unstyled text-white">
                            <li class="mb-2">
                                <a href="{{ $about->youtube_link ?? '#' }}" class="text-white" target="_blank">
                                    <i class="mdi mdi-youtube me-2"></i>
                                    LPP-UPY
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="{{ $about->instagram_link ?? '#' }}" class="text-white" target="_blank">
                                    <i class="mdi mdi-instagram me-2"></i>
                                    LPP-UPY
                                </a>
                            </li>
                            <li class="mb-2">
                                <i class="mdi mdi-email-outline me-2 text-white"></i>
                                {{ $about->email ?? 'info@example.com' }}
                            </li>
                            <li class="mb-2">
                                <i class="mdi mdi-phone-outline me-2 text-white"></i>
                                {{ $about->phone ?? '+62 812-3456-7890' }}
                            </li>

                        </ul>
                        <ul class="ud-widget-socials mt-2">

                        </ul>

                    </div>
                </div>

                <div class="col-xl-3 col-lg-2 col-md-6 col-sm-6">
                    <div class="ud-widget">
                        <h5 class="ud-widget-title">Navigasi</h5>
                        <ul class="ud-widget-links">
                            <li>
                                <a href="/#home">Home</a>
                            </li>
                            <li>
                                <a href="{{ route('organizational-structure.index') }}">Struktur Organisasi</a>
                            </li>
                            <li>
                                <a href="/abouts">About</a>
                            </li>
                            <li>
                                <a href="{{ route('post.all') }}">Informasi & Berita</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="ud-widget">
                        <h5 class="ud-widget-title">Kategori Dokumen</h5>
                        <ul class="ud-widget-links">
                            @if ($documentCategories->isNotEmpty())
                                @foreach ($documentCategories->take(4) as $category)
                                    <li>
                                        <a href="{{ route('document.category', $category->slug) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <a href="#">How it works</a>
                                </li>
                                <li>
                                    <a href="#">Privacy policy</a>
                                </li>
                                <li>
                                    <a href="#">Terms of service</a>
                                </li>
                                <li>
                                    <a href="#">Refund policy</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="ud-widget">
                        <h5 class="ud-widget-title">Kategori Artikel</h5>
                        <ul class="ud-widget-links">
                            @if ($postCategories->isNotEmpty())
                                @foreach ($postCategories->take(4) as $category)
                                    <li>
                                        <a href="{{ route('posts.byCategory', $category->slug) }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <a href="#" rel="nofollow noopner" target="_blank">Lineicons
                                    </a>
                                </li>
                                <li>
                                    <a href="#" rel="nofollow noopner" target="_blank">Ecommerce
                                        HTML</a>
                                </li>
                                <li>
                                    <a href="#" rel="nofollow noopner" target="_blank">Ayro UI</a>
                                </li>
                                <li>
                                    <a href="#" rel="nofollow noopner" target="_blank">Plain
                                        Admin</a>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="ud-footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="ud-footer-bottom-right">
                        Designed and Developed by
                        <a href="https://www.instagram.com/bimabtw_?igsh=czhkOW92M21zYmY1" target="_blank"
                            rel="nofollow">bimabtw_</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- ====== Footer End ====== -->
