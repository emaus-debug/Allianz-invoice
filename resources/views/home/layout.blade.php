<!DOCTYPE html>
<html lang="en">

<head>
  @include('home.head')

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top align-items-center">
    
    <!-- Navbar -->
    @include('home.nav')

  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  @yield('content')<!-- End Hero -->

  <!-- ======= Footer ======= -->
  @include('home.footer')

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset("assets/home/assets/vendor/aos/aos.js")}}"></script>
  <script src="{{asset("assets/home/assets/vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
  <script src="{{asset("assets/home/assets/vendor/swiper/swiper-bundle.min.js")}}"></script>
  <script src="{{asset("assets/home/assets/vendor/php-email-form/validate.js")}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset("assets/home/assets/js/main.js")}}"></script>

</body>

</html>

