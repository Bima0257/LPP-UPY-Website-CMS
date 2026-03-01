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

                    <table id="datatable" class="table table-bordered dt-responsive nowrap"
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Author</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($carousels as $carousel)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
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
