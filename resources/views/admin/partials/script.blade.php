<!-- Vendor JS Files -->
    {{-- <script src="../public/assets/vendor/apexcharts/apexcharts.min.js"></script> --}}
    <script src="{{asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
    {{-- <script src="../public/assets/vendor/chart.js/chart.umd.js"></script> --}}
    {{-- <script src="../public/assets/vendor/echarts/echarts.min.js"></script> --}}
    {{-- <script src="../public/assets/vendor/quill/quill.min.js"></script> --}}
    {{-- <script src="../public/assets/vendor/simple-datatables/simple-datatables.js"></script> --}}
    <script src="{{asset('public/assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{asset('public/assets/js/sweetalert2.min.js')}}"></script>
    {{-- <script src="../public/assets/vendor/php-email-form/validate.js"></script> --}}
    @yield('pageJsScripts')
    <!-- Template Main JS File -->
    <script src="{{asset('public/assets/js/main.js')}}"></script>
    <script src="{{asset('public/assets/js/action.js')}}"></script>
    <input type="text" class="site-url" value="{{url('/')}}">