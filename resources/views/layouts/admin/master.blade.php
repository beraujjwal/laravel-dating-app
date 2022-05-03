<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('pageTitle') :: Dating App</title>

  <!-- Google Font: Source Sans Pro -->
  <!--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/fontawesome-free/css/all.min.css') !!}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}">
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!}">
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') !!}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/dist/css/adminlte.min.css') !!}">

  <!-- jQuery -->
<script src="{!! URL::asset('assets/admin/plugins/jquery/jquery.min.js') !!}"></script>
<!-- Bootstrap 4 -->
<script src="{!! URL::asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>

  <script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    @include('layouts.admin.includes.header')
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    @include('layouts.admin.includes.sidebar')
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>@yield('pageHeader')</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">@yield('pageHeader')</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    @include('layouts.admin.includes.footer')
  </footer>
</div>
<!-- ./wrapper -->


<!-- DataTables  & Plugins -->
<script src="{!! URL::asset('assets/admin/plugins/datatables/jquery.dataTables.min.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/jszip/jszip.min.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/pdfmake/pdfmake.min.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/pdfmake/vfs_fonts.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/datatables-buttons/js/buttons.print.min.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js') !!}"></script>
<!-- AdminLTE App -->
<script src="{!! URL::asset('assets/admin/dist/js/adminlte.min.js') !!}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{!! URL::asset('assets/admin/dist/js/demo.js') !!}"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#datas-list").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#datas-list_wrapper .col-md-6:eq(0)');

  });
</script>
</body>
</html>
