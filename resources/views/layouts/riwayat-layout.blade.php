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
    <style>
        .approval-status {
            border-radius: 10px;
            padding: 3px 0;
            text-align: center;
            font-weight: 600;
        }

        .approved {
            padding: 0.3rem;
            background-color: #d4edda;
            color: #155724;
        }

        .in-process {
            padding: 0.3rem;
            background-color: #fff3cd;
            color: #856404;
        }

        .rejected {
            padding: 0.3rem;
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
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
    <!-- local vendor js -->
    <script src="{{asset('/assets/js/main.js')}}"></script>
    <script src="{{asset('/assets/vendor/aos/aos.js')}}"></script>
    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('dateFilterInput').addEventListener('change', function() {
                let selectedDate = this.value;
                let tableBody = document.querySelector('.table tbody'); // Select the tbody element directly

                if (tableBody) {
                    for (let row of tableBody.rows) {
                        let dateColumn = row.cells[4].textContent.trim(); // Tanggal pengembalian berada di indeks 4
                        let formattedDate = formatTableDate(dateColumn); // Ubah format tanggal pada tabel
                        if (selectedDate === '' || formattedDate === selectedDate) {
                            row.style.display = 'table-row'; // Munculkan baris jika tanggal cocok atau input kosong
                        } else {
                            row.style.display = 'none'; // Sembunyikan baris jika tanggal tidak cocok
                        }
                    }
                } else {
                    console.error('Table body element not found.');
                }
            });

            function formatTableDate(dateString) {
                const months = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];
                let parts = dateString.split(' ');
                let day = parts[0];
                let monthIndex = months.indexOf(parts[1]) + 1; // Tambahkan 1 karena indeks dimulai dari 0
                let year = parts[2];
                let formattedDate = year + '-' + (monthIndex < 10 ? '0' : '') + monthIndex + '-' + (day < 10 ? '0' : '') + day;
                return formattedDate;
            }
        });
    </script>

    <!-- cdn js -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

</body>

</html>