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
        <div class="row">
            <h3 class="m-0">MANTENIMIENTO ROLES</h3>&nbsp;&nbsp;&nbsp;
            <button type="button" onclick="window.close();" class="btn btn-danger"><i class="fa fa-reply"></i> REGRESAR</button>
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
    </div>
    <div class="card-body">
        <!--        <div class="col-lg-12">
                    <center>
                        <button id="btn_nueva_capacidad" type="button" class="btn btn-xl btn-danger" readonly="readonly"><i class="fa fa-plus-square"></i> CREAR CAPACIDAD</button>
                        <button id="btn_modificar_capacidad" type="button" class="btn btn-xl btn-warning" readonly="readonly"><i class="fa fa-pencil"></i> MODIFICAR CAPACIDAD</button></center>
                </div>
                <br>-->
        <div class="form-group col-md-12">
            <div class="form-group col-md-12" id="contenedor">
                <table id="tblsistemas_sist"></table>
                <div id="paginador_tblsistemas_sist"></div>                         
            </div>
        </div>
    </div>
</div><!-- /.card -->

<div class="modal fade" id="ModalRoles">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span></button>
            </div>

            <div class="modal-body">
                <div class="row col-md-12">
                    <div class="card card-danger card-outline col-md-4">
                        <div class="card-header">
                            <h5 class="m-0">ROLES</h5>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="form-group">
                                        <table id="tblroles_rol"></table>
                                        <div id="paginador_tblroles_rol"></div>                                                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row col-md-8">
                        <div class="card card-danger card-outline col-md-12">
                            <div class="card-header">
                                <h5 class="m-0">MENU</h5>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2 text-center align-self-center">
                                        <div class="form-group">
                                            <button type="button" id="btn_agregar_menus_rol" class="btn btn-warning rounded-circle"><i class="fa fa-pencil-square-o fa-4x"></i></button>                                                                 
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="btn_orden_menu_rol" class="btn btn-warning rounded-circle"><i class="fa fa-list-ol fa-4x"></i></button>                                                                 
                                        </div>
                                    </div>
                                    <div class="col-md-10 text-center tablaMenus">
                                        <div class="form-group">
                                            <table id="tblmenu_men"></table>
                                            <div id="paginador_tblmenu_men"></div>                                                                   
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
                                    <div class="col-md-2 text-center align-self-center">
                                        <div class="form-group">
                                            <button type="button" id="btn_agregar_submenus_rol" class="btn btn-danger rounded-circle"><i class="fa fa-pencil-square-o fa-4x"></i></button>                                                                 
                                        </div>
                                        <div class="form-group">
                                            <button type="button" id="btn_orden_submenu_rol" class="btn btn-danger rounded-circle"><i class="fa fa-list-ol fa-4x"></i></button>                                                                 
                                        </div>
                                    </div>
                                    <div class="col-md-10 tblsubmenu_sme">
                                        <div class="form-group">
                                            <table id="tblsubmenu_sme"></table>
                                            <div id="paginador_tblsubmenu_sme"></div>                                                                   
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

