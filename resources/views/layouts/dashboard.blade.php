<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIPRAGA | DASHBOARD</title>
    <link rel="shortcut icon" type="image/jpg" href="{{ asset('images/logos/sipraga.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}" />
    <link
        href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/sp-2.2.0/datatables.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    @yield('js')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @yield('sidebar')
        <!--  Sidebar End -->

        <!--  Main-wrapper Start-->
        <div class="body-wrapper">
            <!--  Header Start -->
            @yield('header')
            <!--  Header End -->

            <!-- Content Start -->
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- Content End -->
        </div>
        <!--  Main-wrapper End-->
    </div>
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    {{-- <script src="{{ asset('libs/apexcharts/dist/apexcharts.min.js') }}"></script> --}}
    <script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>
    {{-- <script src="{{ asset('js/dashboard.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script
        src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.2/b-colvis-2.4.2/b-html5-2.4.2/b-print-2.4.2/r-2.5.0/sp-2.2.0/datatables.min.js">
    </script>
    <!-- Pustaka Bootstrap Colorpicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js">
    </script>
    <script>
        new DataTable('#example');
        new DataTable('#example2');


        $(function() {
            $(document).on('click', '#terima-peminjaman', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Anda yakin untuk terima pengajuan?',
                    text: "Anda tidak dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, terima!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Diterima!',
                            'Pengajuan peminjaman telah diterima.',
                            'success'
                        )
                    }
                })
            })
        })

        $(function() {
            $(document).on('click', '#terima-pengaduan', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");

                Swal.fire({
                    title: 'Anda yakin untuk terima pengaduan?',
                    text: "Anda tidak dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, terima!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Diterima!',
                            'Pengaduan sarpras telah diterima.',
                            'success'
                        )
                    }
                })
            })
        })
    </script>
    <script>
        $(document).ready(function(){
            $('.colorpicker').colorpicker();
        });
    </script>    
    @yield('additional-js')
</body>

</html>
