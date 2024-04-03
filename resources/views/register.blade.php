<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgroSewa - Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset("/assets/css/auth-style.css")}}">
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
                <form action="#" method="post">
                    @csrf
                    <div class="row pt-5">
                        <div class="input-group col-lg-6 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa-regular fa-user text-muted"></i>
                                </span>
                            </div>
                            <input id="name" type="text" name="name" placeholder="Nama Lengkap" class="form-control bg-white border-left-0 border-md" value="{{old('name')}}" required>
                        </div>
                        <div class="input-group col-lg-6 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa-regular fa-address-card text-muted"></i>
                                </span>
                            </div>
                            <input id="nik" type="text" name="nik" placeholder="NIK" class="form-control bg-white border-left-0 border-md" value="{{old('nik')}}" required>
                        </div>
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa-regular fa-envelope text-muted"></i>
                                </span>
                            </div>
                            <input id="email" type="email" name="email" placeholder="Alamat Email" class="form-control bg-white border-left-0 border-md" value="{{old('email')}}" required>
                        </div>
                        <div class="input-group col-lg-12 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-phone text-muted"></i>
                                </span>
                            </div>
                            <input id="phone" type="tel" name="phone" placeholder="Nomor HP" class="form-control bg-white border-left-0 border-md" value="{{old('phone')}}" required>
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
                            <input id="street" type="text" name="street" placeholder="Jalan" class="form-control bg-white border-left-0 border-md" value="{{old('street')}}" required>
                        </div>
                        <br>
                        <div class="kecamatan-desa d-flex flex-col">
                            <div class="input-group col-lg-6 mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white px-4 border-md border-right-0">
                                        <i class="fa fa-map-marker text-muted"></i>
                                    </span>
                                </div>
                                <select name="district_id" id="district" class="form-control bg-white border-left-0 border-right-0 border-md" value="{{old('district_id')}}" required>
                                    <option value="" >Kecamatan</option>
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
                                <select name="village_id" id="village" class="form-control bg-white border-left-0 border-right-0 border-md" value="{{old('village_id')}}" style="cursor: not-allowed" disabled required>
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
                                    <i class="fa fa-house text-muted"></i>
                                </span>
                            </div>
                            <select name="lender_id" id="lender" class="form-control bg-white border-left-0 border-right-0 border-md" value="{{old('lender_id')}}" style="cursor: not-allowed" disabled required>
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
                            <input id="username" type="text" name="username" placeholder="Username" class="form-control bg-white border-left-0 border-md" value="{{old('username')}}" required>
                        </div>
                        <br>
                        <div class="input-group col-lg-6 mb-4">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white px-4 border-md border-right-0">
                                    <i class="fa fa-lock text-muted"></i>
                                </span>
                            </div>
                            <input id="password" type="password" name="password" placeholder="Sandi" class="form-control bg-white border-left-0 border-md" required>
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
<script src="cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/ec747ffee3.js" crossorigin="anonymous"></script>
<script src="{{asset('/assets/js/register.js')}}"></script>
</body>
</html>