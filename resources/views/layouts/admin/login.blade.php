<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('pageTitle') :: Dating App</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/fontawesome-free/css/all.min.css') !!}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{!! URL::asset('assets/admin/dist/css/adminlte.min.css') !!}">


    <script type="text/javascript">
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    </script>
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      @yield('content')      
    </div>
    <!-- /.login-box -->
  </body>

  <!-- jQuery -->
  <script src="{!! URL::asset('assets/admin/plugins/jquery/jquery.min.js') !!}"></script>
  <!-- Bootstrap 4 -->
  <script src="{!! URL::asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
  <!-- AdminLTE App -->
  <script src="{!! URL::asset('assets/admin/dist/js/adminlte.min.js') !!}"></script>
</html>