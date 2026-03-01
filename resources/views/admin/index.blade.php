<x-admin.layout title="{{ $title }}">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Dashboard</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Konten Korsel</p>
                                    <h4 class="mb-0">{{ $carouselStats['total'] }}</h4>
                                </div>
                                <div class="text-primary ms-auto">
                                    <i class="ri-slideshow-3-fill font-size-24"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11">
                                    {{ $carouselStats['published'] }} </span>
                                <span class="text-muted ms-2">Publish</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Anggota</p>
                                    <h4 class="mb-0">{{ $memberTotal }}</h4>
                                </div>
                                <div class="text-primary ms-auto">
                                    <i class="ri-team-fill font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11"> {{ $memberTotal }}
                                </span>
                                <span class="text-muted ms-2">Total Anggota LPP</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Program Kerja</p>
                                    <h4 class="mb-0">{{ $prokerTotal }}</h4>
                                </div>
                                <div class="text-primary ms-auto">
                                    <i class="ri-briefcase-4-fill font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11"> {{ $prokerTotal }}
                                </span>
                                <span class="text-muted ms-2">Total Program Kerja</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Artikel</p>
                                    <h4 class="mb-0">{{ $postStats['total'] }}</h4>
                                </div>
                                <div class="text-primary ms-auto">
                                    <i class="ri-article-fill font-size-24"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11">
                                    {{ $postStats['published'] }} </span>
                                <span class="text-muted ms-2">Publish</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Dokumen</p>
                                    <h4 class="mb-0">{{ $documentStats['total'] }}</h4>
                                </div>
                                <div class="text-primary ms-auto">
                                    <i class="ri-file-fill font-size-24"></i>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="badge bg-success-subtle text-success  font-size-11">
                                    {{ $documentStats['published'] }} </span>
                                <span class="text-muted ms-2">Publish</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-1 overflow-hidden">
                                    <p class="text-truncate font-size-14 mb-2">Pesan Masuk</p>
                                    <h4 class="mb-0">{{ $messageStats['total'] }}</h4>
                                </div>
                                <div class="text-primary ms-auto">
                                    <i class="ri-message-fill font-size-24"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top py-3">
                            <div class="text-truncate">
                                <span class="badge bg-danger-subtle text-danger  font-size-11">
                                    {{ $messageStats['notRead'] }} </span>
                                <span class="text-muted ms-2">Belum Dibaca</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Dokumen</h4>

                    <div id="doc_chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title mb-4">Artikel</h4>

                    <div id="post_chart" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

</x-admin.layout>


<script>
    document.addEventListener("DOMContentLoaded", function() {

        /**
         * 🔧 Fungsi umum untuk membuat pie chart ApexCharts
         */
        function createPieChart(selector, seriesData, labelData, titleText, unitText) {
            // Cek apakah semua nilai 0
            const allZero = seriesData.every(v => v === 0);

            // Warna otomatis / abu-abu kalau kosong
            const colors = labelData.map((_, i) =>
                `hsl(${(i * 360 / labelData.length)}, 70%, 55%)`
            );

            // Tampilkan slice kecil untuk nilai 0
            const displaySeries = seriesData.map(v => v === 0 ? 0.05 : v);

            const options = {
                chart: {
                    type: 'pie',
                    height: 360
                },
                series: displaySeries,
                labels: labelData,
                colors: colors,
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toFixed(1) + '%';
                    },
                    style: {
                        fontSize: '14px'
                    }
                },
                title: {
                    text: titleText,
                    align: 'center'
                },
                tooltip: {
                    y: {
                        formatter: function(value, {
                            seriesIndex
                        }) {
                            const realVal = seriesData[seriesIndex];
                            return `${realVal} ${unitText}`;
                        }
                    }
                },
                noData: {
                    text: 'Tidak ada data untuk ditampilkan'
                }
            };

            const chart = new ApexCharts(document.querySelector(selector), options);
            chart.render();
        }

        // 📊 Chart Dokumen
        createPieChart(
            "#doc_chart",
            @json($totalDocuments),
            @json($documentCategories),
            "Total Dokumen Berdasarkan Kategori",
            "dokumen"
        );

        // 📰 Chart Artikel
        createPieChart(
            "#post_chart",
            @json($totalPosts),
            @json($postCategories),
            "Jumlah Artikel Berdasarkan Kategori",
            "artikel"
        );
    });
</script>
