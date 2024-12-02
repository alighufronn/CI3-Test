<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= isset($title) ? $title : 'Dashboard'; ?></title>


  <script src="<?php echo('https://code.jquery.com/jquery-3.7.0.min.js')?>"></script>
  <script src="<?= base_url('assets/AdminLTE/plugins/jquery/jquery.min.js') ?>"></script>

   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="<?php echo('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') ?>">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/fontawesome-free/css/all.min.css') ?>">
   <!-- daterange picker -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/daterangepicker/daterangepicker.css') ?>">
   <!-- iCheck for checkboxes and radio inputs -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
   <!-- Bootstrap Color Picker -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') ?>">
   <!-- Tempusdominus Bootstrap 4 -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
   <!-- Select2 -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/select2/css/select2.min.css') ?>">
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
   
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')?>">
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/fullcalendar/main.min.css') ?>">
   <!-- Theme style -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/dist/css/adminlte.min.css') ?>">
   <!-- Bootstrap4 Duallistbox -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') ?>">
   <!-- BS Stepper -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/bs-stepper/css/bs-stepper.min.css') ?>">
   <!-- dropzonejs -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/dropzone/min/dropzone.min.css') ?>">
  <!-- SweetAlert2 -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.css') ?>">
   <!-- Toastr -->
   <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/toastr/toastr.min.css') ?>">
   <!-- Theme style -->
   <!-- Multiselect style -->
   <!-- <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/dist/css/style.css') ?>"> -->
   <!-- DataTables -->
   <link rel="stylesheet" href="<?php echo('https://cdn.datatables.net/2.1.5/css/dataTables.jqueryui.min.css') ?>">


   <!-- <link rel="stylesheet" href="<?php echo('https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css') ?>">
   <link rel="stylesheet" href="<?php echo('https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css') ?>"> -->

    
    <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins//datatables-fixedcolumns/css/fixedColumns.bootstrap4.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/datatables-fixedcolumns/css/fixedColumns.bootstrap4.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/plugins/datatables-select/css/select.bootstrap4.min.css') ?>">


    <!-- Lightbox -->
    <link href="<?php echo('https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css')?>" rel="stylesheet">


   <!-- DataTables Editor -->
    <link rel="stylesheet" href="<?php echo('https://cdn.datatables.net/2.1.7/css/dataTables.dataTables.css') ?>">
    <link rel="stylesheet" href="<?php echo('https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css') ?>">
    <link rel="stylesheet" href="<?php echo('https://cdn.datatables.net/select/2.1.0/css/select.dataTables.css') ?>">
    <link rel="stylesheet" href="<?php echo('https://cdn.datatables.net/datetime/1.5.4/css/dataTables.dateTime.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo('https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css') ?>">

    
    <link rel="stylesheet" href="<?php echo('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css') ?>">
    <script src="<?= base_url('assets/AdminLTE/plugins/moment/moment.min.js') ?>"></script>
    <script src="<?= base_url('assets/AdminLTE/plugins/fullcalendar/main.min.js') ?>"></script>

    <!-- <script src="<?php echo('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js') ?>"></script> -->
    <!-- <script src="<?php echo('https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js') ?>"></script> -->



  <style>
    
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

    <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= site_url('/') ?>" class="brand-link">
      <img src="<?= base_url('assets/AdminLTE/dist/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Test</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?= base_url('assets/AdminLTE/dist/img/user2-160x160.jpg') ?>" class="img-circle elevation-2" alt="User Image">
        </div>
          <div class="info">
            <a href="#" class="d-block"></a>
          </div>
          <div class="info">
            <a href="#" class="d-block">
            <?php if($logged_in): ?>
                <?php echo htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8'); ?>
            <?php endif; ?>
            </a>
          </div>

      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
          <li class="nav-item">
            <a href="<?= site_url('/') ?>" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Home</p>
            </a>
          </li>
          <li class="nav-header">Menu</li>
          <li class="nav-item">
            <a href="<?= site_url('calendar') ?>" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>Calendar</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?= site_url('') ?>" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>Menu 2</p>
            </a>
          </li>

          <li class="nav-header">Settings</li>
          <?php if($role === 'admin'): ?>
            <li class="nav-item">
              <a href="<?= site_url('users') ?>" class="nav-link">
                <i class="nav-icon fas fa-circle"></i>
                <p>User</p>
              </a>
            </li>
          <?php endif; ?>
          <li class="nav-item">
            <a href="<?= site_url('logout') ?>" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>Logout</p>
            </a>
          </li>

          

        </ul>
      </nav>
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= isset($pageTitle) ? $pageTitle : 'Dashboard'; ?></h1>
            <?= isset($underTitle); ?>
          </div>
          <div class="col-sm-6">

            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
            </ol>

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
     <section class="content">
      <div class="container-fluid">
        
        <?php if(isset($content)) echo $content; ?>

      </div>
    </section>
    <!-- End Main Content -->
     
  
