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
      @if(session('success'))
      <div class="alert alert-success mb-5">
        {{ session('success') }}
      </div>
      @endif
      @if(session('error'))
      <div class="alert alert-danger mb-5">
        {{ session('error') }}
      </div>
      @endif
      @if ($errors->any())
      <div class="alert alert-danger mb-5">
        @foreach ($errors->all() as $error)
        {{ $error }}<br>
        @endforeach
      </div>
      @endif
      <div class="head-title">
        @yield('content-head-title')
      </div>
      @yield('back-button')
      @yield('content-box-info')
      <div class="edit-button">
        @yield('edit-button')
      </div>
    </main>
  </section>
  <script>
    document.getElementById("district").addEventListener("change", function() {
      var selectedDistrictId = this.value;
      var villageSelect = document.getElementById("village");
      villageSelect.removeAttribute("style");
      villageSelect.removeAttribute("disabled");
      for (var i = 0; i < villageSelect.options.length; i++) {
        var option = villageSelect.options[i];
        if (
          option.value !== "" &&
          option.getAttribute("data-district") !== selectedDistrictId
        ) {
          option.style.display = "none";
        } else {
          option.style.display = "";
        }
      }
      var defaultVillageId = villageSelect.querySelector(
        'option[data-district="' + selectedDistrictId + '"]'
      ).value;
      villageSelect.value = defaultVillageId;
    });
    document.getElementById("village").addEventListener("change", function() {
      var selectedVillageId = this.value;
      var districtId = document.getElementById("district").value;
      var villageSelect = document.getElementById("village");
      for (var i = 0; i < villageSelect.options.length; i++) {
        var option = villageSelect.options[i];
        if (
          option.value !== "" &&
          option.getAttribute("data-district") !== districtId &&
          option.value !== selectedVillageId
        ) {
          option.style.display = "none";
        } else {
          option.style.display = "";
        }
      }
    });
    document.addEventListener('DOMContentLoaded', function() {
      var form = document.getElementById('formEditProfil');
      form.addEventListener('submit', function(event) {
        var villageSelect = document.getElementById('village');
        villageSelect.removeAttribute('disabled');
      });
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <script src="{{asset('/assets/js/dashboard.js')}}"></script>
</body>

</html>