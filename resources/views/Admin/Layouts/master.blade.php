<!DOCTYPE html>
<html lang="en">

<head>
    <title>Home | Mantis Bootstrap 5 Admin Template</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('dashboard/images/favicon.svg') }}" type="image/x-icon">

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('dashboard/fonts/tabler-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/fonts/material.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/style-preset.css') }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.css">

    <!-- jQuery (MUST be first) -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

    <!-- Summernote (Bootstrap 4 compatible – WORKS with BS5) -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body data-pc-preset="preset-1" data-pc-theme="light">

    <!-- Pre-loader -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <!-- Sidebar -->
    <nav class="pc-sidebar">
        @include('Admin.Layouts.sidebarmenu')
    </nav>

    <!-- Header -->
    <header class="pc-header">
        <div class="header-wrapper">
            @include('Admin.Layouts.header')
        </div>
    </header>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="pc-footer">
        @include('Admin.Layouts.footer')
    </footer>

    <!-- ===================== SCRIPTS ===================== -->

    <!-- Bootstrap 5 (ONLY ONE) -->
    <script src="{{ asset('dashboard/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/plugins/bootstrap.min.js') }}"></script>

    <!-- Core JS -->
    <script src="{{ asset('dashboard/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('dashboard/js/pcoded.js') }}"></script>
    <script src="{{ asset('dashboard/js/plugins/feather.min.js') }}"></script>

    <!-- ApexCharts -->
    <script src="{{ asset('dashboard/js/plugins/apexcharts.min.js') }}"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.3.5/js/dataTables.js"></script>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script src="{{ asset('dashboard/js/app.js') }}"></script>

    <!-- Page-specific scripts -->

    @yield('script')

    <script>
        $(document).ready(function() {
            $('.summernote').summernote();
        });
        layout_change('light');
        change_box_container('false');
        layout_rtl_change('false');
        preset_change('preset-1');
        font_change('Public-Sans');

        function unblockagePage() {
            $(document).ajaxStop($.unblockUI);
        }
    </script>
    <!-- Toast definition -->
    <script>
        window.Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    </script>

</body>

</html>
