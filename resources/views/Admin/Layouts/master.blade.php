<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>Home | Mantis Bootstrap 5 Admin Template</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords"
        content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">

    <!-- [Favicon] icon -->
    <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon"> <!-- [Google Font] Family -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap"
        id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('dashboard/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('dashboard/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('dashboard/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('dashboard/fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('dashboard/css/style-preset.css') }}">

</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        @include('Admin.Layouts.sidebarmenu')
    </nav>
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="header-wrapper">
            @include('Admin.Layouts.header')
        </div>
    </header>
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    @yield('content')
    <!-- [ Main Content ] end -->
    <footer class="pc-footer">
        @include('Admin.Layouts.footer')
    </footer>

    <!-- [Page Specific JS] start -->
    <script src="{{ asset('dashboard/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('../dashboard/js/pages/dashboard-default.js') }}"></script>
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="{{ asset('dashboard/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('dashboard/js/pcoded.js') }}"></script>
    <script src="{{ asset('dashboard/js/plugins/feather.min.js') }}"></script>





    <script>
        layout_change('light');
    </script>




    <script>
        change_box_container('false');
    </script>



    <script>
        layout_rtl_change('false');
    </script>


    <script>
        preset_change("preset-1");
    </script>


    <script>
        font_change("Public-Sans");
    </script>



</body>
<!-- [Body] end -->

</html>
