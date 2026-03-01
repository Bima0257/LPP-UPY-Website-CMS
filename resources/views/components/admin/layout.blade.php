@props(['title' => 'Web LPP'])
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>{{ $title ?? 'Web LPP' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon"
        href="{{ $about?->favicon ? asset('storage/' . $about->favicon) : asset('assets/images/logo/favicon.png') }}">



    <!-- jquery.vectormap css -->
    <link href="{{ asset('assets_admin/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{ asset('assets_admin/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets_admin/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets_admin/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets_admin/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css">


    <!-- Bootstrap Css -->
    <link href="{{ asset('assets_admin/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets_admin/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets_admin/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <!-- Sweet Alert-->
    <link href="{{ asset('assets_admin/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />


</head>

<body data-sidebar="dark">

    <!-- Begin page -->
    <div id="layout-wrapper">
        <x-admin.navbar></x-admin.navbar>
        <x-admin.sidebar></x-admin.sidebar>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    {{ $slot }}
                    <x-admin.footer></x-admin.footer>
                </div>
            </div>
        </div>
    </div>


    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets_admin/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/node-waves/waves.min.js') }}"></script>


    <!-- jquery.vectormap map -->
    <script src="{{ asset('assets_admin/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}">
    </script>
    <script src="{{ asset('assets_admin/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}">
    </script>


    <!-- Required datatable js -->
    <script src="{{ asset('assets_admin/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets_admin/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('assets_admin/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('assets_admin/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('') }}assets_admin/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('') }}assets_admin/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js">
    </script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>


    <!-- Datatable init js -->
    <script src="{{ asset('') }}assets_admin/js/pages/datatables.init.js"></script>


    <!-- App js -->
    <script src="{{ asset('assets_admin/js/app.js') }}"></script>


    <!-- Sweet Alerts js -->
    <script src="{{ asset('assets_admin/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Sweet alert init js-->
    <script src="{{ asset('assets_admin/js/pages/sweet-alerts.init.js') }}"></script>

    <!--tinymce js-->
    <script src="{{ asset('assets_admin/libs/tinymce/tinymce.min.js') }}"></script>


    <!-- apexcharts -->
    <script src="{{ asset('assets_admin/libs/apexcharts/apexcharts.min.js') }}"></script>


    <script>
        setInterval(() => {
            fetch('/heartbeat');
        }, 180000); // 3 menit

        function initTiny(selector) {
            tinymce.init({
                selector: selector,
                menubar: false,
                branding: false,
                statusbar: false,
                plugins: 'wordcount paste lists advlist',
                toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
                paste_webkit_styles: "all",
                paste_merge_formats: true,

                valid_elements: "p[style|align|class],span[style|class],br,strong,em,b,i,u," +
                    "ul[style|class],ol[style|type|start|class],li[style|class]," +
                    "a[href|target|rel|style|class]",

                valid_styles: {
                    '*': 'text-align,text-indent,margin,margin-left,margin-right,padding,' +
                        'padding-left,padding-right,list-style,list-style-type,' +
                        'background,background-color,line-height'
                },

                paste_preprocess: function(plugin, args) {
                    const doc = new DOMParser().parseFromString(args.content, 'text/html');

                    doc.querySelectorAll('[style]').forEach(el => {
                        let style = el.getAttribute('style') || '';

                        const tabMatch = style.match(/mso-tab-count:\s*(\d+)/i);
                        if (tabMatch) {
                            const tabCount = parseInt(tabMatch[1], 10);
                            const indentPt = tabCount * 36;
                            el.style.textIndent = indentPt + "pt";
                        }

                        if (/mso-text-justify/i.test(style)) {
                            el.style.textAlign = "justify";
                        }

                        style = style.replace(/font(-[^:]+)?:[^;]+;?/gi, '');
                        style = style.replace(/mso-[^:]+:[^;]+;?/gi, '');

                        const keep = [];
                        const keepProps = [
                            'text-align',
                            'text-indent',
                            'margin-left',
                            'margin-right',
                            'padding-left',
                            'padding-right',
                            'list-style',
                            'list-style-type',
                            'background',
                            'background-color',
                            'line-height'
                        ];

                        style.split(';').forEach(s => {
                            const prop = s.trim().split(':')[0];
                            if (keepProps.includes(prop)) keep.push(s.trim());
                        });

                        if (keep.length) {
                            el.setAttribute('style', keep.join('; '));
                        } else {
                            el.removeAttribute('style');
                        }
                    });

                    args.content = doc.body.innerHTML;
                }
            });
        }


        $(document).ready(function() {
            $('#datatable').DataTable();

            @if ($errors->any())

                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: `
        <div style="text-align:left;">
            @foreach ($errors->all() as $error)
                <p class="text-danger text-center">{{ $error }}</p>
            @endforeach
        </div>
        `
                });
            @endif

            // sweet allert
            @if (session('success'))
                const messageId = 'success_message_{{ time() }}';
                if (!sessionStorage.getItem(messageId)) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                    sessionStorage.setItem(messageId, '1');
                }
            @endif

            @if (session('error'))
                const messageId = 'success_message_{{ time() }}';
                if (!sessionStorage.getItem(messageId)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                    sessionStorage.setItem(messageId, '1');
                }
            @endif

            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault(); // cegah aksi default

                const url = $(this).data('url'); // ambil URL delete

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Jika pakai form
                        if ($(this).closest('form').length) {
                            $(this).closest('form').submit();
                        } else {
                            // Jika pakai redirect GET
                            window.location.href = url;
                        }
                    }
                });
            });
        });

        // Fungsi preview global
        function previewImage(event, previewId, sizeInfoId) {
            const input = event.target;
            const file = input.files && input.files[0];
            const preview = document.getElementById(previewId);
            const sizeInfo = document.getElementById(sizeInfoId);

            if (!preview || !sizeInfo) return;

            if (file) {
                if (!file.type.startsWith('image/')) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File harus berupa gambar!',
                        showConfirmButton: false, // sembunyikan tombol OK
                        timer: 1000, // auto-close dalam 2 detik
                        timerProgressBar: true
                    });
                    input.value = '';
                    preview.src = '';
                    preview.style.display = 'none';
                    sizeInfo.style.display = 'none';
                    return;
                }

                if (file.size > 1 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Ukuran file maksimal 1MB!',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });
                    input.value = '';
                    preview.src = '';
                    preview.style.display = 'none';
                    sizeInfo.style.display = 'none';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);

                const fileSizeKB = (file.size / 1024).toFixed(2);
                sizeInfo.textContent = `Ukuran: ${fileSizeKB} KB`;
                sizeInfo.style.display = 'block';
            } else {
                preview.src = '';
                preview.style.display = 'none';
                sizeInfo.style.display = 'none';
            }
        }

        // Event listener untuk semua input file
        document.querySelectorAll('input[type="file"][data-preview]').forEach(input => {
            input.addEventListener('change', function() {
                const previewId = input.dataset.preview;
                const infoId = input.dataset.info;
                previewImage({
                    target: input
                }, previewId, infoId);
            });
        });
    </script>
</body>

</html>
