<!DOCTYPE html>
<html lang="en">
<head>
    <!-- meta -->
    <x-meta></x-meta>

    <!-- title -->
    <x-title></x-title>

    <!-- stylesheet -->
    <x-link></x-link>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed text-sm" data-panel-auto-height-mode="height">
<!-- site wrapper -->
<div class="wrapper">
    <!-- preloader -->
    <x-preloader></x-preloader>

    <!-- navbar -->
    <x-navbar></x-navbar>

    <!-- sidebar -->
    <x-sidebar></x-sidebar>

    <!-- main content -->
    <main>
        {{ $slot }}
    </main>

    <!-- footer -->
    <x-footer></x-footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

</div>

    <!-- javascript -->
    <x-script></x-script>
</body>
</html>
