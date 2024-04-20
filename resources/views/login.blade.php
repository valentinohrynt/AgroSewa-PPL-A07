<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroSewa - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset("/assets/css/auth-style.css") }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
</head>
<style>
    body{
        width:min(100%);
        display:flex;
        align-items:center;
        justify-content:center;
    }
</style>
<body>
    <div class="container d-flex flex-row">
        <div class="row py-5 mt-4 align-items-center">
            <div class="col-lg-6 mb-1 mb-md-0 mb-lg-0" style="z-index: 999">
                <h1 class="mt-5 mb-5 display-5 fw-bold ls-tight ml-md-5" style="color: hsl(218, 81%, 95%)">
                Selamat datang di <br>
                <span style="color: hsl(132, 81%, 75%)">Login AgroSewa</span>
                </h1>
            </div>
            <div class="card bg-glass col-md col-lg-6 ml-auto ml-md-auto">
                @if (session('status')=='failed')
                    <div class="alert alert-danger">
                        {{session('message')}}
                    </div>
                @elseif (session('status')==true)
                    <div class="alert alert-success">
                        Berhasil mengubah sandi, silahkan login!
                    </div>
                @endif
                <form action="#" method="post">
                    @csrf
                    <div class="row pt-5">
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa-regular fa-user text-muted"></i>
                                </span>
                            </div>
                            <input id="username" type="text" name="username" placeholder="Username" class="form-control bg-white border-left-0 border-md">
                        </div>
                        <br>
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="password" type="password" name="password" placeholder="Sandi" class="form-control bg-white border-left-0 border-md">
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="password_show_hide('password','show_eye_pw','hide_eye_pw');">
                                    <i class="fas fa-eye" id="show_eye_pw"></i>
                                    <i class="fas fa-eye-slash d-none" id="hide_eye_pw"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-12 mx-auto mb-0">
                            <button type="submit" class="btn btn-primary btn-block py-2">
                                <span class="font-weight-bold">Masuk</span>
                            </button>
                        </div>
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">ATAU</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>
                        <div class="text-center w-100">
                            <p class="text-muted font-weight-bold"><a href="forgot-password" class="text-success ml-2">Lupa Password?</a></p>
                        </div>
                        <div class="text-center w-100">
                            <p class="text-muted font-weight-bold">Belum punya akun?<a href="register" class="text-success ml-2">Daftar sebagai Petani Penyewa!</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/ec747ffee3.js" crossorigin="anonymous"></script>
<script>
    function password_show_hide(id, showEyeId, hideEyeId) {
    var x = document.getElementById(id);
    var show_eye = document.getElementById(showEyeId);
    var hide_eye = document.getElementById(hideEyeId);
    hide_eye.classList.remove("d-none");
    if (x.type === "password") {
        x.type = "text";
        show_eye.style.display = "none";
        hide_eye.style.display = "block";
    } else {
        x.type = "password";
        show_eye.style.display = "block";
        hide_eye.style.display = "none";
    }
}
    $(function () {
    $('input, select').on('focus', function () {
        $(this).parent().find('.input-group-text').css('border-color', '#80bdff');
    });
    $('input, select').on('blur', function () {
        $(this).parent().find('.input-group-text').css('border-color', '#ced4da');
    });
});
</script>
</body>
</html>