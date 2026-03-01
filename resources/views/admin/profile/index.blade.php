<x-admin.layout title="{{ $title }}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center mb-3">Pengaturan Profil</h4>

                    <!-- Tab Navigasi -->
                    <ul class="nav nav-pills mt-4">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#Informasi">
                                <span class="p-tab-name">Informasi Profil</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#EditProfil">
                                <span class="p-tab-name">Edit Profil</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Konten Tab -->
                    <div class="tab-content mt-3">
                        <!-- 🧾 Tab Informasi Profil -->
                        <div class="tab-pane fade show active" id="Informasi">
                            <div class="card border-0 shadow-sm radius-15">
                                <div class="card-body d-flex align-items-center">
                                    <div class="me-4">
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                                                class="rounded-circle border" width="120" height="120"
                                                style="object-fit: cover;">
                                        @else
                                            <img src="{{ asset('assets_admin/images/default-profile.png') }}" alt="Default Avatar"
                                                class="rounded-circle border" width="120" height="120"
                                                style="object-fit: cover;">
                                        @endif
                                    </div>
                                    <div>
                                        <h5 class="mb-1">{{ $user->name }}</h5>
                                        <p class="mb-1 text-muted">Username: <strong>{{ $user->username }}</strong></p>
                                        <p class="mb-1 text-muted">Role:
                                            <span
                                                class="badge bg-{{ $user->role === 'superadmin' ? 'primary' : 'secondary' }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </p>
                                        <p class="mb-0 text-muted">Bergabung sejak:
                                            {{ $user->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="EditProfil">
                            <div class="card border-0 shadow-sm radius-15">
                                <div class="card-body">
                                    <h5 class="mb-3">Edit Profil</h5>

                                    <form action="{{ route('profile.update', $user->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- Nama -->
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama Lengkap</label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control @error('name') is-invalid @enderror"
                                                        value="{{ old('name', $user->name) }}">
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Username -->
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" name="username" id="username"
                                                        class="form-control @error('username') is-invalid @enderror"
                                                        value="{{ old('username', $user->username) }}">
                                                    @error('username')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- Password Lama -->
                                                <div class="mb-3">
                                                    <label for="password_current" class="form-label">Password
                                                        Lama</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password_current"
                                                            id="password_current"
                                                            class="form-control @error('password_current') is-invalid @enderror"
                                                            placeholder="Masukkan password lama jika ingin mengubah">
                                                        <button class="btn btn-outline-secondary togglePassword"
                                                            type="button">
                                                            <i class="ri-eye-close-line"></i>
                                                        </button>
                                                        @error('password_current')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Password Baru -->
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password Baru</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password" id="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            placeholder="Masukkan password baru (opsional)">
                                                        <button class="btn btn-outline-secondary togglePassword"
                                                            type="button">
                                                            <i class="ri-eye-close-line"></i>
                                                        </button>
                                                        @error('password')
                                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Konfirmasi Password -->
                                                <div class="mb-3">
                                                    <label for="password_confirmation" class="form-label">Konfirmasi
                                                        Password
                                                        Baru</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password_confirmation"
                                                            id="password_confirmation" class="form-control"
                                                            placeholder="Ulangi password baru">
                                                        <button class="btn btn-outline-secondary togglePassword"
                                                            type="button">
                                                            <i class="ri-eye-close-line"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <!-- Avatar -->
                                                <label for="avatar" class="form-label">Foto Profil</label>
                                                <div class="mb-3">
                                                    @if ($user->avatar)
                                                        <img id="previewAvatar"
                                                            src="{{ asset('storage/' . $user->avatar) }}"
                                                            alt="Preview Gambar" class="img-thumbnail mb-2"
                                                            width="200">
                                                    @else
                                                        <img id="previewAvatar" src="" alt="Preview Gambar"
                                                            class="img-thumbnail mb-2" width="200">
                                                    @endif
                                                    <small id="imgFileInfoAvatar" class="text-muted mb-2"
                                                        style="font-size:13px; display:none;"></small>
                                                    <input type="file" name="avatar" class="form-control"
                                                        data-preview="previewAvatar" data-info="imgFileInfoAvatar"
                                                        accept="image/*">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end mt-3">
                                            <button type="submit" class="btn btn-primary px-4">
                                                <i class="bx bx-save"></i> Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButtons = document.querySelectorAll('.togglePassword');

        toggleButtons.forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling; // ambil input sebelum tombol
                const icon = this.querySelector('i');

                if (input.getAttribute('type') === 'password') {
                    input.setAttribute('type', 'text');
                    icon.classList.remove('ri-eye-close-line');
                    icon.classList.add('ri-eye-line');
                } else {
                    input.setAttribute('type', 'password');
                    icon.classList.remove('ri-eye-line');
                    icon.classList.add('ri-eye-close-line');
                }
            });
        });
    });
</script>
