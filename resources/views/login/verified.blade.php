<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Portal MTsN 1 Kota Bengkulu - Register</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/Logo.png') }}" type="image/png">

    <!-- Custom fonts for this template-->
    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">

                    <div class="card-body p-0">
                        <center>
                            <img src="{{ asset('assets/img/logo/Logo.png') }}" alt="" width="200px" height="200px"
                                class="mt-2">
                        </center>
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                Link verifikasi baru sudah dikirim ke email anda
                            </div>
                        @endif
                        <!-- Nested Row within Card Body -->

                        <div class="row">
                            <div class="col">
                                <div class=" text-center">
                                    <h1 class="h2 text-gray-900 mb-4">Verifikasi Email</h1>
                                </div>
                                <center>
                                    <p>Email Telah Berhasil Diverifikasi</p>
                                    <a href="{{ route('beranda') }}">
                                        <button type="submit" class="d-inline btn btn-link mx-auto">
                                            Masuk ke Beranda Admin.
                                        </button>
                                    </a>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="/assets/vendor/jquery/jquery.min.js"></script>
    <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="/assets/js/sb-admin-2.min.js"></script>

</body>

</html>
