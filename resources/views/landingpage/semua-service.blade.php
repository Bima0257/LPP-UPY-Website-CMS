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
                        <h1>Semua Layanan</h1>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- ====== Banner End ====== -->


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
        </div>
    </section>
    <!-- ====== Service End ====== -->




</x-landingpage.layout>
