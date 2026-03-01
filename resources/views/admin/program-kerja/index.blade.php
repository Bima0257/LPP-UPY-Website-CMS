<x-admin.layout title="{{ $title }}">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title text-center">Data Program Kerja</h4>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3 btn-add-proker" data-bs-toggle="modal"
                        data-bs-target="#modal">
                        Tambah Program Kerja
                    </button>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Program</th>
                                <th>Tanggal Pelaksanaan</th>
                                <th>Status</th>
                                <th>Dibuat Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($workPrograms as $proker)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $proker->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($proker->tgl_pelaksanaan)->format('d M Y') }}</td>
                                    <td>
                                        @if ($proker->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $proker->author->name ?? '-' }}</td>
                                    <td>
                                        <div class="d-flex align-items-center flex-wrap gap-2">

                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-success btn-edit-proker d-flex"
                                                data-bs-toggle="modal" data-bs-target="#modal"
                                                data-id="{{ $proker->id }}">
                                                <i class='ri-edit-box-line'></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('work-programs.destroy', $proker->id) }}"
                                                method="POST" class="m-0">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" class="btn btn-danger delete-btn">
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
                    <h5 class="modal-title" id="myModalLabel">Tambah Program Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('work-programs.store') }}" id="workProgramForm" method="POST">
                        @csrf
                        <div class="row">
                            {{-- Nama Program --}}
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Nama Program</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Masukkan nama program kerja" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Pelaksanaan --}}
                            <div class="mb-3">
                                <label for="tgl_pelaksanaan" class="col-form-label">Tanggal Pelaksanaan</label>
                                <input type="date" name="tgl_pelaksanaan" id="tgl_pelaksanaan"
                                    class="form-control @error('tgl_pelaksanaan') is-invalid @enderror"
                                    value="{{ old('tgl_pelaksanaan') }}" required>
                                @error('tgl_pelaksanaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Status Publikasi --}}
                            <div class="mb-3">
                                <label for="is_published" class="col-form-label">Status Publikasi</label>
                                <select name="is_published" id="is_published"
                                    class="form-select @error('is_published') is-invalid @enderror" required>
                                    <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>Draft
                                    </option>
                                    <option value="1" {{ old('is_published') == '1' ? 'selected' : '' }}>Published
                                    </option>
                                </select>
                                @error('is_published')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>

                </div><!-- /.modal-body -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</x-admin.layout>

<script>
    $(document).ready(function() {

        // Reset modal setiap ditutup
        $('#modal').on('hidden.bs.modal', function() {
            const $form = $('#workProgramForm');
            $form.trigger('reset');
            $form.find('input[name="_method"]').remove();
            $('#myModalLabel').text('Tambah Program Kerja');
            $form.attr('action', '{{ route('work-programs.store') }}');
        });

        // Tambah Proker
        $('.btn-add-proker').click(function() {
            $('#myModalLabel').text('Tambah Program Kerja');
            $('#modal').modal('show');
        });

        // Edit Proker
        $('.btn-edit-proker').click(function() {
            const id = $(this).data('id');
            const $form = $('#workProgramForm');
            $('#myModalLabel').text('Edit Program Kerja');

            if (!$form.find('input[name="_method"]').length) {
                $form.append('<input type="hidden" name="_method" value="PUT">');
            }

            $form.attr('action', '/work-programs/' + id);

            $.ajax({
                url: '/work-programs/' + id + '/edit',
                type: 'GET',
                success: function(data) {
                    $('#name').val(data.name);
                    $('#tgl_pelaksanaan').val(data.tgl_pelaksanaan);
                    $('#is_published').val(data.is_published);
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal memuat data program kerja.');
                }
            });
        });

    });
</script>
