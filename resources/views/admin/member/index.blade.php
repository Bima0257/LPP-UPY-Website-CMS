<x-admin.layout title="{{ $title }}">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title text-center">Data Anggota</h4>

                    <!-- Tombol Tambah Member -->
                    <button type="button" class="btn btn-primary mb-3 btn-add-member" data-bs-toggle="modal"
                        data-bs-target="#modalMember">
                        Tambah Member
                    </button>

                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="ri-drag-move-line me-2"></i>
                        <div>
                            Untuk <strong>mengubah urutan Anggota</strong>,arahkan mouse ke kolom Drag & Drop lalu
                            seret (drag) dan lepaskan (drop) baris ke posisi yang diinginkan.
                        </div>
                    </div>

                    <!-- Tabel Members -->
                    <table id="memberTable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Drag & Drop</th>
                                <th>Nama</th>
                                <th>Divisi</th>
                                <th>Foto</th>
                                <th>Instagram</th>
                                <th>LinkedIn</th>
                                <th>Facebook</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members->sortBy('sort_order') as $member)
                                <tr data-id="{{ $member->id }}">
                                    <td class="drag-handle" style="cursor: grab;">
                                        <i class="ri-drag-move-line text-primary"></i>
                                    </td>
                                    <td>{{ $member->nama }}</td>
                                    <td>{{ $member->divisi ?? '-' }}</td>
                                    <td>
                                        @if ($member->foto)
                                            <img src="{{ asset('storage/' . $member->foto) }}" alt="Foto"
                                                class="img-thumbnail" width="60">
                                        @else
                                            <span class="text-muted">Tidak ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($member->instagram_link)
                                            <a href="{{ $member->instagram_link }}" target="_blank">
                                                <i class="ri-instagram-line fs-5 text-danger"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($member->linkedin_link)
                                            <a href="{{ $member->linkedin_link }}" target="_blank">
                                                <i class="ri-linkedin-box-line fs-5 text-primary"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($member->facebook_link)
                                            <a href="{{ $member->facebook_link }}" target="_blank">
                                                <i class="ri-facebook-box-line fs-5 text-primary"></i>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center flex-wrap gap-2">
                                            <!-- Edit -->
                                            <button type="button" class="btn btn-success btn-edit-member"
                                                data-bs-toggle="modal" data-bs-target="#modalMember"
                                                data-id="{{ $member->id }}">
                                                <i class="ri-edit-box-line"></i>
                                            </button>

                                            <!-- Delete -->
                                            <form action="/members/{{ $member->id }}" method="POST"
                                                class="m-0 delete-btn">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger d-flex delete-btn">
                                                    <i class="ri-delete-bin-7-line"></i>
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
        </div>
    </div>

    <!-- Modal Member -->
    <div id="modalMember" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalMemberLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalMemberLabel">Tambah Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('members.store') }}" id="memberForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Nama -->
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" name="nama" id="nama"
                                        class="form-control @error('nama') is-invalid @enderror"
                                        placeholder="Masukkan nama member" value="{{ old('nama') }}" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Divisi -->
                                <div class="mb-3">
                                    <label for="divisi" class="form-label">Divisi</label>
                                    <input type="text" name="divisi" id="divisi"
                                        class="form-control @error('divisi') is-invalid @enderror"
                                        placeholder="Masukkan nama divisi" value="{{ old('divisi') }}">
                                    @error('divisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Foto -->
                                <label for="foto" class="form-label">Foto</label>
                                <div class="mb-3">
                                    <img id="previewFoto" src="" alt="Preview Foto" class="img-thumbnail mb-2"
                                        width="200" style="display:none;">
                                    <small id="imgFileInfoFoto" class="text-muted mb-2"
                                        style="font-size:13px; display:none;"></small>
                                    <input type="file" name="foto" id="foto"
                                        class="form-control @error('foto') is-invalid @enderror"
                                        data-preview="previewFoto" data-info="imgFileInfoFoto">
                                    @error('foto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">

                                <!-- Instagram -->
                                <div class="mb-3">
                                    <label for="instagram_link" class="form-label">Instagram</label>
                                    <input type="text" name="instagram_link" id="instagram_link"
                                        class="form-control @error('instagram_link') is-invalid @enderror"
                                        placeholder="https://instagram.com/username"
                                        value="{{ old('instagram_link') }}">
                                    @error('instagram_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- LinkedIn -->
                                <div class="mb-3">
                                    <label for="linkedin_link" class="form-label">LinkedIn</label>
                                    <input type="text" name="linkedin_link" id="linkedin_link"
                                        class="form-control @error('linkedin_link') is-invalid @enderror"
                                        placeholder="https://linkedin.com/in/username"
                                        value="{{ old('linkedin_link') }}">
                                    @error('linkedin_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Facebook -->
                                <div class="mb-3">
                                    <label for="facebook_link" class="form-label">Facebook</label>
                                    <input type="text" name="facebook_link" id="facebook_link"
                                        class="form-control @error('facebook_link') is-invalid @enderror"
                                        placeholder="https://facebook.com/username"
                                        value="{{ old('facebook_link') }}">
                                    @error('facebook_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
            </div>
        </div>
    </div>

</x-admin.layout>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTable dengan Row Reorder
        const table = $('#memberTable').DataTable({
            rowReorder: {
                selector: '.drag-handle', // ✅ Hanya icon ini yang bisa drag
                update: false,
                dataSrc: 'order'
            },
            paging: true,
            info: false,
            searching: false,
            ordering: false,
            columnDefs: [{
                targets: 0,
                visible: true,
                orderable: false
            }],
            // ✅ Tambahkan untuk mencegah conflict dengan row reorder
            autoWidth: false
        });

        // 💡 Hover effect dengan event delegation
        $('#memberTable tbody')
            .on('mouseenter', 'tr', function() {
                if (!$(this).hasClass('dt-rowReorder-moving')) {
                    $(this).addClass('table-primary');
                }
            })
            .on('mouseleave', 'tr', function() {
                $(this).removeClass('table-primary');
            });

        // 🎯 Event khusus DataTables Row Reorder untuk cursor
        table.on('row-reorder-start', function(e, details) {
            $('body').css('cursor', 'grabbing');
        });

        table.on('row-reorder-end', function(e, details) {
            $('body').css('cursor', 'default');
        });

        // 🎯 Event handler untuk row-reorder dengan debounce prevention
        let isReordering = false;

        table.on('row-reorder', function(e, diff, edit) {
            // ✅ Prevent multiple simultaneous requests
            if (isReordering) {
                console.log('Masih dalam proses reorder, menunggu...');
                return;
            }

            // ✅ Validasi apakah ada perubahan
            if (!diff || diff.length === 0) {
                console.log('Tidak ada perubahan urutan');
                return;
            }

            // ✅ Kumpulkan data urutan baru dengan validasi
            const order = [];
            $('#memberTable tbody tr').each(function(index) {
                const id = $(this).data('id');
                if (id) {
                    order.push({
                        id: id,
                        position: index + 1 // ✅ Posisi dimulai dari 1
                    });
                }
            });

            // ✅ Validasi data sebelum kirim
            if (order.length === 0) {
                console.error('Tidak ada data Member yang valid');
                return;
            }

            // Set flag untuk prevent duplicate requests
            isReordering = true;

            // Kirim urutan baru ke server via AJAX
            $.ajax({
                url: "{{ route('members.reorder') }}",
                method: "POST",
                data: {
                    order: order,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Urutan Member sedang diperbarui',
                        allowOutsideClick: false,
                        allowEscapeKey: false, // ✅ Prevent ESC key
                        allowEnterKey: false, // ✅ Prevent ENTER key
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Urutan Member berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // ✅ Update visual order number jika ada
                        $('#memberTable tbody tr').each(function(index) {
                            $(this).find('.order-number').text(index + 1);
                        });
                    } else {
                        // ✅ Rollback posisi jika gagal
                        table.draw(false);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: res.message ||
                                'Terjadi kesalahan saat menyimpan urutan',
                        });
                    }
                },
                error: function(xhr) {
                    // ✅ Rollback posisi jika error
                    table.draw(false);

                    let errorMessage = 'Koneksi ke server gagal!';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: errorMessage,
                    });
                },
                complete: function() {
                    // ✅ Reset flag setelah selesai
                    isReordering = false;
                }
            });
        });


        // Reset modal
        $('#modalMember').on('hidden.bs.modal', function() {
            const $form = $(this).find('form')[0];
            $form.reset();
            $('#memberForm input[name="_method"]').remove();
            $('#modalMemberLabel').text('Tambah Member');
            $('#memberForm').attr('action', '/members');
            $('#previewFoto').hide();
            $('#imgFileInfoFoto').hide();
        });

        // Tambah Member
        $(document).on('click', '.btn-add-member', function() {
            $('#modalMemberLabel').text('Tambah Member');
            $('#modalMember').modal('show');
        });

        // Edit Member
        $(document).on('click', '.btn-edit-member', function() {
            const id = $(this).data('id');
            const $form = $('#memberForm');

            $('#modalMemberLabel').text('Edit Member');
            if (!$('#memberForm input[name="_method"]').length) {
                $form.append('<input type="hidden" name="_method" value="PUT">');
            }

            $form.attr('action', '/members/' + id);

            $.ajax({
                url: '/members/' + id + '/edit',
                type: 'GET',
                success: function(data) {
                    $('#nama').val(data.nama);
                    $('#divisi').val(data.divisi ?? '');
                    $('#instagram_link').val(data.instagram_link ?? '');
                    $('#linkedin_link').val(data.linkedin_link ?? '');
                    $('#facebook_link').val(data.facebook_link ?? '');

                    if (data.foto) {
                        $('#previewFoto').attr('src', '/storage/' + data.foto).show();
                    } else {
                        $('#previewFoto').hide();
                    }

                    $('#modalMember').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal memuat data member.');
                }
            });
        });
    });
</script>
