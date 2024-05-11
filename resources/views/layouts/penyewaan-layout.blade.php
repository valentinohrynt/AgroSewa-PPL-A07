<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link rel="icon" type="image/png" href="{{asset('assets/icons/favicon.ico')}}">
    <title>AgroSewa - @yield('title')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- cdn css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">

    <!-- local vendor css -->
    <link href="{{asset('/assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/css/style.css')}}" rel="stylesheet">
</head>

<body>
    <!-- header -->
    <header id="header" class="fixed-top ">
        <div class="container d-flex align-items-center justify-content-lg-between">
            <h1 class="logo me-auto me-lg-0"><a href="#">Agro<span>Sewa</span></a></h1>
            <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="{{asset('/assets/as-logo.png')}}" alt="" class="img-fluid"></a> -->

            <nav id="navbar" class="navbar order-last order-lg-0">
                <ul>
                    @yield('navbar-nav')
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->
        </div>
    </header><!-- End Header -->
    <main id="main" style="background-color:aliceblue; ">
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin logout?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button>
                        <a href="{{ route('logout') }}" class="btn btn-success">Ya</a>
                    </div>
                </div>
            </div>
        </div>
        @yield('content')
    </main><!-- End #main -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-8">
                        <div class="footer-info">
                            <h3 class="pt-4">Agro<span>Sewa</span></h3>
                            <p>
                                Jember <br>
                                Indonesia<br><br>
                                <strong>Telepon:</strong> +62 82143981626<br>
                                <strong>Email:</strong> agrosewa.id@gmail.com<br>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-8">
                    </div>
                    <div class="col-lg-3 col-md-8">
                    </div>
                    <div class="col-lg-3 col-md-8">
                        <div class="footer-info">
                            <img src="{{asset('assets\img\logo\jemberkab_logo.png')}}" class="logo-jemberkab">
                            <p>
                                <strong>Dinas Tanaman Pangan, Hortikultura, dan Perkebunan Kab. Jember</strong><br><br>
                                <strong>Telepon:</strong> (0331) 482787<br>
                                <strong>Email:</strong> jemberdiperta@yahoo.com<br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="container">
                <div class="credits">
                    Designed by <a href="">AgroSewa</a>
                </div>
            </div>
        </div>
    </footer><!-- End Footer -->

    <div id="preloader">
        <img src="{{asset('assets/img/preloader-128.gif')}}" alt="Loading">
    </div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- cdn js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

    <!-- local vendor js -->
    <script src="{{asset('/assets/js/main.js')}}"></script>
    <script src="{{asset('/assets/vendor/aos/aos.js')}}"></script>
    </script>
    @yield('script')
    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();
                $('.table tbody tr').each(function() {
                    var transactionNumber = $(this).find('td:eq(1)').text().toLowerCase();
                    var productName = $(this).find('td:eq(2)').text().toLowerCase();
                    var borrowerName = $(this).find('td:eq(3)').text().toLowerCase();
                    if (transactionNumber.includes(searchText) || productName.includes(
                            searchText) || borrowerName.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>

</html>