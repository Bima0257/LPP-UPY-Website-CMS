<x-admin.layout title="{{ $title }}">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title text-center">Data Layanan</h4>

                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary mb-3 btn-add-service" data-bs-toggle="modal"
                        data-bs-target="#modal">
                        Tambah Layanan
                    </button>

                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Layanan</th>
                                <th>Deskripsi</th>
                                <th>Link</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $service->name }}</td>
                                    <td>{!! Str::words(strip_tags($service->description), 7, '...') !!}</td>
                                    <td>
                                        @if ($service->link)
                                            <a href="{{ filter_var($service?->link, FILTER_VALIDATE_URL) ? $service->link : '#' }}" target="_blank"
                                                class="text-decoration-none text-primary">
                                                {{ Str::limit($service->link, 30) }}
                                            </a>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center flex-wrap gap-2">

                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-success btn-edit-service d-flex"
                                                data-bs-toggle="modal" data-bs-target="#modal"
                                                data-id="{{ $service->id }}">
                                                <i class='ri-edit-box-line'></i>
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="/services/{{ $service->id }}" method="POST"
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
        </div>
    </div>

    <!-- Modal Tambah/Edit -->
    <div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Tambah Layanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('services.store') }}" id="serviceForm" method="POST">
                        @csrf
                        <div class="row">
                            {{-- Nama Layanan --}}
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Nama Layanan</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Masukkan name layanan" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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

                            {{-- Link --}}
                            <div class="mb-3">
                                <label for="link" class="col-form-label">Link</label>
                                <input type="string" name="link" id="link"
                                    class="form-control @error('link') is-invalid @enderror"
                                    placeholder="Masukkan link layanan" value="{{ old('link') }}" required>
                                @error('link')
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
            </div>
        </div>
    </div>

</x-admin.layout>

<script>
    tinymce.init({
        selector: '#description',
        menubar: false,
        plugins: 'wordcount',
        branding: false,
        statusbar: false,
        forced_root_block: '', // agar tidak auto-wrap dengan <p>
        valid_elements: 'strong,em,span,b,i,u', // hanya izinkan tag dasar teks
        invalid_elements: 'img,table,a,video,audio,iframe,div',
        placeholder: 'Masukkan deskripsi singkat...',
    });

    $(document).ready(function() {
        // Reset modal setiap kali ditutup
        $('#modal').on('hidden.bs.modal', function() {
            const $form = $(this).find('form')[0];
            $form.reset();
            $('#serviceForm input[name="_method"]').remove();
            $('#myModalLabel').text('Tambah Layanan');
            $('#serviceForm').attr('action', '/services');
            // Kosongkan TinyMCE juga
            if (tinymce.get('description')) {
                tinymce.get('description').setContent('');
            }
        });

        // Tambah layanan
        $(document).on('click', '.btn-add-service', function() {
            $('#myModalLabel').text('Tambah Layanan');
            $('#modal').modal('show');
        });

        // Edit layanan
        $(document).on('click', '.btn-edit-service', function() {
            const id = $(this).data('id');
            const $form = $('#serviceForm');

            $('#myModalLabel').text('Edit Layanan');

            if (!$('#serviceForm input[name="_method"]').length) {
                $form.append('<input type="hidden" name="_method" value="PUT">');
            }

            $form.attr('action', '/services/' + id);

            $.ajax({
                url: '/services/' + id + '/edit',
                type: 'GET',
                success: function(data) {
                    $('#name').val(data.name);
                    $('#link').val(data.link ?? '');
                    if (tinymce.get('description')) {
                        tinymce.get('description').setContent(data.description || '');
                    }
                    $('#modal').modal('show');
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    alert('Gagal memuat data layanan.');
                }
            });
        });
    });
</script>
