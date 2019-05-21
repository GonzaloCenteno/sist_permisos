@extends('principal.p_inicio')

@section('content')
<style>
    .modal-lg { 
        max-width: 85% !important;
        padding-left: 50px;
    }
</style>
<br>
<div class="card card-danger card-outline">
    <div class="card-header">
        <h4 class="m-0">MANTENIMIENTO USUARIOS</h4>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
    </div>
    <div class="card-body" id="contenedors">
        <!--        <div class="col-lg-12">
                    <center>
                        <button id="btn_nueva_capacidad" type="button" class="btn btn-xl btn-danger" readonly="readonly"><i class="fa fa-plus-square"></i> CREAR CAPACIDAD</button>
                        <button id="btn_modificar_capacidad" type="button" class="btn btn-xl btn-warning" readonly="readonly"><i class="fa fa-pencil"></i> MODIFICAR CAPACIDAD</button></center>
                </div>
                <br>-->
        <div class="col-xs-12 center-block">
            <table id="TblUsuarios" class="table table-bordered dt-responsive compact">
                <thead>
                    <tr>
                        <th style="width: 20%;background-color: #DB3543; color: white;">USUARIO</th>
                        <th style="width: 30%;background-color: #DB3543; color: white;">NOMBRES</th>
                        <th style="width: 30%;background-color: #DB3543; color: white;">CORREO</th>
                        <th style="width: 40%;background-color: #DB3543; color: white;">NOMBRE DISTINGUIDO</th>
                        <th style="width: 10%;background-color: #DB3543; color: white;">ESTADO</th>
                        <th style="width: 5%;background-color: #DB3543; color: white;">ASIGNAR</th>
                        <th style="width: 5%;background-color: #DB3543; color: white;">VER</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div><!-- /.card -->

<div class="modal fade" id="ModalRolesPermisos">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span></button>
            </div>

            <div class="modal-body">
                <div class="row col-md-12">
                    <div class="card card-danger card-outline col-md-3">
                        <div class="card-header">
                            <h5 class="m-0">SISTEMAS ASIGNADOS</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <table id="tablaSistemas"></table>
                                        <div id="paginador_tablaSistemas"></div>                                                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-danger card-outline col-md-3">
                        <div class="card-header">
                            <h5 class="m-0">ROL - ASIGNADO</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <table id="tablaRoles"></table>
                                        <div id="paginador_tablaRoles"></div>                                                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row col-md-6">
                        <div class="card card-danger card-outline col-md-12">
                            <div class="card-header">
                                <h5 class="m-0">MENU</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 text-center">
                                        <div class="form-group"> 
                                            <table id="tablaMenus"></table>
                                            <div id="paginador_tablaMenus"></div>                                                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card card-danger card-outline col-md-12">
                            <div class="card-header">
                                <h5 class="m-0">SUB - MENU</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 tablaSubMenus"> 
                                        <div class="form-group">
                                            <table id="tablaSubMenus"></table>
                                            <div id="paginador_tablaSubMenus"></div>                                                                   
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="btn_cerrar_modal" class="btn btn-danger btn-xl" data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i> CERRAR</button>
            </div>
        </div>
    </div>
</div>

@section('page-js-script')
<script language="JavaScript" type="text/javascript" src="{{ asset('archivos_js/general/usuarios.js') }}"></script>
@stop

@endsection


