<x-admin.layout title="{{ $title }}">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title text-center">Data Carousel</h4>

                    <!-- Button trigger modal -->
                    <a href="{{ route('carousels-management.create') }}" class="btn btn-primary mb-3 ">
                        Tambah Carousel
                    </a>

                    <div class="alert alert-info d-flex align-items-center" role="alert">
                        <i class="ri-drag-move-line me-2"></i>
                        <div>
                            Untuk <strong>mengubah urutan carousel</strong>,arahkan mouse ke kolom Drag & Drop lalu
                            seret (drag) dan lepaskan (drop) baris ke posisi yang diinginkan.
                        </div>
                    </div>

                    <table id="carouselTable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>Drag & Drop</th>
                                <th>Urutan</th>
                                <th>Author</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($carousels->sortBy('sort_order') as $carousel)
                                <tr data-id="{{ $carousel->id }}">
                                    <td class="drag-handle" style="cursor: grab;">
                                        <i class="ri-drag-move-line text-primary"></i>
                                    </td>
                                    <td class="order-number">{{ $carousel->sort_order }}</td>
                                    <td>{{ $carousel->author?->name ?? '-' }}</td>
                                    <td>
                                        <img src="{{ asset('storage/' . $carousel->image) }}" alt="carousel-img"
                                            width="50" height="50"
                                            style="object-fit: cover; box-shadow: 0 0 5px rgba(0,0,0,0.2);">
                                    </td>
                                    <td>{{ $carousel->title }}</td>
                                    <td>
                                        @if ($carousel->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center flex-wrap gap-2">

                                            <!-- Tombol Edit -->
                                            <a href="{{ route('carousels-management.edit', $carousel) }}"
                                                class="btn btn-success btn-edit-carousel d-flex ">
                                                <i class='ri-edit-box-line'></i>
                                            </a>

                                            <!-- Tombol Hapus -->
                                            <form action="/carousels-management/{{ $carousel->id }}" method="POST"
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
</x-admin.layout>
<script>
    $(document).ready(function() {
        const table = $('#carouselTable').DataTable({
            rowReorder: {
                selector: '.drag-handle',
                update: false
            },
            paging: true,
            info: false,
            searching: false,
            ordering: false,
            autoWidth: false
        });

        // Hover effect
        $('#carouselTable tbody')
            .on('mouseenter', 'tr', function() {
                if (!$(this).hasClass('dt-rowReorder-moving')) {
                    $(this).addClass('table-primary');
                }
            })
            .on('mouseleave', 'tr', function() {
                $(this).removeClass('table-primary');
            });

        // Cursor drag
        table.on('row-reorder-start', function() {
            $('body').css('cursor', 'grabbing');
        });

        table.on('row-reorder-end', function() {
            $('body').css('cursor', 'default');
        });

        let isReordering = false;

        table.on('row-reorder', function(e, diff, edit) {

            if (isReordering) return;
            if (!diff.length) return;

            const order = [];

            $('#carouselTable tbody tr').each(function(index) {
                const id = $(this).data('id');

                if (id) {
                    order.push(id); // ✅ lebih simple (sesuai service)
                }
            });

            isReordering = true;

            $.ajax({
                url: "{{ route('carousels-management.reorder') }}",
                method: "POST",
                data: {
                    order: order,
                    _token: "{{ csrf_token() }}"
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Menyimpan...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function(res) {

                    if (res.success) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            timer: 1200,
                            showConfirmButton: false
                        });

                        // update nomor urutan UI
                        $('#carouselTable tbody tr').each(function(index) {
                            $(this).find('.order-number').text(index + 1);
                        });

                    } else {
                        table.draw(false);
                    }
                },
                error: function() {
                    table.draw(false);

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal menyimpan urutan'
                    });
                },
                complete: function() {
                    isReordering = false;
                }
            });

        });

    });
</script>
