<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>{{ $title ?? 'Login | Admin-LPP' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon"
        href="{{ $about?->favicon ? asset('storage/' . $about->favicon) : asset('assets/images/logo/favicon.png') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets_admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets_admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets_admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body class="auth-body-bg">
    <div>
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-4">
                    <div class="authentication-page-content p-4 d-flex align-items-center min-vh-100">
                        <div class="w-100">
                            <div class="row justify-content-center">
                                <div class="col-lg-9">
                                    <div>
                                        <div class="text-center">
                                            <div>
                                                <div class="authentication-logo">
                                                    <img src="{{ $about?->black_logo ? asset('storage/' . $about->black_logo) : asset('assets/images/logo/black_logo.png') }}"
                                                        alt="" style="height: 70px; width: 200px;"
                                                        class="auth-logo logo-dark mx-auto">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="p-2">
                                            <!-- Alert Messages -->
                                            <div class="mb-3">
                                                @if (session()->has('success'))
                                                    <div class="alert alert-success alert-dismissible fade show text-center"
                                                        role="alert">
                                                        {{ session('success') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                @endif
                                                @if (session()->has('loginError'))
                                                    <div class="alert alert-danger alert-dismissible fade show text-center"
                                                        role="alert" id="loginErrorAlert">
                                                        {{ session('loginError') }}
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Countdown Alert -->
                                            <div class="alert alert-warning text-center" id="countdownAlert"
                                                style="display: none;">
                                                <i class="ri-time-line me-2"></i>
                                                <strong>Login diblokir!</strong> Silakan tunggu <span
                                                    id="countdownTimer" class="fw-bold">60</span> detik
                                            </div>

                                            <form class="" action="/authenticate" method="POST" id="loginForm">
                                                @csrf
                                                <div class="mb-3 auth-form-group-custom ">
                                                    <i class="ri-user-2-line auti-custom-input-icon"></i>
                                                    <label for="username" class="fw-semibold">Username</label>
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" placeholder="Enter username"
                                                        value="{{ old('username') }}" required>
                                                    @error('username')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="mb-3 position-relative auth-form-group-custom">
                                                    <i class="ri-lock-2-line auti-custom-input-icon"></i>
                                                    <label for="password" class="fw-semibold">Password</label>

                                                    <input type="password" class="form-control pe-5" id="password"
                                                        name="password" placeholder="Enter password" required>

                                                    <!-- Toggle button di dalam div dengan posisi absolute -->
                                                    <button
                                                        class="btn btn-link toggle-password-btn position-absolute top-50 end-0 translate-middle-y"
                                                        type="button" id="togglePassword"
                                                        style="margin-top: 5px; margin-right:10px; z-index: 10; border: none; background: transparent; padding: 0 12px;">
                                                        <i class="ri-eye-close-line" id="toggleIcon"></i>
                                                    </button>

                                                    @error('password')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>

                                                <div class="mt-4 text-center">
                                                    <button class="btn btn-primary w-md waves-effect waves-light"
                                                        type="submit" id="loginButton">Log In</button>
                                                </div>
                                            </form>
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p>©
                                                <script>
                                                    document.write(new Date().getFullYear())
                                                </script> Developed <i class="mdi mdi-copyright"></i> by
                                                <a href="https://www.instagram.com/bimabtw_?igsh=czhkOW92M21zYmY1"
                                                    target="_blank">bimabtw_</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="authentication-bg">
                        <div class="bg-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets_admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/node-waves/waves.min.js') }}"></script>

    <script src="{{ asset('assets_admin/js/app.js') }}"></script>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            if (type === 'text') {
                toggleIcon.classList.remove('ri-eye-close-line');
                toggleIcon.classList.add('ri-eye-line');
            } else {
                toggleIcon.classList.remove('ri-eye-line');
                toggleIcon.classList.add('ri-eye-close-line');
            }
        });

        // Rate Limit Countdown Handler
        const loginErrorAlert = document.getElementById('loginErrorAlert');
        const countdownAlert = document.getElementById('countdownAlert');
        const countdownTimer = document.getElementById('countdownTimer');
        const loginButton = document.getElementById('loginButton');
        const usernameInput = document.getElementById('username');
        const loginForm = document.getElementById('loginForm');

        // Cek apakah ada pesan error yang mengandung countdown
        if (loginErrorAlert) {
            const errorMessage = loginErrorAlert.textContent.trim();

            // Cek jika pesan mengandung informasi waktu tunggu
            const timeMatch = errorMessage.match(/(\d+)\s*detik/i);

            if (timeMatch) {
                const remainingSeconds = parseInt(timeMatch[1]);
                startCountdown(remainingSeconds);
            } else if (errorMessage.includes('Terlalu banyak') || errorMessage.includes('diblokir')) {
                // Jika tidak ada angka detik, cek di localStorage
                const blockedUntil = localStorage.getItem('loginBlockedUntil');
                if (blockedUntil) {
                    const remaining = Math.ceil((parseInt(blockedUntil) - Date.now()) / 1000);
                    if (remaining > 0) {
                        startCountdown(remaining);
                    } else {
                        localStorage.removeItem('loginBlockedUntil');
                    }
                } else {
                    // Default 60 detik jika tidak ada info
                    startCountdown(60);
                }
            }
        }

        // Cek localStorage saat page load
        window.addEventListener('load', function() {
            const blockedUntil = localStorage.getItem('loginBlockedUntil');
            if (blockedUntil) {
                const remaining = Math.ceil((parseInt(blockedUntil) - Date.now()) / 1000);
                if (remaining > 0) {
                    startCountdown(remaining);
                } else {
                    localStorage.removeItem('loginBlockedUntil');
                }
            }
        });

        function startCountdown(seconds) {
            // Sembunyikan alert error asli
            if (loginErrorAlert) {
                loginErrorAlert.style.display = 'none';
            }

            // Tampilkan countdown alert
            countdownAlert.style.display = 'block';
            countdownTimer.textContent = seconds;

            // Disable form
            disableForm();

            // Simpan waktu berakhir di localStorage
            const blockedUntil = Date.now() + (seconds * 1000);
            localStorage.setItem('loginBlockedUntil', blockedUntil);

            // Mulai countdown
            const interval = setInterval(function() {
                seconds--;
                countdownTimer.textContent = seconds;

                if (seconds <= 0) {
                    clearInterval(interval);
                    countdownAlert.style.display = 'none';
                    enableForm();
                    localStorage.removeItem('loginBlockedUntil');
                }
            }, 1000);
        }

        function disableForm() {
            loginButton.disabled = true;
            loginButton.innerHTML = '<i class="ri-lock-line me-1"></i> Diblokir';
            loginButton.classList.remove('btn-primary');
            loginButton.classList.add('btn-secondary');
            usernameInput.disabled = true;
            passwordInput.disabled = true;
            togglePassword.disabled = true;
        }

        function enableForm() {
            loginButton.disabled = false;
            loginButton.innerHTML = 'Log In';
            loginButton.classList.remove('btn-secondary');
            loginButton.classList.add('btn-primary');
            usernameInput.disabled = false;
            passwordInput.disabled = false;
            togglePassword.disabled = false;
        }
    </script>
</body>

</html>
