<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agrosewa | @yield('title')</title>

    <!--font awesome-->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

    <!--css file-->
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/assets/css/dashboard-style.css')}}" />

  </head>
  <body>
    <section id="sidebar" class="sidebar">
      @yield('sidebar')
    </section>

    <section class="content">
      <nav class="">
      <i class="fas fa-bars menu-btn"></i>
        <a href="#" class="profile">
          <i class="fa fa-circle-user fa-xl"></i>
        </a>
      </nav>

      <main>
        <div class="head-title">
          @yield('content-head-title')
        </div>
        <div class="box-info">
          @yield('content-box-info')
        </div>
      </main>
    </section>

    <script src="{{asset('/assets/js/dashboard.js')}}"></script>
  </body>
</html>
