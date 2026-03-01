<x-admin.layout title="{{ $title }}">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title text-center">Data Dokumen</h4>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3 btn-add-document" data-bs-toggle="modal"
                        data-bs-target="#modal">
                        Tambah Dokumen
                    </button>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Dokumen</th>
                                <th>Kategori</th>
                                <th>Upload By</th>
                                <th>Tipe File</th>
                                <th>Status</th>
                                <th>Proteksi</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($documents as $document)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $document->title }}</td>
                                    <td>{{ $document->category->name ?? '-' }}</td>
                                    <td>{{ $document->author->name ?? '-' }}</td>
                                    <td>{{ $document->file_extension }}</td>
                                    <td>
                                        @if ($document->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($document->is_protected)
                                            <span class="badge bg-warning">Protected</span>
                                        @else
                                            <span class="badge bg-info">Public</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center flex-wrap gap-2">

                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-success btn-edit-document d-flex "
                                                data-bs-toggle="modal" data-bs-target="#modal"
                                                data-id="{{ $document->id }}">
                                                <i class='ri-edit-box-line'></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="/documents-management/{{ $document->id }}" method="POST"
                                                class="m-0 delete-btn">
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

                    <form action="{{ route('documents-management.store') }}" id="documentForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">

                                {{-- Judul Dokumen --}}
                                <div class="mb-3">
                                    <label for="title" class="col-form-label">Judul Dokumen</label>
                                    <input type="text" name="title" id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        placeholder="Masukkan judul dokumen" value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Kategori Dokumen --}}
                                <div class="mb-3">
                                    <label for="category_id" class="col-form-label">Kategori</label>
                                    <select name="category_id" id="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror">
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Proteksi Dokumen --}}
                                <div class="mb-3">
                                    <label for="is_protected" class="col-form-label">Proteksi Dokumen</label>
                                    <select name="is_protected" id="is_protected"
                                        class="form-select @error('is_protected') is-invalid @enderror"
                                        onchange="togglePasswordField()">
                                        <option value="0" {{ old('is_protected') == '0' ? 'selected' : '' }}>
                                            Tidak
                                        </option>
                                        <option value="1" {{ old('is_protected') == '1' ? 'selected' : '' }}>Ya
                                        </option>
                                    </select>
                                    @error('is_protected')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="col-md-6">


                                {{-- Upload File --}}
                                <div class="mb-3">
                                    <label for="file_path" class="col-form-label">Upload File</label>

                                    <!-- Preview dokumen lama -->
                                    <a id="fileNameText" class="form-control-plaintext text-primary mb-2"
                                        style="display:none; cursor:pointer; word-wrap: break-word; word-break: break-word; white-space: normal; overflow-wrap: break-word;">
                                    </a>

                                    <input type="file" name="file_path" id="file_path"
                                        class="form-control @error('file_path') is-invalid @enderror"
                                        accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar">
                                    <small class="text-muted">Format: PDF, DOCX, XLSX, PPTX, ZIP, max 10MB</small>
                                    @error('file_path')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                                {{-- Password Akses (muncul jika is_protected = true) --}}
                                <div class="mb-3" id="passwordWrapper" style="display:none;">
                                    <label for="access_password" class="col-form-label">Password Akses</label>
                                    <div class="input-group">
                                        <input type="password" name="access_password" id="access_password"
                                            class="form-control @error('access_password') is-invalid @enderror"
                                            placeholder="Masukkan password dokumen">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="ri-eye-close-line"></i>
                                        </button>
                                        @error('access_password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-3">
                                <label for="description" class="col-form-label">Deskripsi</label>
                                <textarea name="description" id="description" rows="4"
                                    class="form-control @error('description') is-invalid @enderror" placeholder="Masukkan deskripsi singkat">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            {{-- Status Publikasi --}}
                            <div class="mb-3">
                                <label for="is_published" class="col-form-label">Status Publikasi</label>
                                <select name="is_published" id="is_published"
                                    class="form-select @error('is_published') is-invalid @enderror">
                                    <option value="1" {{ old('is_published') == '1' ? 'selected' : '' }}>
                                        Published</option>
                                    <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>
                                        Draft
                                    </option>
                                </select>
                                @error('is_published')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
    initTiny('#description');

    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('access_password');

        // 🔁 Toggle show/hide password
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Ganti ikon mata
            this.innerHTML = type === 'password' ?
                '<i class="ri-eye-line"></i>' :
                '<i class="ri-eye-close-line"></i>';
        });

        // 🎯 Reset kondisi saat modal dibuka
        const modal = document.getElementById('modal');
        modal.addEventListener('show.bs.modal', function() {
            // Pastikan input dalam kondisi tersembunyi
            passwordInput.setAttribute('type', 'password');
            togglePassword.innerHTML = '<i class="ri-eye-line"></i>';
        });
    });

    // Tampilkan kolom password hanya jika dokumen dilindungi
    function togglePasswordField() {
        const select = document.getElementById('is_protected');
        const wrapper = document.getElementById('passwordWrapper');
        wrapper.style.display = (select.value == '1') ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', togglePasswordField);

    $(document).ready(function() {

        // Reset modal saat ditutup
        $('#modal').on('hidden.bs.modal', function() {
            const $form = $(this).find('form')[0];
            $form.reset();

            // Hapus input _method (PUT) jika ada
            $('#documentForm input[name="_method"]').remove();

            // Reset teks header & action form
            $('#myModalLabel').text('Tambah Dokumen');
            $('#documentForm').attr('action', '/documents-management');
            if (tinymce.get('description')) {
                tinymce.get('description').setContent('');
            }

            // Reset tampilan proteksi & password akses
            $('#is_protected').val('0');
            $('#passwordWrapper').hide();
            $('#access_password').val('');

            // Reset input file
            $('#file_path').val('');
            // Hapus preview lama
            $('#fileNameText').hide().empty();
        });

        // Tombol Tambah Dokumen
        $(document).on('click', '.btn-add-document', function() {
            $('#myModalLabel').text('Tambah Dokumen');
            $('#modal').modal('show');
        });

        // Tombol Edit Dokumen
        $(document).on('click', '.btn-edit-document', function() {
            const id = $(this).data('id');
            const $form = $('#documentForm');

            $('#myModalLabel').text('Edit Dokumen');

            // Tambahkan method PUT jika belum ada
            if (!$('#documentForm input[name="_method"]').length) {
                $form.append('<input type="hidden" name="_method" value="PUT">');
            }

            // Ubah action form
            $form.attr('action', '/documents-management/' + id);

            // Ambil data dokumen via AJAX
            $.ajax({
                url: '/documents-management/' + id + '/edit',
                type: 'GET',
                success: function(data) {
                    // Isi form dengan data dokumen
                    $('#title').val(data.title);
                    $('#category_id').val(data.category_id);
                    if (tinymce.get('description')) {
                        tinymce.get('description').setContent(data.description || '');
                    }
                    $('#is_published').val(data.is_published ? '1' : '0');
                    $('#is_protected').val(data.is_protected ? '1' : '0');

                    // 🔐 Atur password akses
                    if (data.is_protected) {
                        $('#passwordWrapper').show();
                        $('#access_password').val('');
                    } else {
                        $('#passwordWrapper').hide();
                        $('#access_password').val('');
                    }

                    // Jika ada file lama, tampilkan link-nya
                    if (data.file_path) {
                        const fileName = data.file_path.split('/').pop();
                        $('#fileNameText')
                            .html(
                                `<a href="/storage/${data.file_path}" id="previewOldFile" class="text-decoration-none">
                            ${fileName}
                        </a>`
                            )
                            .show();
                    } else {
                        $('#fileNameText').text('Tidak ada file').show();
                    }

                    // Reset file input (jangan menampilkan file lama di input)
                    $('#file_path').val('');

                    $('#modal').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal memuat data dokumen.');
                }
            });
        });
        // Jika user memilih file baru → hapus semua preview lama
        $('#file_path').on('change', function() {
            const fileName = $(this).val().split('\\').pop();

            if (fileName) {
                // Hapus seluruh isi elemen (termasuk tag <a> dan teks lama)
                $('#fileNameText').empty().hide();
            }
        });


        // 🔁 Saat proteksi berubah
        $(document).on('change', '#is_protected', function() {
            if ($(this).val() == '1') {
                $('#passwordWrapper').slideDown(200);
                const saved = $form.data('saved-password') || '';
                $('#access_password').val(saved);
            } else {
                $('#passwordWrapper').slideUp(200);
                // simpan dulu nilai terakhir sebelum dikosongkan
                const current = $('#access_password').val();
                if (current) $form.data('saved-password', current);
                $('#access_password').val('');
            }
        });
    });
</script>
