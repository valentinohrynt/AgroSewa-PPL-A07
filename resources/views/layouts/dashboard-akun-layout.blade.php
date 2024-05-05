<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="{{asset('assets/icons/favicon.ico')}}">
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Agrosewa | @yield('title')</title>

    <!--font awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!--css file-->
    @yield('styles')
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
            <div class="head-title">
                @yield('content-head-title')
            </div>
            @yield('content-box-info')
            <div class="table-data">
                @yield('content-table-data')
            </div>
        </main>
    </section>
    <script src="{{ asset('/assets/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    @yield('scripts');
    <script>
        function submitForm(lenderId) {
            document.getElementById('form_' + lenderId).submit();
        }
    </script>
</body>

</html>