<div class="modal fade" id="ModalMenu">
    <div class="modal-dialog modal-xs modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span></button>
            </div>

            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-menu-tab" data-toggle="tab" href="#nav-menu" role="tab" aria-controls="nav-menu" aria-selected="true">MENU</a>
                        <a class="nav-item nav-link" id="nav-submenu-tab" data-toggle="tab" href="#nav-submenu" role="tab" aria-controls="nav-submenu" aria-selected="false">SUB-MENU</a>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <br>
                    <div class="tab-pane fade show active" id="nav-menu" role="tabpanel" aria-labelledby="nav-menu-tab">
                        <div class="form-group">
                            <label>DESCRIPCION:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-tasks"></i></span>
                                </div>
                                <input type="text" id="txt_menu_descripcion" class="form-control text-center text-uppercase" placeholder="ESCRIBIR DESCRIPCION - MENU">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>TITULO:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-tasks"></i></span>
                                </div>
                                <input type="text" id="txt_menu_titulo" class="form-control text-center text-uppercase" placeholder="ESCRIBIR TITULO - MENU">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>SISTEMA:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-tasks"></i></span>
                                </div>
                                <input type="text" id="txt_menu_sistema" class="form-control text-center text-uppercase" placeholder="ESCRIBIR MENU SISTEMA - MENU">
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="button" id="btn_crear_menu" class="btn btn-primary btn-xl"><i class="fa fa-plus-circle"></i> GUARDAR</button>
                            <button type="button" id="btn_cerrar_modal" class="btn btn-danger btn-xl" data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i> CERRAR</button>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-submenu" role="tabpanel" aria-labelledby="nav-submenu-tab">
                        <div class="tab-pane fade show active" id="nav-menu" role="tabpanel" aria-labelledby="nav-menu-tab">
                            <div class="form-group">
                                <label>DESCRIPCION:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tasks"></i></span>
                                    </div>
                                    <input type="text" id="txt_submenu_descripcion" class="form-control text-center text-uppercase" placeholder="ESCRIBIR DESCRIPCION - SUBMENU">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>TITULO:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tasks"></i></span>
                                    </div>
                                    <input type="text" id="txt_submenu_titulo" class="form-control text-center text-uppercase" placeholder="ESCRIBIR TITULO - SUBMENU">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>SISTEMA:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tasks"></i></span>
                                    </div>
                                    <input type="text" id="txt_submenu_sistema" class="form-control text-center text-uppercase" placeholder="ESCRIBIR MENU SISTEMA - SUBMENU">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>RUTA:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-tasks"></i></span>
                                    </div>
                                    <input type="text" id="txt_submenu_ruta" class="form-control text-center text-uppercase" placeholder="ESCRIBIR RUTA SISTEMA - SUBMENU">
                                </div>
                            </div>

                            <div class="form-group text-center">
                                <button type="button" id="btn_crear_submenu" class="btn btn-primary btn-xl"><i class="fa fa-plus-circle"></i> GUARDAR</button>
                                <button type="button" id="btn_cerrar_modal" class="btn btn-danger btn-xl" data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i> CERRAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalOrdenarMenu">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span></button>
            </div>
            
            <form id="FormularioOrdenMenu" name="FormularioOrdenMenu" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">TITULO</th>
                                    <th scope="col">DESCRIPCION</th>
                                    <th scope="col">ORDEN</th>
                                </tr>
                            </thead>
                            <tbody id="detalle_orden_menu">


                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            <div class="modal-footer">
                <button type="button" id="btn_editar_orden_menu" class="btn btn-primary btn-xl"><i class="fa fa-pencil-square"></i> MODIFICAR</button>
                <button type="button" id="btn_cerrar_modal_orden_menu" class="btn btn-danger btn-xl" data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i> CERRAR</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalOrdenarSubmenu">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span></button>
            </div>
            
            <form id="FormularioOrdenSubMenu" name="FormularioOrdenSubMenu" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">TITULO</th>
                                    <th scope="col">DESCRIPCION</th>
                                    <th scope="col">ORDEN</th>
                                </tr>
                            </thead>
                            <tbody id="detalle_orden_submenu">


                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            <div class="modal-footer">
                <button type="button" id="btn_editar_orden_submenu" class="btn btn-primary btn-xl"><i class="fa fa-pencil-square"></i> MODIFICAR</button>
                <button type="button" id="btn_cerrar_modal_orden_submenu" class="btn btn-danger btn-xl" data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i> CERRAR</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalCrearRol">
    <div class="modal-dialog modal-xs modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span></button>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label>SISTEMA SELECCIONADO:</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-tasks"></i></span>
                        </div>
                        <input type="text" id="txt_sro_sist_id" class="form-control text-center" disabled="disabled">
                    </div>

                </div>
                
                <div class="form-group">
                    <label>DESCRIPCION ROL:</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-tasks"></i></span>
                        </div>
                        <input type="text" id="txt_sro_descripcion" class="form-control text-center text-uppercase" placeholder="ESCRIBIR DESCRIPCION ROL" maxlength="80">
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" id="btn_crear_rol" class="btn btn-success btn-xl"><i class="fa fa-plus-square"></i> CREAR</button>
                <button type="button" id="btn_cerrar_modal_crear_rol" class="btn btn-danger btn-xl" data-dismiss="modal"><i class="fa fa-times-rectangle-o"></i> CERRAR</button>
            </div>
        </div>
    </div>
</div>

@section('page-js-script')
<script language="JavaScript" type="text/javascript" src="{{ asset('archivos_js/general/roles.js') }}"></script>
@stop
@endsection