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
  <link href="{{asset('/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
    integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
  <link href="{{asset('/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">

  <link href="{{asset('/assets/css/style.css')}}" rel="stylesheet">
</head>

<body>
  <!-- header -->
  <header id="header" class="fixed-top ">
    <div class="container d-flex align-items-center justify-content-lg-between">

      <h1 class="logo me-auto me-lg-0"><a href="index.html">Agro<span>Sewa</span></a></h1>
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="{{asset('/assets/as-logo.png')}}" alt="" class="img-fluid"></a> -->

      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          @yield('navbar-nav')
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
      <!-- <a href="logout" class="logout-btn"><i class="bi-box-arrow-right"></i> Keluar</a>
      <a href="akun-poktan" class="akun-btn"><i class="bi-person-circle"></i></a> -->
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container" data-aos="fade-up">
      <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
        <div class="col-xl-6 col-lg-8">
          <h1>Sewa dan Pinjam Alat Tani Jadi Lebih Mudah<span>.</span></h1>
          <h2>Selamat datang di AgroSewa</h2>
        </div>
      </div>
      <div class="row gy-4 mt-5 justify-content-center" data-aos="zoom-in" data-aos-delay="250">
        @yield('hero-btn')
      </div>
    </div>
  </section><!-- End Hero -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6">
            <div class="footer-info">
              <h3>Agro<span>Sewa</span></h3>
              <p>
                Jember <br>
                Indonesia<br><br>
                <strong>Phone:</strong> +62 82143981626<br>
                <strong>Email:</strong> agrosewa.id@gmail.com<br>
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="credits">
          Designed by <a href="">AgroSewa</a>
        </div>
      </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('/assets/js/main.js')}}"></script>

</body>

</html>