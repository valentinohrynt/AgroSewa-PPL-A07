<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroSewa - Lupa Sandi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset("/assets/css/auth-style.css")}}">
</head>
<style>
    body{
        width:min(100%);
        display:flex;
        align-items:center;
        justify-content:center;
    }
    .alert-danger{
        position:relative;
        top: -2%;
    }
</style>
<body>
    <div class="container d-flex flex-row">
        <div class="col align-items-center">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if (session()->has('status'))
            <div class="alert alert-success">
                {{session()->get('status')}}
            </div>
            @endif
            <div class="card bg-glass col-md-6 col-lg-6 col-sm-6 col-xl-6 ml-auto mr-auto">
                <form action="{{route('password.email')}}" method="post">
                    @csrf
                    <div class="row pt-5">
                        <div class="col d-flex flex-column pt-0 align-items-center">
                            <h2 class="my-auto mx-auto text-uppercase">Lupa Sandi</h2>
                            <h5 class="my-5 ml-2 text-center text-uppercase">Silahkan masukkan email Anda pada kolom berikut!</h5>
                        </div>
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa-regular fa-envelope text-muted"></i>
                                </span>
                            </div>
                            <input id="email" type="email" name="email" placeholder="Email" class="form-control bg-white border-left-0 border-md" required>
                        </div>
                        <br>
                        <div class="form-group col-lg-12 mx-auto mb-5">
                            <button type="submit" class="btn btn-primary btn-block py-2">
                                <span class="font-weight-bold">Kirim Tautan Ubah Sandi</span>
                            </button>
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

document.getElementById('district').addEventListener('change', function() {
    var selectedDistrictId = this.value;
    var villageSelect = document.getElementById('village');
    villageSelect.removeAttribute('style');
    villageSelect.removeAttribute('disabled');
    for (var i = 0; i < villageSelect.options.length; i++) {
        var option = villageSelect.options[i];
        if (option.value !== "" && option.getAttribute('data-district') !== selectedDistrictId) {
            option.style.display = 'none';
        } else {
            option.style.display = '';
        }
    }
    var defaultVillageId = villageSelect.querySelector('option[data-district="' + selectedDistrictId + '"]').value;
    villageSelect.value = defaultVillageId;
});
</script>
</body>
</html>