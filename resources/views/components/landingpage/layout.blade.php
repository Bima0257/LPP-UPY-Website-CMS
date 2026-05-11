@props(['title' => 'Web LPP'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{!! $title ?? 'Home' !!}</title>
    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon"
        href="{{ $about?->favicon ? asset('storage/' . $about->favicon) : asset('assets/images/logo/favicon.png') }}" />

    <!-- ===== All CSS files ===== -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/lineicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/ud-styles.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/custom-alert.css') }}">

    <!-- Icons Css -->
    <link href="{{ asset('assets_admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Sweet Alert-->
    <link href="{{ asset('assets_admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Di bagian <head> atau layout -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

</head>

<body>

    <x-landingpage.navbar></x-landingpage.navbar>
    {{ $slot }}
    <x-landingpage.footer></x-landingpage.footer>

    <!-- ====== Back To Top Start ====== -->
    <a href="javascript:void(0)" class="back-to-top">
        <i class="lni lni-chevron-up"> </i>
    </a>
    <!-- ====== Back To Top End ====== -->


    <!-- ====== All Javascript Files ====== -->
    <script src="{{ asset('assets_admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets_admin/libs/sweetalert2/sweetalert2.min.js') }}"></script>


    <!-- Di bagian scripts -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script>
        // ==== for menu scroll
        const pageLink = document.querySelectorAll(".ud-menu-scroll");

        pageLink.forEach((elem) => {
            elem.addEventListener("click", (e) => {
                const href = elem.getAttribute("href");

                if (!href || !href.includes("#")) {
                    return; // Biarkan navigasi normal
                }

                // Extract hash part
                const hash = href.substring(href.indexOf("#"));
                const target = document.querySelector(hash);

                // Cek apakah target element ada di halaman saat ini
                if (target) {
                    // Element ada → smooth scroll
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: "smooth",
                        block: "start",
                    });

                    // Update URL tanpa reload
                    if (history.pushState) {
                        history.pushState(null, null, hash);
                    }
                } else {
                    // Element tidak ada → biarkan navigasi normal ke halaman lain
                    // Browser akan otomatis redirect ke /#home
                    return;
                }
            });
        });

        // section menu active
        function onScroll(event) {
            const sections = document.querySelectorAll(".ud-menu-scroll");
            const scrollPos =
                window.pageYOffset ||
                document.documentElement.scrollTop ||
                document.body.scrollTop;

            for (let i = 0; i < sections.length; i++) {
                const currLink = sections[i];
                const val = currLink.getAttribute("href");

                if (!val || !val.includes("#")) {
                    continue;
                }

                const hash = val.substring(val.indexOf("#"));
                const refElement = document.querySelector(hash);

                if (!refElement) {
                    continue;
                }

                const scrollTopMinus = scrollPos + 73;
                if (
                    refElement.offsetTop <= scrollTopMinus &&
                    refElement.offsetTop + refElement.offsetHeight > scrollTopMinus
                ) {
                    sections.forEach(link => link.classList.remove("active"));
                    currLink.classList.add("active");
                } else {
                    currLink.classList.remove("active");
                }
            }
        }

        window.document.addEventListener("scroll", onScroll);

        // Smooth scroll saat halaman dimuat dengan hash di URL
        window.addEventListener("load", () => {
            const hash = window.location.hash;
            if (hash) {
                const target = document.querySelector(hash);
                if (target) {
                    // Delay sedikit untuk memastikan halaman sudah dimuat sempurna
                    setTimeout(() => {
                        target.scrollIntoView({
                            behavior: "smooth",
                            block: "start",
                        });
                    }, 100);
                }
            }
        });

        $(document).ready(function() {

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: `
                <div style="text-align:left;">
                    @foreach ($errors->all() as $error)
                        <p class="text-danger text-center">{{ $error }}</p>
                    @endforeach
                </div>
            `,
                    showConfirmButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Perbaiki',
                    backdrop: `
                rgba(0,0,0,0.4)
                url("/assets/images/alert/error-bg.gif")
                center top
                no-repeat
            `
                });
            @endif

            @if (session('success'))
                const messageId = 'success_message_{{ time() }}';
                if (!sessionStorage.getItem(messageId)) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#0d6efd',
                        confirmButtonText: 'OK',
                        timer: 4000,
                        timerProgressBar: true,
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        },
                        backdrop: `
                    rgba(0,0,0,0.3)
                    url("/assets/images/alert/confetti.gif")
                    center top
                    no-repeat
                `
                    });
                    sessionStorage.setItem(messageId, '1');
                }
            @endif

            @if (session('error'))
                const messageId = 'error_message_{{ time() }}';
                if (!sessionStorage.getItem(messageId)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: '{{ session('error') }}',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK',
                        showClass: {
                            popup: 'animate__animated animate__shakeX'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        },
                        backdrop: `
                    rgba(0,0,0,0.4)
                    url("/assets/images/alert/error-bg.gif")
                    center top
                    no-repeat
                `
                    });
                    sessionStorage.setItem(messageId, '1');
                }
            @endif

        });
    </script>


    @stack('scripts')

</body>

</html>
