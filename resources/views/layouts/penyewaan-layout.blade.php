<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>AgroSewa - @yield('title')</title>

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="{{asset('/assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
    <link href="{{asset('/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

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
        @yield('content')
    </main><!-- End #main -->
    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-info">
                            <h3>Agro<span>Sewa</span></h3>
                            <p>
                                Jember, Indonesia <br>
                                <strong>Phone:</strong> +62 82143981626<br>
                                <strong>Email:</strong> agrosewa.id@gmail.com<br>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="credits">
                Designed by <a href="">AgroSewa</a>
            </div>
        </div>
    </footer>

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="{{asset('/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
    <script src="{{asset('/assets/vendor/aos/aos.js')}}"></script>
    <script src="{{asset('/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
    <script src="{{asset('/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
    <script src="{{asset('/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
    <script src="{{asset('/assets/vendor/php-email-form/validate.js')}}"></script>

    <script src="{{asset('/assets/js/main.js')}}"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

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