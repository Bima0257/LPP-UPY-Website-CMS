<x-admin.layout title="{{ $title }}">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title text-center">Data Kategori Posts</h4>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3 btn-add-category" data-bs-toggle="modal"
                        data-bs-target="#modal">
                        Tambah Kategori
                    </button>

                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="ri-drag-move-line me-2"></i>
                        <div>
                            Untuk <strong>mengubah urutan kategori</strong>,arahkan mouse ke kolom Drag & Drop lalu
                            seret (drag) dan lepaskan (drop) baris ke posisi yang diinginkan.
                        </div>
                    </div>

                    <table id="categoriesTable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Drag & Drop</th>
                                <th>Urutan</th>
                                <th>Nama Kategori</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($categories->sortBy('sort_order') as $category)
                                <tr data-id="{{ $category->id }}">
                                    <td class="drag-handle" style="cursor: grab;">
                                        <i class="ri-drag-move-line text-primary"></i> <!-- Icon drag -->
                                    </td>
                                    <td>{{ $category->sort_order }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @if ($category->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center flex-wrap gap-2">

                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-success btn-edit-category d-flex "
                                                data-bs-toggle="modal" data-bs-target="#modal"
                                                data-id="{{ $category->id }}">
                                                <i class='ri-edit-box-line'></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="/posts-categories/{{ $category->id }}" method="POST"
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
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('posts-categories.store') }}" id="documentCategoryForm" method="POST">
                        @csrf
                        <div class="row">
                            {{-- Nama Kategori --}}
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Nama Kategori</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Masukkan nama kategori" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Status Publikasi --}}
                        <div class="mb-3">
                            <label for="is_published" class="col-form-label">Status Publikasi</label>
                            <select name="is_published" id="is_published"
                                class="form-select @error('is_published') is-invalid @enderror" required>
                                <option value="1" {{ old('is_published') == '1' ? 'selected' : '' }}>Publik
                                </option>
                                <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>Draft
                                </option>
                            </select>
                            @error('is_published')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-light waves-effect"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Simpan</button>
                        </div>
                    </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div><!-- /.modal -->



</x-admin.layout>

<script>
    initTiny('#description');

    $(document).ready(function() {
        // Inisialisasi DataTable dengan Row Reorder
        const table = $('#categoriesTable').DataTable({
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
        $('#categoriesTable tbody')
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
            $('#categoriesTable tbody tr').each(function(index) {
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
                console.error('Tidak ada data kategori yang valid');
                return;
            }

            // Set flag untuk prevent duplicate requests
            isReordering = true;

            // Kirim urutan baru ke server via AJAX
            $.ajax({
                url: "{{ route('posts-categories.reorder') }}",
                method: "POST",
                data: {
                    order: order,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Menyimpan...',
                        text: 'Urutan kategori sedang diperbarui',
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
                            text: 'Urutan kategori berhasil diperbarui',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // ✅ Update visual order number jika ada
                        $('#categoriesTable tbody tr').each(function(index) {
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
        $('#modal').on('hidden.bs.modal', function() {
            const $form = $(this).find('form')[0];
            $form.reset();
            $('#categoryForm input[name="_method"]').remove();
            $('#myModalLabel').text('Tambah Kategori');
            $('#categoryForm').attr('action', '/posts-categories');
        });

        // Tambah Kategori
        $(document).on('click', '.btn-add-category', function() {
            $('#myModalLabel').text('Tambah Kategori');
            $('#modal').modal('show');
        });

        // Edit Kategori
        $(document).on('click', '.btn-edit-category', function() {
            const id = $(this).data('id');
            const $form = $('#documentCategoryForm');

            $('#myModalLabel').text('Edit Kategori');

            if (!$('#categoryForm input[name="_method"]').length) {
                $form.append('<input type="hidden" name="_method" value="PUT">');
            }

            $form.attr('action', '/posts-categories/' + id);

            $.ajax({
                url: '/posts-categories/' + id + '/edit',
                type: 'GET',
                success: function(data) {
                    $('#name').val(data.name);
                    $('#is_published').val(data.is_published);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal memuat data kategori.');
                }
            });
        });

    });
</script>
