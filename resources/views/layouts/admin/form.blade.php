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
  <!-- daterange picker -->
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/daterangepicker/daterangepicker.css') !!}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') !!}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') !!}">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/select2/css/select2.min.css') !!}">
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') !!}">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') !!}">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/bs-stepper/css/bs-stepper.min.css') !!}">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="{!! URL::asset('assets/admin/plugins/dropzone/min/dropzone.min.css') !!}">
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
<!-- Select2 -->
<script src="{!! URL::asset('assets/admin/plugins/select2/js/select2.full.min.js') !!}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{!! URL::asset('assets/admin/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') !!}"></script>
<!-- InputMask -->
<script src="{!! URL::asset('assets/admin/plugins/moment/moment.min.js') !!}"></script>
<script src="{!! URL::asset('assets/admin/plugins/inputmask/jquery.inputmask.min.js') !!}"></script>
<!-- date-range-picker -->
<script src="{!! URL::asset('assets/admin/plugins/daterangepicker/daterangepicker.js') !!}"></script>
<!-- bootstrap color picker -->
<script src="{!! URL::asset('assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') !!}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{!! URL::asset('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
<!-- Bootstrap Switch -->
<script src="{!! URL::asset('assets/admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js') !!}"></script>
<!-- BS-Stepper -->
<script src="{!! URL::asset('assets/admin/plugins/bs-stepper/js/bs-stepper.min.js') !!}"></script>
<!-- dropzonejs -->
<script src="{!! URL::asset('assets/admin/plugins/dropzone/min/dropzone.min.js') !!}"></script>
<!-- AdminLTE App -->
<script src="{!! URL::asset('assets/admin/dist/js/adminlte.min.js') !!}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{!! URL::asset('assets/admin/dist/js/demo.js') !!}"></script>
<!-- Page specific script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })

  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode = document.querySelector("#template")
  previewNode.id = ""
  var previewTemplate = previewNode.parentNode.innerHTML
  previewNode.parentNode.removeChild(previewNode)

  var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    url: "/target-url", // Set the url
    thumbnailWidth: 80,
    thumbnailHeight: 80,
    parallelUploads: 20,
    previewTemplate: previewTemplate,
    autoQueue: false, // Make sure the files aren't queued until manually added
    previewsContainer: "#previews", // Define the container to display the previews
    clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
  })

  myDropzone.on("addedfile", function(file) {
    // Hookup the start button
    file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
  })

  // Update the total progress bar
  myDropzone.on("totaluploadprogress", function(progress) {
    document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
  })

  myDropzone.on("sending", function(file) {
    // Show the total progress bar when upload starts
    document.querySelector("#total-progress").style.opacity = "1"
    // And disable the start button
    file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
  })

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone.on("queuecomplete", function(progress) {
    document.querySelector("#total-progress").style.opacity = "0"
  })

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions .start").onclick = function() {
    myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
  }
  document.querySelector("#actions .cancel").onclick = function() {
    myDropzone.removeAllFiles(true)
  }
  // DropzoneJS Demo Code End
</script>
</body>
</html>