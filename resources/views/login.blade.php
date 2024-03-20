<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>AgroSewa - Login</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous"
        />
    </head>
    <style>
        body{
            width:min(100%)
        }
        .head img {
            width: 5rem;
            height: auto;
        }
        .alert {
            font-family: poppins;
            font-size: 20px;
            width: auto;
            position:flex;
        }
        @media (min-width: 320px) and (max-width: 425px){
            .alert{
                font-size: 0.8rem;
                justify-content: center;
            }
        }
        @media (min-width: 426px) and (max-width: 1024px){
            .alert{
                font-size: 1rem;
                justify-content: center;
            }
        }
    </style>
    <body>
        <section class="vh-100" style="background-color: #DAF7A6">
            <div class="container py-5 h-100">
                <div
                    class="row d-flex flex-column justify-content-center align-items-center h-100"
                >
                @if (session('status'))
                <div class="alert alert-danger">
                    {{session('message')}}
                </div>
                <script>
                    alert('{{session('message')}}')
                </script>
                @endif
                    <div class="col col-xl-10">
                        <div class="card" style="border-radius: 1rem">
                            <div class="row g-0">
                                <div
                                    class="col-md-6 col-lg-5 d-none d-md-block"
                                >
                                    <img
                                        src="{{ asset('assets/loginp-banner.png') }}"
                                        alt="login form"
                                        class="img-fluid"
                                        style="border-radius: 1rem 0 0 1rem"
                                    />
                                </div>
                                <div
                                    class="col-md-6 col-lg-7 d-flex align-items-center"
                                >
                                    <div
                                        class="card-body p-4 p-lg-5 text-black"
                                    >
                                        <form action="" method="POST">
                                            @csrf
                                            <div
                                                class="head d-flex justify-content-center align-items-center flex-column mb-3 pb-1"
                                            >
                                                <span class="h1 fw-bold"
                                                    >Login</span
                                                >
                                            </div>

                                            <div class="form-outline mb-4">
                                                <label
                                                    class="form-label"
                                                    for="username"
                                                    >Username</label
                                                >
                                                <input
                                                    type="text"
                                                    name="username"
                                                    id="username"
                                                    class="form-control form-control-lg"
                                                    required
                                                />
                                            </div>

                                            <div class="form-outline mb-4">
                                                <label
                                                    class="form-label"
                                                    for="password"
                                                    >Sandi</label
                                                >
                                                <input
                                                    type="password"
                                                    name="password"
                                                    id="password"
                                                    class="form-control form-control-lg"
                                                    required
                                                />
                                            </div>

                                            <div class="pt-1 mb-4">
                                                <button
                                                    class="btn btn-dark btn-lg btn-block form-control"
                                                    type="submit"
                                                >
                                                    Masuk
                                                </button>
                                            </div>

                                            <a
                                                class="small text-muted"
                                                href="#!"
                                                >Lupa sandi?</a
                                            >
                                            <p class="mt-4 mb-0 pb-lg-2" style="color: #393f81">
                                                Belum punya akun?
                                            <a href="register" style="color: #393f81">Registrasi sekarang!</a>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
