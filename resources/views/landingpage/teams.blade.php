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
                        <h1>Struktur Organisasi</h1>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- ====== Banner End ====== -->

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
                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <p class="text-center">Belum ada anggota tim yang ditambahkan.</p>
                        </div>
                    </div>
                @endforelse


            </div>

        </div>
    </section>
    <!-- ====== Team End ====== -->

</x-landingpage.layout>
