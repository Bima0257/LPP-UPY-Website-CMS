<x-admin.layout title="{{ $title }}">

    <div class="row">
        <div class="col-12">
            <div class="card p-4">
                <h4 class="card-title text-center mb-4">Pengaturan Banner</h4>

                <div class="row g-4 justify-content-center">
                    {{-- Banner Background --}}
                    <div class="col-md-5">
                        <div class="card shadow-sm h-100">
                            <img src="{{ $banner->banner_background ? asset('storage/' . $banner->banner_background) : asset('assets/images/background/background-default.jpg') }}"
                                class="card-img-top rounded"
                                style="height: 220px; object-fit: cover; width: 100%; border-radius: .5rem;">
                            <div class="card-body text-center">
                                <h6 class="card-title mb-2">Banner Background</h6>
                                <button class="btn btn-success btn-edit-banner" data-id="{{ $banner->id }}"
                                    data-type="banner_background" data-bs-toggle="modal" data-bs-target="#modal">
                                    <i class="ri-edit-box-line me-1"></i> Ganti Gambar
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Background --}}
                    <div class="col-md-5">
                        <div class="card shadow-sm h-100">
                            <img src="{{ $banner->footer_background ? asset('storage/' . $banner->footer_background) : asset('assets/images/background/background-default.jpg') }}"
                                class="card-img-top rounded"
                                style="height: 220px; object-fit: cover; width: 100%; border-radius: .5rem;">
                            <div class="card-body text-center">
                                <h6 class="card-title mb-2">Footer Background</h6>
                                <button class="btn btn-success btn-edit-banner" data-id="{{ $banner->id }}"
                                    data-type="footer_background" data-bs-toggle="modal" data-bs-target="#modal">
                                    <i class="ri-edit-box-line me-1"></i> Ganti Gambar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Ganti Gambar Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="editBannerForm" method="POST" action="{{ route('banner.update', $banner->id) }}"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <input type="hidden" id="banner_id" value="{{ $banner->id }}">
                        <input type="hidden" id="field_type" name="field_type">

                        <div class="text-center mb-3">
                            <img id="preview" src="" alt="Preview" class="img-fluid rounded shadow-sm"
                                style="max-height: 200px; display:none;">
                        </div>


                        <div class="mb-3">
                            <label for="image" class="form-label">Pilih Gambar</label>
                            <input type="file" name="image" id="image" accept="image/*" class="form-control">
                            <small id="fileSize" class="text-muted mt-3 d-block"></small>
                            <small class="text-muted">Format: JPG, PNG, WEBP (max 5MB)</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-admin.layout>
<script>
    $(document).ready(function() {

        // Klik tombol edit
        $('.btn-edit-banner').click(function() {
            let fieldType = $(this).data('type');
            $('#field_type').val(fieldType);

            // Ubah name input file sesuai tipe (banner_background atau footer_background)
            $('#image').attr('name', fieldType);

            $('#image').val(''); // reset input file
            $('#preview').attr('src', '').hide(); // reset preview
            $('#fileSize').text(''); // reset size info
        });

        // Preview image dan tampilkan ukuran file
        $('#image').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    $('#preview').attr('src', ev.target.result).show();
                };
                reader.readAsDataURL(file);

                // tampilkan ukuran file
                const sizeInKB = (file.size / 1024).toFixed(2);
                const sizeText = sizeInKB > 1024 ?
                    (sizeInKB / 1024).toFixed(2) + ' MB' :
                    sizeInKB + ' KB';
                $('#fileSize').text(`Ukuran: ${sizeText}`);
            }
        });
    });
</script>