</div>
<!-- Footer -->
<footer class="main-footer">
  
  <strong><a class="text-primary" href="<?= site_url('https://pmc.arista.co.id/pmc') ?>">PT. Arista Pratama Jaya.</a></strong>
</footer>
<!-- End Footer -->



<!-- <script>
    document.addEventListener('DOMContentLoaded', (event) => {
        swal({ title: 'Hello!', text: 'SweetAlert is working!', icon: 'success' });
    });
</script> -->

<script>
        $(document).ready(function() {
          var myVariable = {
            adjust: function() {
              console.log("Adjust function called");
            }
          };

          if (myVariable && typeof myVariable.adjust === "function") {
            myVariable.adjust();
          } else {
            console.log("Adjust function is not defined");
          };
        });
</script>

<script src="<?php echo('https://malsup.github.io/jquery.cycle.all.js') ?>"></script>
<script type="text/javascript" charset="utf8" src="<?php echo('https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js') ?>"></script>
<script src="<?php echo('https://cdn.datatables.net/2.1.5/js/dataTables.min.js')?>"></script> 
<script src="<?php echo('https://cdn.datatables.net/2.1.5/js/dataTables.jqueryui.min.js')?>"></script>
<script src="<?php echo('https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js') ?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?php echo('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js') ?>"></script>
<!-- jQuery -->
<!-- jQuery UI 1.11.4 -->
<script src="<?= base_url('assets/AdminLTE/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Toastr -->
<script src="<?= base_url('assets/AdminLTE/plugins/toastr/toastr.min.js') ?>"></script>

