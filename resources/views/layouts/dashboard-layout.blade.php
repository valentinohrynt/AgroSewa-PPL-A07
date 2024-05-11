<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <link rel="icon" type="image/png" href="{{asset('assets/icons/favicon.ico')}}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Agrosewa | @yield('title')</title>

  <!--font awesome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!--css file-->
  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('/assets/css/dashboard-style.css')}}" />

</head>

<body>
  <section id="sidebar" class="sidebar">
    @yield('sidebar')
  </section>

  <section class="content">
    <nav class="d-flex">
      @yield('nav')
    </nav>

    <main>
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
      <div class="head-title">
        @yield('content-head-title')
      </div>
      <div class="box-info">
        @yield('content-box-info')
      </div>
    </main>
  </section>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script>
    $(document).ready(function() {
      $('.clickable').click(function() {
        window.location.href = $(this).data('url');
      });
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
  <script src="{{asset('/assets/js/dashboard.js')}}"></script>
</body>

</html>