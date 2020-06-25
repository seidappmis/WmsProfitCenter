<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="WMS Sharp.">
  <meta name="keywords" content="WMS Sharp.">
  <meta property="og:title" content="Wms-sharp" />
  <meta property="og:image" content="{{ url('favicon.ico') }}" />
  <meta property="og:url" content="/" />
  <meta property="og:site_name" content="WMS SEID" />
  <meta property="og:description" content="WMS SEID." />
  <meta name="author" content="ThemeSelect">
  <title>SEID - Warehouse Management System</title>
  <link rel="apple-touch-icon" href="{{ url('favicon.ico') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ url('favicon.ico') }}">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- BEGIN: VENDOR CSS-->
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/vendors/vendors.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/vendors/data-tables/css/jquery.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/vendors/data-tables/css/select.dataTables.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/vendors/data-tables/css/dataTables.checkboxes.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/css/pages/data-tables.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/vendors/sweetalert/sweetalert.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/vendors/select2/css/select2.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/vendors/select2/css/select2-materialize.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/vendors/dropify/css/dropify.min.css') }}">
  @stack('vendor_css')

  <!-- END: VENDOR CSS-->
  <!-- BEGIN: Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/css/themes/vertical-modern-menu-template/materialize.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/css/themes/vertical-modern-menu-template/style.css') }}">
  <!-- END: Page Level CSS-->
  <!-- BEGIN: Custom CSS-->
  <link rel="stylesheet" type="text/css" href="{{ url('materialize/css/custom/custom.css') }}">
  @stack('script_css')
  <!-- END: Custom CSS-->
</head>
<!-- END: Head-->

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu 2-columns  "
  data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">

  @include('layouts.materialize.header')
  @include('layouts.materialize.sidenav')

  <!-- BEGIN: Page Main-->
  <div id="main">
    @yield('content')
  </div>
  <!-- END: Page Main-->

  @stack('page-modal')
  <!-- BEGIN: Footer-->

  <footer class="page-footer footer footer-static footer-dark gradient-shadow navbar-border navbar-shadow">
    <div class="footer-copyright">
      <div class="container"><span>&copy; 2020 <a href="http://themeforest.net/user/pixinvent/portfolio?ref=pixinvent"
            target="_blank">WMS SEID</a> All rights reserved.</span><span class="right hide-on-small-only">Design and
          Developed by <a href="https://pixinvent.com/">WMS SEID</a></span></div>
    </div>
  </footer>

  <!-- END: Footer-->
  <!-- BEGIN VENDOR JS-->
  <script src="{{ url('materialize/js/vendors.min.js') }}" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{ url('materialize/vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ url('materialize/vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}">
  </script>
  <script src="{{ url('materialize/vendors/data-tables/js/dataTables.select.min.js') }}"></script>
  <script src="{{ url('materialize/vendors/data-tables/js/datatables.checkboxes.min.js') }}"></script>
  <script src="{{ url('materialize/vendors/sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ url('materialize/vendors/select2/js/select2.full.min.js') }}"></script>
  <script src="{{ url('materialize/vendors/dropify/js/dropify.min.js') }}"></script>
  <script src="{{ url('materialize/vendors/form_repeater/jquery.repeater.min.js') }}"></script>
  {{-- <script src="https://cdn.tiny.cloud/1/owjs6t5ywvk0rxqa5rd4xmlg8f2vg4c04wnstf7esi5sctw5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> --}}


  @stack('vendor_js')
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN THEME  JS-->
  <script src="{{ url('materialize/js/plugins.js') }}" type="text/javascript"></script>
  <script src="{{ url('materialize/js/custom/custom-script.js') }}" type="text/javascript"></script>

  <!-- END THEME  JS-->
  <!-- BEGIN PAGE LEVEL JS-->


  @include('layouts.materialize.page-settings')
  <!-- END PAGE LEVEL JS-->
  @stack('script_js')
</body>

</html>