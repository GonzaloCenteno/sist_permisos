<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>SISTEMA PERMISOS</title>
        <!-- Tell the browser to be responsive to screen width -->
        <!-- Font Awesome -->
        <link rel="icon" type="image/png" href="{{ asset('img/bus-home.png') }}" />
        <link href="{{ asset('plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
        <!-- Theme style -->
        <link href="{{ asset('dist/css/adminlte.min.css') }}" rel="stylesheet">
        <!-- iCheck -->
        <link href="{{ asset('plugins/iCheck/flat/blue.css') }}" rel="stylesheet">
        <!-- Morris chart -->
        <link href="{{ asset('plugins/morris/morris.css') }}" rel="stylesheet">
        <!-- jvectormap -->
        <link href="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet">
        <link href="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet">

        <link href="{{ asset('css/smartadmin-production-plugins.min.css') }}" rel="stylesheet" type="text/css" media="screen">
        <link href="{{ asset('css/smartadmin-production.min.css') }}" rel="stylesheet">
        
        <link href="{{ asset('css/ui.jqgrid.css') }}" rel="stylesheet">
        <link href="{{ asset('css/ui.jqgrid-bootstrap4.css') }}" rel="stylesheet">
        <link href="{{ asset('css/sweetalert2.css') }}" rel="stylesheet"> 
        <link href="{{ asset('plugins/select2/select2.min.css') }}" rel="stylesheet">
        <link href="{{ asset('DataTablesAll/datatables.min.css') }}">
        <link href="{{ asset('css/jquery-confirm.min.css') }}" rel="stylesheet"> 
        
        <style>
            .ui-jqgrid {
                /*display: flex;*/
                flex-direction: column;
                flex:1 1 auto;
                width:auto !important;
              }
              .ui-jqgrid > .ui-jqgrid-view
              {
                display:flex;
                flex:1 1 auto;
                flex-direction:column;
                overflow:auto;
                width:auto !important;
              }

               .ui-jqgrid > .ui-jqgrid-view,
               .ui-jqgrid > .ui-jqgrid-view > .ui-jqgrid-bdiv {
                    flex:1 1 auto;
                    width: auto !important;
              }

              .ui-jqgrid > .ui-jqgrid-pager,
              .ui-jqgrid > .ui-jqgrid-view > .ui-jqgrid-hdiv {
                  flex: 0 1 auto;
                width: auto !important;
              }
              /* enable scrollbar */
              .ui-jqgrid-bdiv {
                  overflow: auto
              }
              .fa-square-o{
                  cursor: pointer;
              }
              .fa-check-square-o{
                  cursor: pointer;
              }
              .marcador{
                  cursor: pointer;
              }
        </style>
    </head>
    <body class="hold-transition sidebar-mini" id="body_push">
        
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>

        <!-- jQuery -->
        <script type="text/javascript" src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
        <!-- jQuery UI 1.11.4 -->
        <script type="text/javascript" src="{{ asset('js/jquery-ui.js') }}"></script>
        <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
        <script type="text/javascript" src="{{ asset('js/jquery.jqGrid.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/grid.locale-es.js') }}"></script>
        
        <script type="text/javascript" src="{{ asset('js/block_ui.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/jquery-confirm.min.js') }}"></script>
        
        <script type="text/javascript" src="{{ asset('DataTablesAll/datatables.min.js') }}"></script>
        <script>
            $.widget.bridge('uibutton', $.ui.button)
        </script>
        <!-- Bootstrap 4 -->
        <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Sparkline -->
        <script type="text/javascript" src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
        <!-- jQuery Knob Chart -->
        <script type="text/javascript" src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script type="text/javascript" src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
        <!-- Slimscroll -->
        <script type="text/javascript" src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
        <!-- FastClick -->
        <script type="text/javascript" src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script type="text/javascript" src="{{ asset('dist/js/adminlte.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script type="text/javascript" src="{{ asset('js/sweetalert2.js') }}"></script>
        <script type="text/javascript" src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('archivos_js/funciones_globales.js') }}"></script>
        @yield('page-js-script')
    </body>
</html>
