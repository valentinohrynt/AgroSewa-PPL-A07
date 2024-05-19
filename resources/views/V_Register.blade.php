<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{asset('assets/icons/favicon.ico')}}">
    <title>AgroSewa - Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset("/assets/css/auth-style.css")}}">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
</head>

<body>
    <div class="container d-flex flex-row">
        <div class="row py-5 mt-4 align-items-center">
            <div class="col-lg-6 mb-1 mb-lg-0" style="z-index: 999">
                <h1 class="mt-5 mb-5 display-5 fw-bold ls-tight" style="color: hsl(218, 81%, 95%)">
                    Selamat datang di <br>
                    <span style="color: hsl(132, 81%, 75%)">Registrasi AgroSewa</span>
                </h1>
            </div>
            <div class="card bg-glass col-md-7 col-lg-6 ml-auto">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="" method="post" id="registerForm">
                    @csrf
                    <div class="row pt-5">
                        <div class="input-group col-lg-6 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa-regular fa-user text-muted"></i>
                                </span>
                            </div>
                            <input id="name" type="text" name="name" placeholder="Nama Lengkap" class="form-control bg-white border-left-0 border-md" value="{{old('name')}}">
                        </div>
                        <div class="input-group col-lg-6 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa-regular fa-address-card text-muted"></i>
                                </span>
                            </div>
                            <input id="nik" type="text" name="nik" placeholder="NIK" class="form-control bg-white border-left-0 border-md" value="{{old('nik')}}">
                        </div>
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa-regular fa-envelope text-muted"></i>
                                </span>
                            </div>
                            <input id="email" type="email" name="email" placeholder="Alamat Email" class="form-control bg-white border-left-0 border-md" value="{{old('email')}}">
                        </div>
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-phone text-muted"></i>
                                </span>
                            </div>
                            <input id="phone" type="tel" name="phone" placeholder="Nomor HP" class="form-control bg-white border-left-0 border-md" value="{{old('phone')}}">
                        </div>
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">ALAMAT</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-map-marker text-muted"></i>
                                </span>
                            </div>
                            <input id="street" type="text" name="street" placeholder="Jalan" class="form-control bg-white border-left-0 border-md" value="{{old('street')}}">
                        </div>
                        <br>
                        <div class="kecamatan-desa d-flex flex-col">
                            <div class="input-group col-lg-6 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fa fa-map-marker text-muted"></i>
                                    </span>
                                </div>
                                <select name="district_id" id="district" class="form-control bg-white border-left-0 border-right-0 border-md" value="{{old('district_id')}}">
                                    <option value="">Kecamatan</option>
                                    @foreach($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white px-4 border-md border-left-0"></span>
                                </div>
                            </div>
                            <div class="input-group col-lg-6 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fa fa-map-marker text-muted"></i>
                                    </span>
                                </div>
                                <select name="village_id" id="village" class="form-control bg-white border-left-0 border-right-0 border-md" value="{{old('village_id')}}" style="cursor: not-allowed" disabled>
                                    <option value="">Desa</option>
                                    @foreach ($villages as $village)
                                    <option value="{{ $village->id }}" data-district="{{ $village->district_id }}">{{ $village->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-white px-4 border-md border-left-0"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="bi-pin-map-fill text-muted"></i>
                                </span>
                            </div>
                            <input type="text" name="land_area" id="land_area" placeholder="Luas Tanah (meter persegi)" class="form-control bg-white border-left-0 border-md" value="{{old('land_area')}}">
                        </div>
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-house text-muted"></i>
                                </span>
                            </div>
                            <select name="lender_id" id="lender" class="form-control bg-white border-left-0 border-right-0 border-md" value="{{old('lender_id')}}" style="cursor: not-allowed" disabled>
                                <option value="">Nama Kelompok Tani</option>
                                @foreach ($lenders as $lender)
                                <option value="{{ $lender->id }}" data-village="{{ $lender->village_id }}">{{ $lender->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <span class="input-group-text bg-white px-4 border-md border-left-0"></span>
                            </div>
                        </div>
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">AKUN</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa-regular fa-user text-muted"></i>
                                </span>
                            </div>
                            <input id="username" type="text" name="username" placeholder="Username" class="form-control bg-white border-left-0 border-md" value="{{old('username')}}">
                        </div>
                        <br>
                        <div class="input-group col-lg-6 mb-4">
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
                        <div class="input-group col-lg-6 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi Sandi" class="form-control bg-white border-left-0 border-md">
                            <div class="input-group-append">
                                <span class="input-group-text" onclick="password_show_hide('password_confirmation','show_eye_confirm','hide_eye_confirm');">
                                    <i class="fas fa-eye" id="show_eye_confirm"></i>
                                    <i class="fas fa-eye-slash d-none" id="hide_eye_confirm"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-12 mx-auto mb-0">
                            <button type="submit" class="btn btn-primary btn-block py-2">
                                <span class="font-weight-bold">Registrasi</span>
                            </button>
                        </div>
                        <div class="form-group col-lg-12 mx-auto d-flex align-items-center my-4">
                            <div class="border-bottom w-100 ml-5"></div>
                            <span class="px-2 small text-muted font-weight-bold text-muted">ATAU</span>
                            <div class="border-bottom w-100 mr-5"></div>
                        </div>
                        <div class="text-center w-100">
                            <p class="text-muted font-weight-bold">Sudah punya akun?<a href="login" class="text-success ml-2">Masuk</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script src="https://kit.fontawesome.com/ec747ffee3.js" crossorigin="anonymous"></script>
    <script src="{{asset('/assets/js/register.js')}}"></script>
    <script>
        $(document).ready(function() {
            $("#registerForm").validate({
                ignore: ":disabled",
                rules: {
                    name: "required",
                    nik: {
                        required: true,
                        minlength: 16,
                        digits: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        minlength: 10,
                        digits: true
                    },
                    street: "required",
                    district_id: "required",
                    village_id: "required",
                    land_area: {
                        required: true,
                        digits: true
                    },
                    lender_id: "required",
                    username: "required",
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    name: "Harap masukkan nama lengkap Anda",
                    nik: { 
                        required: "Harap masukkan NIK Anda", 
                        minlength: "Harap masukkan NIK yang valid", 
                        digits: "Harap masukkan NIK yang valid" 
                    },
                    email: {
                        required: "Harap masukkan alamat email Anda",
                        email: "Harap masukkan alamat email yang valid"
                    },
                    phone: {
                        required: "Harap masukkan nomor telepon Anda",
                        minlength: "Harap masukkan nomor telepon yang valid",
                        digits: "Harap masukkan nomor telepon yang valid"
                    },
                    street: "Harap masukkan alamat jalan Anda",
                    district_id: "Harap pilih kecamatan",
                    village_id: "Harap pilih desa",
                    land_area: {
                        required: "Harap masukkan luas tanah Anda",
                        digits: "Harap masukkan luas tanah yang valid"
                    },
                    lender_id: "Harap pilih kelompok tani",
                    username: "Harap masukkan username",
                    password: {
                        required: "Harap masukkan kata sandi",
                        minlength: "Kata sandi harus terdiri dari minimal 6 karakter"
                    },
                    password_confirmation: {
                        required: "Harap konfirmasi kata sandi Anda",
                        equalTo: "Harap masukkan kata sandi yang sama seperti di atas"
                    }
                },
                errorElement: 'div',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-valid').removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    $.ajax({
                        method: "POST",
                        dataType: "json",
                        cache: false,
                        contentType: false,
                        processData: false,
                        enctype: 'multipart/form-data',
                        data: new FormData(form),
                        url: "{{route('register')}}",
                        success: function(response) {
                            if (response.status == 'success') {
                                window.location.href = "{{route('login')}}";
                            } else {
                                alert(response.message);
                            }
                        }
                    });
                }
            });
            $('select').on('change', function() {
                $(this).prop('disabled', false).valid(); 
            });
        });
    </script>             
</body>

</html>