<!-- Bootstrap 4 -->
<script src="<?= base_url('assets/AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('assets/AdminLTE/plugins/select2/js/select2.full.min.js') ?>"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?= base_url('assets/AdminLTE/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') ?>"></script>
<!-- InputMask -->
<script src="<?= base_url('assets/AdminLTE/plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/inputmask/jquery.inputmask.min.js') ?>"></script>
<!-- date-range-picker -->
<script src="<?= base_url('assets/AdminLTE/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<!-- bootstrap color picker -->
<script src="<?= base_url('assets/AdminLTE/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') ?>"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= base_url('assets/AdminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>
<!-- Bootstrap Switch -->
<script src="<?= base_url('assets/AdminLTE/plugins/bootstrap-switch/js/bootstrap-switch.min.js') ?>"></script>
<!-- BS-Stepper -->
<script src="<?= base_url('assets/AdminLTE/plugins/bs-stepper/js/bs-stepper.min.js') ?>"></script>
<!-- dropzonejs -->
<script src="<?= base_url('assets/AdminLTE/plugins/dropzone/min/dropzone.min.js') ?>"></script>
<!-- DataTables  & Plugins -->
<script src="<?= base_url('assets/AdminLTE/plugins/datatables/jquery.dataTables.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/jszip/jszip.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/pdfmake/pdfmake.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/pdfmake/vfs_fonts.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-buttons/js/buttons.colVis.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-fixedcolumns/js/dataTables.fixedColumns.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-fixedcolumns/js/fixedColumns.bootstrap4.min.js')?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-select/js/dataTables.select.min.js') ?>"></script>
<script src="<?= base_url('assets/AdminLTE/plugins/datatables-select/js/select.bootstrap4.min.js') ?>"></script>


<!-- DataTables Editor -->
 
 <script src="<?php echo('https://cdn.datatables.net/datetime/1.5.4/js/dataTables.dateTime.min.js
 ') ?>"></script>

<!-- Ellipsis -->
<script src="<?php echo('https://cdn.datatables.net/plug-ins/2.1.7/dataRender/ellipsis.js') ?>"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('assets/AdminLTE/dist/js/adminlte.min.js') ?>"></script>
<!-- AdminLTE for demo purposes -->
<!-- overlayScrollbars -->
<script src="<?= base_url('assets/AdminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>

<!-- Ekko Lightbox -->
<script src="<?= base_url('assets/AdminLTE/plugins/ekko-lightbox/ekko-lightbox.min.js')?>"></script>

<script>
  
</script>

<!-- DataTables -->

<!-- <script>
    $(document).ready(function() {
      var table = $('#myTable').DataTable({
          scrollX: true,
          paging: true,
          lengthChange: true,
          searching: true,
          ordering: true,
          info: true,
          autoWidth: false,
          responsive: true,
          fixedHeader: true,
      });

      table.on('length.dt', function() {
          table.columns.adjust();
      });

      $('#myTable tbody').on('click', 'tr', function() {
        var data = table.row(this).data();
        var id = data[0];
        window.location.href = '/details/' + id;
      });
    });

    $(window).on('resize', function() {
      $('#myTable').DataTable().columns.adjust();
    });

    $('#myTable').on('draw.dt', function() {
      $('#myTable').DataTable().columns.adjust();
    });

</script> -->

<!-- End DataTables -->
 
<!-- Page specific script -->
<script>
    // $(function () {
    //   $("#example1").DataTable({
    //     "responsive": true, 
    //     "lengthChange": false, 
    //     "autoWidth": true,
    //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    //   }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    //   $('#example2').DataTable({
    //     "paging": true,
    //     "lengthChange": false,
    //     "searching": true,
    //     "ordering": true,
    //     "info": true,
    //     "autoWidth": true,
    //     "responsive": true,
    //     scrollX: true,
    //   });
    //   table.column.adjust();
    // });

    $(document).ready(function() {
      let table1 = $("#example1").DataTable({
          "responsive": true, 
          "lengthChange": false, 
          "autoWidth": false,
          "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      
      let table2 = $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false,
          "responsive": true,
          "scrollX": true,
      });
    });

  </script>

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
    // document.addEventListener('DOMContentLoaded', function () {
    //   window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    // })
  
    // DropzoneJS Demo Code Start
    // Dropzone.autoDiscover = false
  
    // // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
    // var previewNode = document.querySelector("#template")
    // previewNode.id = ""
    // var previewTemplate = previewNode.parentNode.innerHTML
    // previewNode.parentNode.removeChild(previewNode)
  
    // var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
    //   url: "/target-url", // Set the url
    //   thumbnailWidth: 80,
    //   thumbnailHeight: 80,
    //   parallelUploads: 20,
    //   previewTemplate: previewTemplate,
    //   autoQueue: false, // Make sure the files aren't queued until manually added
    //   previewsContainer: "#previews", // Define the container to display the previews
    //   clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
    // })
  
    // myDropzone.on("addedfile", function(file) {
    //   // Hookup the start button
    //   file.previewElement.querySelector(".start").onclick = function() { myDropzone.enqueueFile(file) }
    // })
  
    // // Update the total progress bar
    // myDropzone.on("totaluploadprogress", function(progress) {
    //   document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
    // })
  
    // myDropzone.on("sending", function(file) {
    //   // Show the total progress bar when upload starts
    //   document.querySelector("#total-progress").style.opacity = "1"
    //   // And disable the start button
    //   file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
    // })
  
    // // Hide the total progress bar when nothing's uploading anymore
    // myDropzone.on("queuecomplete", function(progress) {
    //   document.querySelector("#total-progress").style.opacity = "0"
    // })
  
    // // Setup the buttons for all transfers
    // // The "add files" button doesn't need to be setup because the config
    // // `clickable` has already been specified.
    // document.querySelector("#actions .start").onclick = function() {
    //   myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
    // }
    // document.querySelector("#actions .cancel").onclick = function() {
    //   myDropzone.removeAllFiles(true)
    // }
    // DropzoneJS Demo Code End
  </script>

  <!-- Modal -->
  <script>
    $(function() {
      var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      $('.swalDefaultSuccess').click(function() {
        Toast.fire({
          icon: 'success',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.swalDefaultInfo').click(function() {
        Toast.fire({
          icon: 'info',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.swalDefaultError').click(function() {
        Toast.fire({
          icon: 'error',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.swalDefaultWarning').click(function() {
        Toast.fire({
          icon: 'warning',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.swalDefaultQuestion').click(function() {
        Toast.fire({
          icon: 'question',
          title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });

      $('.toastrDefaultSuccess').click(function() {
        toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      });
      $('.toastrDefaultInfo').click(function() {
        toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      });
      $('.toastrDefaultError').click(function() {
        toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      });
      $('.toastrDefaultWarning').click(function() {
        toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
      });

      $('.toastsDefaultDefault').click(function() {
        $(document).Toasts('create', {
          title: 'Toast Title',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultTopLeft').click(function() {
        $(document).Toasts('create', {
          title: 'Toast Title',
          position: 'topLeft',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultBottomRight').click(function() {
        $(document).Toasts('create', {
          title: 'Toast Title',
          position: 'bottomRight',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultBottomLeft').click(function() {
        $(document).Toasts('create', {
          title: 'Toast Title',
          position: 'bottomLeft',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultAutohide').click(function() {
        $(document).Toasts('create', {
          title: 'Toast Title',
          autohide: true,
          delay: 750,
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultNotFixed').click(function() {
        $(document).Toasts('create', {
          title: 'Toast Title',
          fixed: false,
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultFull').click(function() {
        $(document).Toasts('create', {
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          icon: 'fas fa-envelope fa-lg',
        })
      });
      $('.toastsDefaultFullImage').click(function() {
        $(document).Toasts('create', {
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          image: '../../dist/img/user3-128x128.jpg',
          imageAlt: 'User Picture',
        })
      });
      $('.toastsDefaultSuccess').click(function() {
        $(document).Toasts('create', {
          class: 'bg-success',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultInfo').click(function() {
        $(document).Toasts('create', {
          class: 'bg-info',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultWarning').click(function() {
        $(document).Toasts('create', {
          class: 'bg-warning',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultDanger').click(function() {
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
      $('.toastsDefaultMaroon').click(function() {
        $(document).Toasts('create', {
          class: 'bg-maroon',
          title: 'Toast Title',
          subtitle: 'Subtitle',
          body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
      });
    });
  </script>
</body>
</html>
