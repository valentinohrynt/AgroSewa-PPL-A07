<?php



?>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>AgroSewa - Kalkulator</title>
    <!-- Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Afacad&family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&family=Roboto&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./css/style.css" />
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar">
        <!-- Logo Text pada navbar -->
        <a href="./index.php" class="nav-logo">Agro<span>Sewa</span></a>

        <!-- Pilihan - pilihan pada navbar -->
      <div class="navbar-nav">
        <a href="./sewa.php">Sewa</a>
        <a href="./riwayat.php">Riwayat</a>
        <a href="#">Kalkulator</a>
        <a href="#">Tentang Kami</a>
        <a href="#">Hubungi kami</a>
      </div>

      <div class="darkmode">

      </div>
      <!-- Navbar ketika disembunyikan (biasanya karena layar terlalu kecil) -->
      <div class="navbar-hidden">
        <input type="checkbox" id="darkmode-toggle"/>
        <label for="darkmode-toggle" onclick="toggleDarkMode()"></label>
        <a href="#" id="menu"><i data-feather="menu"></i></a>
      </div>

    </nav>
    <!-- Navbar -->

    <!-- Hero -->
    <div class="hero-sec" id="home">
      <p></p>
    </div>
    <script>
      feather.replace();
    </script>

    <!-- JS -->
    <script src="./js/script.js"></script>
  </body>
</html>