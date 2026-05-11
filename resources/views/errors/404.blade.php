<x-landingpage.layout title="404 - Halaman Tidak Ditemukan">

    <section class="ud-404 d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="text-center">

                        <!-- Icon -->
                        <div class="mb-4">
                            <i class="ri-error-warning-line notfound-icon"></i>
                        </div>

                        <!-- 404 -->
                        <h1 class="notfound-code">404</h1>

                        <!-- Title -->
                        <h2 class="notfound-title">
                            Halaman Tidak Ditemukan
                        </h2>

                        <!-- Description -->
                        <p class="notfound-desc">
                            Maaf, halaman yang Anda cari tidak tersedia atau URL yang dimasukkan salah.
                        </p>

                        <!-- Buttons -->
                        <div class="d-flex flex-wrap justify-content-center gap-3 mt-4">

                            <a href="{{ url('/') }}" class="btn ud-main-btn px-4 py-2 rounded-pill">
                                Kembali ke Beranda
                            </a>

                            <button onclick="history.back()" class="btn ud-main-btn px-4 py-2 rounded-pill">
                                Halaman Sebelumnya
                            </button>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <style>
        .ud-404 {
            min-height: 100vh;
            padding: 120px 0 80px;
            background:
                radial-gradient(circle at top right,
                    rgba(74, 108, 247, 0.08),
                    transparent 30%),
                #fff;
        }

        .notfound-icon {
            font-size: 90px;
            color: var(--primary-color);
        }

        .notfound-code {
            font-size: 120px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 20px;
            color: var(--heading-color);
        }

        .notfound-title {
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 18px;
            color: var(--heading-color);
        }

        .notfound-desc {
            max-width: 620px;
            margin: auto;
            font-size: 18px;
            line-height: 32px;
            color: #6c757d;
        }

        @media (max-width: 767px) {

            .ud-404 {
                padding: 100px 20px 60px;
            }

            .notfound-icon {
                font-size: 70px;
            }

            .notfound-code {
                font-size: 80px;
            }

            .notfound-title {
                font-size: 28px;
            }

            .notfound-desc {
                font-size: 15px;
                line-height: 28px;
            }

            .ud-main-btn,
            .btn-outline-primary {
                width: 100%;
            }
        }
    </style>

</x-landingpage.layout>
