<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | {{ $title }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/Logo.png') }}" type="image/png">
    <!-- Custom fonts for this template-->
    <link href="{{ URL::asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Admin styles for this template-->
    <link href="{{ URL::asset('assets/css/sb-admin-2.min.css?v=1.1') }}" rel="stylesheet">
    {{-- Table CSS --}}
    <link href="{{ URL::asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    {{-- Custom CSS --}}
    <link href="{{ URL::asset('assets/css/style2.css?v=1.3.3') }}" rel="stylesheet">
    {{-- Custom JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.1/font/bootstrap-icons.css">
    <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
    @yield('onload')
</head>

<body id="page-top">

    <!-- Page Content -->
    <div class="embed-responsive embed-responsive-16by9">
        <iframe type="application/pdf" class="iframe-responsive-item" src="/assets/files/academic/{{ $data->file }}"
            allowfullscreen></iframe>
    </div>
    <!-- End of Page Content -->


    <!-- Bootstrap core JavaScript-->
    <script src="{{ URL::asset('assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ URL::asset('assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ URL::asset('assets/js/sb-admin-2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/costum-js.js') }}"></script>
</body>

</html>
