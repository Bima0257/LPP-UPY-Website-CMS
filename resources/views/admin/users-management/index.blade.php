<x-admin.layout title="{{ $title }}">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title text-center">Data Akun Pengguna</h4>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3 btn-add-user" data-bs-toggle="modal"
                        data-bs-target="#modal">
                        Tambah User
                    </button>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Username</th>
                                <th>Avatar</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        <img src="{{ $user?->avatar ? asset('storage/' . $user->avatar) : asset('assets_admin/images/default-profile.png') }}"
                                            alt="user-img" width="50" height="50"
                                            style="object-fit: cover; border-radius: 50%; box-shadow: 0 0 5px rgba(0,0,0,0.2);">
                                    </td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <div class="d-flex align-items-center flex-wrap gap-2">

                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-success btn-edit-user d-flex "
                                                data-bs-toggle="modal" data-bs-target="#modal"
                                                data-id="{{ $user->id }}">
                                                <i class='ri-edit-box-line'></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="/users-management/{{ $user->id }}" method="POST">
                                                @method('delete')
                                                @csrf
                                                <button type="button" class="btn btn-danger d-flex delete-btn">
                                                    <i class='ri-delete-bin-7-line'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row-->


    <!-- modal content -->
    <div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('users-management.store') }}" id="userForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                {{-- Name --}}
                                <div class="mb-3">
                                    <label for="name" class="col-sm-4 col-form-label">Name</label>
                                    <div class="input-group">
                                        <input type="text" name="name" id="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Masukkan name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Username --}}
                                <div class="mb-3">
                                    <label for="username" class="col-sm-4 col-form-label">Username</label>
                                    <div class="input-group">
                                        <input type="text" name="username" id="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            placeholder="Masukkan username" value="{{ old('username') }}" required>
                                        @error('username')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="mb-3">
                                    <label for="password" class="col-sm-4 col-form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Masukkan password" required>
                                        <button class="btn btn-outline-secondary togglePassword" type="button">
                                            <i class="ri-eye-close-line"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div class="mb-3">
                                    <label for="confirm_password" class="col-sm-4 col-form-label">Confirm
                                        Password</label>
                                    <div class="input-group">
                                        <input type="password" name="confirm_password" id="confirm_password"
                                            class="form-control @error('confirm_password') is-invalid @enderror"
                                            placeholder="Masukkan Confirm Password" required>
                                        <button class="btn btn-outline-secondary togglePassword" type="button">
                                            <i class="ri-eye-close-line"></i>
                                        </button>
                                        @error('confirm_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                {{-- Role --}}
                                <div class="mb-3">
                                    <label for="role" class="col-sm-4 col-form-label">Role</label>
                                    <div class="input-group">
                                        <select name="role" id="role"
                                            class="form-select @error('role') is-invalid @enderror" required>
                                            <option value="">-- Pilih Role --</option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                                Admin
                                            </option>
                                            <option value="superadmin"
                                                {{ old('role') == 'superadmin' ? 'selected' : '' }}>
                                                Super Admin</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Avatar --}}
                                <div class="mb-3">
                                    <label for="avatar" class="col-sm-4 col-form-label">Avatar</label>
                                    <div>
                                        <!-- Tempat Preview -->
                                        <img id="preview" src="" alt="Preview Gambar"
                                            class="img-thumbnail mb-2" width="150" height="150"
                                            style="display:none;">

                                        <small id="fileSizeInfo" class="mb-2"
                                            style="display:none; color:gray; font-size:13px;"></small>

                                        <!-- Input File -->
                                        <input type="file" name="avatar" id="avatar" class="form-control"
                                            accept="image/*"
                                            onchange="previewImage(event, 'preview', 'fileSizeInfo', window.defaultAvatar)">
                                        <!-- Info ukuran -->
                                        <small class="text-danger">Upload foto profil (jpg, png, max 1MB).</small>
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light waves-effect"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                        </div>
                    </form>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


</x-admin.layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 🔁 Toggle show/hide password untuk semua input
        document.querySelectorAll('.togglePassword').forEach(function(button) {
            button.addEventListener('click', function() {
                const input = this.closest('.input-group').querySelector(
                    'input[type="password"], input[type="text"]');
                const icon = this.querySelector('i');

                if (input.getAttribute('type') === 'password') {
                    input.setAttribute('type', 'text');
                    icon.classList.remove('ri-eye-line');
                    icon.classList.add('ri-eye-close-line');
                } else {
                    input.setAttribute('type', 'password');
                    icon.classList.remove('ri-eye-close-line');
                    icon.classList.add('ri-eye-line');
                }
            });
        });

        // 🎯 Reset semua input ke "hidden" saat modal dibuka
        const modal = document.getElementById('modal');
        modal.addEventListener('show.bs.modal', function() {
            document.querySelectorAll('.togglePassword').forEach(function(button) {
                const input = button.closest('.input-group').querySelector('input');
                const icon = button.querySelector('i');
                input.setAttribute('type', 'password');
                icon.classList.remove('ri-eye-close-line');
                icon.classList.add('ri-eye-line');
            });
        });
    });

    $(document).ready(function() {
        // Reset modal
        $('#modal').on('hidden.bs.modal', function() {
            const $form = $(this).find('form')[0];
            $form.reset();
            $('#preview').hide().attr('src', '');
            $('#userForm input[name="_method"]').remove();
            $('#myModalLabel').text('Tambah User');
            $('#userForm').attr('action', '/users-management');
            // ✅ PENTING: Set required untuk mode tambah
            $('#password').attr('required', true);
            $('#confirm_password').attr('required', true);

            // Reset default avatar
            window.defaultAvatar = null;
        });

        // Tambah User
        $(document).on('click', '.btn-add-user', function() {
            $('#modal').modal('show');

            // ✅ Pastikan password required
            $('#password').attr('required', true);
            $('#confirm_password').attr('required', true);
        });

        // Edit User
        $(document).on('click', '.btn-edit-user', function() {
            const id = $(this).data('id');
            const $form = $('#userForm');

            $('#myModalLabel').text('Edit User');
            $('.password-old').show();

            if (!$('#userForm input[name="_method"]').length) {
                $form.append('<input type="hidden" name="_method" value="PUT">');
            }

            $form.attr('action', '/users-management/' + id);

            $('#password').removeAttr('required');
            $('#confirm_password').removeAttr('required');

            $.ajax({
                url: '/users-management/' + id + '/edit',
                type: 'GET',
                success: function(data) {
                    $('#name').val(data.name);
                    $('#username').val(data.username);
                    $('#role').val(data.role);

                    if (data.avatar) {
                        const avatarUrl = '/storage/' + data.avatar;
                        $('#preview').attr('src', avatarUrl).show();
                        window.defaultAvatar = avatarUrl; // simpan sebagai default
                    } else {
                        $('#preview').hide();
                        window.defaultAvatar = null;
                    }

                    // Reset input file dan ukuran
                    $('#avatar').val('');
                    $('#fileSizeInfo').hide();

                    $('#modal').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal memuat data user.');
                }
            });
        });

    });
</script>
