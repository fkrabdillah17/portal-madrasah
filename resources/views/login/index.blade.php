<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Portal MTsN 1 Kota Bengkulu">
    <meta name="author" content="">

    <title>Portal MTsN 1 Kota Bengkulu - Login</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/Logo.png') }}" type="image/png">

    <!-- Custom fonts for this template-->
    <link href="/assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/assets/css/mystyle.css?v=2" rel="stylesheet">

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
                        <!-- Nested Row within Card Body -->

                        <div class="row">
                            <div class="col">
                                <div class=" text-center">
                                    <h1 class="h2 text-gray-900 mb-4">Portal Admin </h1>
                                </div>
                                @if (session('status'))
                                    <div class="alert alert-warning">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <center>
                                    <div class=" col-10 p-3">
                                        <form method="post" action="{{ route('store-login') }}">
                                            @csrf
                                            <div class="form-group">
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" placeholder="Masukan Email">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" placeholder="Masukan Kata Sandi">
                                                @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                Masuk
                                            </button>

                                            <hr>

                                            <p>Lupa password ?<a href="{{ route('password.request') }}"> klik
                                                    disini!</a></p>

                                        </form>
                                    </div>
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
