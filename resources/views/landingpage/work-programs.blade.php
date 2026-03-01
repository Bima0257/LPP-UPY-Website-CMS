<x-landingpage.layout title="{{ $title }}">

    <section class="ud-page-banner"
        style="background-image: url('{{ !empty($banner) && !empty($banner->banner_background)
            ? asset('storage/' . $banner->banner_background)
            : asset('assets/images/background/background-default.jpg') }}');">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="ud-banner-content">
                    <h1>Program Kerja</h1>
                </div>
            </div>
        </div>
        <!-- end page title -->
        </div>
    </section>

    <section id="about" class="ud-about">
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
                <div class="timeline">
                    @php
                        $currentYear = null;
                        $currentMonth = null;
                    @endphp

                    @foreach ($programs as $program)
                        @php
                            $year = \Carbon\Carbon::parse($program->tgl_pelaksanaan)->format('Y');
                            $month = \Carbon\Carbon::parse($program->tgl_pelaksanaan)->translatedFormat('F');
                            $date = \Carbon\Carbon::parse($program->tgl_pelaksanaan)->format('d M');
                        @endphp

                        {{-- === Tampilkan Tahun === --}}
                        @if ($currentYear !== $year)
                            <div class="timeline-year">
                                <span>{{ $year }}</span>
                            </div>
                            @php
                                $currentYear = $year;
                                $currentMonth = null; // reset bulan saat tahun berubah
                            @endphp
                        @endif

                        {{-- === Tampilkan Bulan === --}}
                        @if ($currentMonth !== $month)
                            <div class="timeline-month">
                                <span>{{ $month }}</span>
                            </div>
                            @php $currentMonth = $month; @endphp
                        @endif

                        {{-- === Timeline Item === --}}
                        <div class="timeline-item">
                            <div class="timeline-box">
                                <div class="timeline-date">{{ $date }}</div>
                                <h5 class="fw-bold mb-2">{{ $program->name }}</h5>
                                <p class="text-muted mb-0">
                                    Kegiatan ini dijadwalkan pada tanggal
                                    {{ \Carbon\Carbon::parse($program->tgl_pelaksanaan)->translatedFormat('d F Y') }}.
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

</x-landingpage.layout>
