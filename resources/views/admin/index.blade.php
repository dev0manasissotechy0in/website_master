
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Admin Login</title>

  <!-- Favicons -->
  <link href="{{asset('public/assets/img/favicon.png')}}" rel="icon">
  <link href="{{asset('public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('public/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4@5.0.15/bootstrap-4.min.css"/>
  {{-- <link href="{{asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet"> --}}
  {{-- <link href="{{asset('public/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet"> --}}
  {{-- <link href="{{asset('public/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet"> --}}
  {{-- <link href="{{asset('public/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet"> --}}
  {{-- <link href="{{asset('public/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet"> --}}
  {{-- <link href="{{asset('public/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet"> --}}

  <!-- Template Main CSS File -->
  <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet">
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="{{url('/')}}" class="d-block text-center w-auto">
                  @if(site_logo() != '')
                  <img src="{{asset('public/settings/'.site_logo())}}" alt="">
                  @else
                  <span class="d-none d-lg-block">{{site_name()}}</span>
                  @endif
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">
                <div class="card-body">
                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Admin</h5>
                    <p class="text-center small">Enter username & password to login</p>
                  </div>
                  <form class="row g-3" id="adminLogin" method="POST">
                    @csrf
                    <div class="col-12">
                      <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="col-12">
                      <label class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <input type="text" hidden class="url" value="{{url('/')}}">
  <!-- Vendor JS Files -->
  {{-- <script src="{{asset('public/assets/vendor/apexcharts/apexcharts.min.js')}}"></script> --}}
    <script src="{{asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/assets/js/sweetalert2.min.js')}}"></script>
    <script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('public/assets/js/login.js')}}"></script>
    
  {{-- <script src="{{asset('public/assets/vendor/chart.js/chart.umd.js')}}"></script> --}}
  {{-- <script src="{{asset('public/assets/vendor/echarts/echarts.min.js')}}"></script> --}}
  {{-- <script src="{{asset('public/assets/vendor/quill/quill.min.js')}}"></script> --}}
  {{-- <script src="{{asset('public/assets/vendor/simple-datatables/simple-datatables.js')}}"></script> --}}
  {{-- <script src="{{asset('public/assets/vendor/tinymce/tinymce.min.js')}}"></script> --}}
  {{-- <script src="{{asset('public/assets/vendor/php-email-form/validate.js')}}"></script> --}}

  <!-- Template Main JS File -->
  {{-- <script src="{{asset('public/assets/js/main.js')}}"></script> --}}

</body>

</html>