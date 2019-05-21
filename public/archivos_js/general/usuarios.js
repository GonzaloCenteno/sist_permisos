jQuery(document).ready(function($){
    $("#TblUsuarios").DataTable({
        "lengthMenu": [[15, 50, 100, -1], [15, 50, 100, "Todo"]],
        "info": true,
        "ordering": true,
        "destroy":true,
        "searching": true,
        "responsive": true,
        "paging": true,
        "autoWidth": false,
        "ajax": "usuarios/0?tabla=usuarios",
        "columns":[
            {data: 'cn',class:'text-center'},
            {data: 'displayname',class:'text-center'},
            {data: 'userprincipalname',class:'text-center'},
            {data: 'dn',class:'text-center',searchable: false,orderable: false,visible:false},
            {data: 'estado',class:'text-center',orderable: false},
            {data: 'asignar',class:'text-center',searchable: false,orderable: false},
            {data: 'ver',class:'text-center',searchable: false,orderable: false}
        ],
        "columnDefs":[
            {
                "targets": [5], 
                "data": "asignar", 
                "render": function(data, type, row) 
                {
                    return '<button type="button" class="btn btn-success btn-xs btn-block" onClick="btn_asginar_sistemas_rol(\''+row.cn+'\',\''+row.dn+'\')"><span class="btn-label"><i class="fa fa-plus"></i></span> ASIGNAR</button>';
                }
            },
            {
                "targets": [6], 
                "data": "ver", 
                "render": function(data, type, row) 
                {
                    return '<button type="button" onClick="ver_permisos_usuario(\''+row.cn+'\')" class="btn btn-warning btn-xs btn-block"><span class="btn-label"><i class="fa fa-pencil"></i></span> EDITAR</button>';
                }
            }
        ],
        "order": [[ 1, "desc" ]],
                "language" : idioma_espanol,
        select: {
            style: 'single'
        }
                
    });
    
    $('.dataTables_filter input[type="search"]').css(
        {'width':'605px','display':'inline-block'}
    );

    $('.dataTables_filter input[type="search"]').attr("placeholder","FILTRO DE BUSQUEDA POR TODOS LOS CAMPOS");

    $('select[name="TblUsuarios_length"]').css(
        {'width':'240px','display':'inline-block'}
    );
    
    jQuery("#tablaSistemas").jqGrid({
        url: '',
        datatype: 'json', mtype: 'GET',
        height: '470px', autowidth: false,
        toolbarfilter: true,
        colNames: ['ID', 'DESCRIPCION', 'RUTA', 'USUARIO'],
        rowNum: 10, sortname: 'sist_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE SISTEMAS', align: "center",
        colModel: [
            {name: 'sist_id', index: 'sist_id', align: 'center',width: 50, hidden:true},
            {name: 'sist_desc', index: 'sist_desc', align: 'left', width: 115},
            {name: 'sist_rut', index: 'sist_rut', align: 'left', width: 159},
            {name: 'usuario', index: 'usuario', align: 'left', width: 10,hidden:true}
        ],
        pager: '#paginador_tablaSistemas',
        rowList: [10, 20, 30, 40, 50],
        gridComplete: function () {
            var idarray = jQuery('#tablaSistemas').jqGrid('getDataIDs');
            if (idarray.length > 0) {
            var firstid = jQuery('#tablaSistemas').jqGrid('getDataIDs')[0];
                    $("#tablaSistemas").setSelection(firstid);    
                }
        },
        onSelectRow: function (Id)
        {
            fn_llamar_roles_sistema(Id);
        }
    });
    
    jQuery("#tablaRoles").jqGrid({
        url: '',
        datatype: 'json', mtype: 'GET',
        height: '470px', autowidth: false,
        toolbarfilter: true,
        colNames: ['ID', 'DESCRIPCION'],
        rowNum: 10, sortname: 'sro_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE ROLES', align: "center",
        colModel: [
            {name: 'sro_id', index: 'sro_id', align: 'center',width: 60,hidden:true},
            {name: 'sro_descripcion', index: 'sro_descripcion', align: 'center', width: 274}
        ],
        pager: '#paginador_tablaRoles',
        rowList: [10, 20, 30, 40, 50],
        gridComplete: function () {
            var idarray = jQuery('#tablaRoles').jqGrid('getDataIDs');
            if (idarray.length > 0) {
            var firstid = jQuery('#tablaRoles').jqGrid('getDataIDs')[0];
                    $("#tablaRoles").setSelection(firstid);    
                }
        },
        loadComplete: function(data){ 
            if (data.total == 0) 
            {
                jQuery("#tablaMenus").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_menus&sro_id=0&usuario=0'}).trigger('reloadGrid');    
            }
        },
        onSelectRow: function (Id)
        {
            fn_llamar_menus_roles(Id);
        }
    });
    
    jQuery("#tablaMenus").jqGrid({
        url: '',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: false,
        toolbarfilter: true,
        colNames: ['ID', 'TITULO','DESCRIPCION','MENU SISTEMA'],
        rowNum: 100, sortname: 'men_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE MENUS', align: "center",
        colModel: [
            {name: 'men_id', index: 'men_id', align: 'center',width: 50,hidden:true},
            {name: 'men_titulo', index: 'men_titulo', align: 'left', width: 170},
            {name: 'men_descripcion', index: 'men_descripcion', align: 'left', width: 242},
            {name: 'men_sistema', index: 'men_sistema', align: 'left', width: 180}
        ],
        pager: '#paginador_tablaMenus',
        rowList: [],       
        pgbuttons: false,     
        pgtext: null,  
        sortable:false,
        cmTemplate: { sortable: false },
        gridComplete: function () {
            var idarray = jQuery('#tablaMenus').jqGrid('getDataIDs');
            if (idarray.length > 0) {
            var firstid = jQuery('#tablaMenus').jqGrid('getDataIDs')[0];
                    $("#tablaMenus").setSelection(firstid);    
                }
        },
        loadComplete: function(data){ 
            if (data.total == 0) 
            {
                jQuery("#tablaSubMenus").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_submenus&sro_id=0&usuario=0&men_id=0&sist_id=0'}).trigger('reloadGrid');
            }
        },
        onSelectRow: function (Id)
        {
            fn_llamar_submenus_roles(Id);
        }
    });
    
    jQuery("#tablaSubMenus").jqGrid({
        url: '',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: false,
        toolbarfilter: true,
        colNames: ['ID', 'USUARIO', 'SRO_ID', 'MEN_ID', 'SIST_ID', 'TITULO', 'VER', 'CREAR', 'EDITAR', 'ELIMINAR', 'IMPRIMIR'],
        rowNum: 100, sortname: 'ume_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE MENUS', align: "center",
        colModel: [
            {name: 'ume_id', index: 'ume_id', align: 'center',width: 20,hidden:true},
            {name: 'ume_usuario', index: 'ume_usuario', align: 'left', width: 20,hidden:true},
            {name: 'sro_id', index: 'sro_id', align: 'left', width: 20,hidden:true},
            {name: 'men_id', index: 'men_id', align: 'left', width: 20,hidden:true},
            {name: 'sist_id', index: 'sist_id', align: 'left', width: 20,hidden:true},
            {name: 'sme_titulo', index: 'sme_titulo', align: 'left', width: 182},
            {name: 'btn_view', index: 'btn_view', align: 'center', width: 82,
            formatter:function (cellvalue, options, rowObject) 
            {
                var estado = (parseInt(cellvalue) == 0) ? 'fa fa-square-o' : 'fa fa-check-square-o';
                var valor = (parseInt(cellvalue) == 0) ? 1 : 0;
                var html = '<i style="width:100%" class="'+estado+' fa-3x" aria-hidden="true" onclick="cambiar_permiso_usuario('+rowObject[0]+',\'btn_view\','+valor+')"></i>';
                return html;                                                                        
            }},
            {name: 'btn_new', index: 'btn_new', align: 'center', width: 82,formatter:function (cellvalue, options, rowObject) 
            {
                var estado = (parseInt(cellvalue) == 0) ? 'fa fa-square-o' : 'fa fa-check-square-o';
                var valor = (parseInt(cellvalue) == 0) ? 1 : 0;
                var html = '<i style="width:100%" class="'+estado+' fa-3x" aria-hidden="true" onclick="cambiar_permiso_usuario('+rowObject[0]+',\'btn_new\','+valor+')"></i>';
                return html;                                                                        
            }},
            {name: 'btn_edit', index: 'btn_edit', align: 'center', width: 82,formatter:function (cellvalue, options, rowObject) 
            {
                var estado = (parseInt(cellvalue) == 0) ? 'fa fa-square-o' : 'fa fa-check-square-o';
                var valor = (parseInt(cellvalue) == 0) ? 1 : 0;
                var html = '<i style="width:100%" class="'+estado+' fa-3x" aria-hidden="true" onclick="cambiar_permiso_usuario('+rowObject[0]+',\'btn_edit\','+valor+')"></i>';
                return html;                                                                        
            }},
            {name: 'btn_del', index: 'btn_del', align: 'center', width: 82,formatter:function (cellvalue, options, rowObject) 
            {
                var estado = (parseInt(cellvalue) == 0) ? 'fa fa-square-o' : 'fa fa-check-square-o';
                var valor = (parseInt(cellvalue) == 0) ? 1 : 0;
                var html = '<i style="width:100%" class="'+estado+' fa-3x" aria-hidden="true" onclick="cambiar_permiso_usuario('+rowObject[0]+',\'btn_del\','+valor+')"></i>';
                return html;                                                                        
            }},
            {name: 'btn_print', index: 'btn_print', align: 'center', width: 82,formatter:function (cellvalue, options, rowObject) 
            {
                var estado = (parseInt(cellvalue) == 0) ? 'fa fa-square-o' : 'fa fa-check-square-o';
                var valor = (parseInt(cellvalue) == 0) ? 1 : 0;
                var html = '<i style="width:100%" class="'+estado+' fa-3x" aria-hidden="true" onclick="cambiar_permiso_usuario('+rowObject[0]+',\'btn_print\','+valor+')"></i>';
                return html;                                                                        
            }}
        ],
        pager: '#paginador_tablaSubMenus',
        rowList: [],       
        pgbuttons: false,     
        pgtext: null,  
        sortable:false,
        cmTemplate: { sortable: false },
        gridComplete: function () {
            var idarray = jQuery('#tablaSubMenus').jqGrid('getDataIDs');
            if (idarray.length > 0) {
            var firstid = jQuery('#tablaSubMenus').jqGrid('getDataIDs')[0];
                    $("#tablaSubMenus").setSelection(firstid);    
                }
        },
    });
    
});

var idioma_espanol = {
    "sProcessing":     "Procesando...",
    "sLengthMenu":     "Mostrar _MENU_ registros",
    "sZeroRecords":    "No se encontraron resultados",
    "sEmptyTable":     "Ningún dato disponible en esta tabla",
    "sInfo":           "Registros del _START_ al _END_ de un total de _TOTAL_",
    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix":    "",
    "sSearch":         "Buscar:",
    "sUrl":            "",
    "sInfoThousands":  ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
    },
    "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }
}

function ver_permisos_usuario(usuario)
{
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'usuarios/0?show=datos_sistema',
        type: 'GET',
        data:
        {
            usuario:usuario
        },
        beforeSend:function()
        {            
            MensajeEspera('ENVIANDO INFORMACION');  
        },
        success: function(data) 
        {
            if (data == 0) 
            {
                MensajeAdvertencia('EL USUARIO NO TIENE ASIGNADO NINGUN SISTEMA');
            }
            else
            {
                Sistemas = $('#ModalRolesPermisos').modal({backdrop: 'static', keyboard: false});
                Sistemas.find('.modal-title').text('SISTEMAS REGISTRADOS');
                jQuery("#tablaSistemas").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_sistemas&datos='+data+'&usuario='+usuario}).trigger('reloadGrid');
                swal.close();
            } 
        },
        error: function(data) {
            MensajeAdvertencia("hubo un error, Comunicar al Administrador");
            console.log('error');
            console.log(data);
        }
    });
}

function fn_llamar_roles_sistema(sist_id)
{
    jQuery("#tablaRoles").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_roles&sist_id='+sist_id+'&usuario='+$('#tablaSistemas').jqGrid ('getCell', sist_id, 'usuario')}).trigger('reloadGrid');
}

function fn_llamar_menus_roles(sro_id)
{
    sist_id = $('#tablaSistemas').jqGrid ('getGridParam', 'selrow');
    jQuery("#tablaMenus").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_menus&sro_id='+sro_id+'&usuario='+$('#tablaSistemas').jqGrid ('getCell', sist_id, 'usuario')}).trigger('reloadGrid');
}

function fn_llamar_submenus_roles(men_id)
{
    sist_id = $('#tablaSistemas').jqGrid ('getGridParam', 'selrow');
    sro_id = $('#tablaRoles').jqGrid ('getGridParam', 'selrow');
    jQuery("#tablaSubMenus").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_submenus&sro_id='+sro_id+'&usuario='+$('#tablaSistemas').jqGrid ('getCell', sist_id, 'usuario')+'&men_id='+men_id+'&sist_id='+sist_id}).trigger('reloadGrid');
}

// ASIGNAR SISTEMAS Y ROLES 
function btn_asginar_sistemas_rol(usuario,dn)
{
    $.dialog({
        icon:'fa fa-tasks',
        title: 'SELECCIONAR SISTEMAS',
        type: 'red',
        animationBounce: 2,
        typeAnimated: true,
        backgroundDismiss: false,
        backgroundDismissAnimation: 'glow',
        columnClass: 'medium',
        closeIcon: true,
        theme:'material',
        content: '' +
                '<div class="row">'+
                    '<div class="col-md-12 tblAsignarSistemas">'+
                        '<div class="form-group">'+
                            '<table id="tblAsignarSistemas"></table>'+
                            '<div id="paginador_tblAsignarSistemas"></div>'+                                                                  
                        '</div>'+
                    '</div>'+
                '</div>',
        onOpen: function () 
        {
            jQuery("#tblAsignarSistemas").jqGrid({
                url: 'usuarios/0?grid=tabla_asignar_sistemas&usuario='+usuario,
                datatype: 'json', mtype: 'GET',
                height: 'auto', autowidth: false,
                toolbarfilter: true,
                colNames: ['ID', 'DESCRIPCION', 'RUTA', 'ESTADO', 'ROLES'],
                rowNum: 100, sortname: 'sist_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE SISTEMAS', align: "center",
                colModel: [
                    {name: 'sist_id', index: 'sist_id', align: 'center',width: 10, hidden:true},
                    {name: 'sist_desc', index: 'sist_desc', align: 'left', width: 190},
                    {name: 'sist_rut', index: 'sist_rut', align: 'left', width: 150},
                    {name: 'marcas', index: 'marcas', align: 'center', width: 80},
                    {name: 'roles', index: 'roles', align: 'center', width: 80}
                ],
                pager: '#paginador_tblAsignarSistemas',
                rowList: [],       
                pgbuttons: false,     
                pgtext: null,  
                sortable:false,
                cmTemplate: { sortable: false },
                gridComplete: function () {
                    var idarray = jQuery('#tblAsignarSistemas').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#tblAsignarSistemas').jqGrid('getDataIDs')[0];
                            $("#tblAsignarSistemas").setSelection(firstid);    
                        }
                }
            });
        }
    });   
}

function fn_asignar_sistemas_usuario(sist_id,usuario,estado,new_sist_id)
{
    if (estado == 0) 
    {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'usuarios/create',
            type: 'GET',
            data:
            {
                usuario:usuario,
                sist_id:sist_id,
                tipo:1
            },
            beforeSend:function()
            {            
                $('.tblAsignarSistemas').block({ 
                    message: '<h1>PROCESANDO INFORMACION</h1>', 
                    css: { border: '5px solid #a00',width: '300px' } 
                });
            },
            success: function(data) 
            {
                if (data == 1) 
                {
                    jQuery("#tblAsignarSistemas").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_asignar_sistemas&usuario='+usuario}).trigger('reloadGrid');
                    $('.tblAsignarSistemas').unblock();
                }
                else
                {
                    MensajeAdvertencia('NO SE PUDO ENVIAR LA RESPUESTA');
                    console.log(data);
                }
            },
            error: function(data) {
                MensajeAdvertencia("hubo un error, Comunicar al Administrador");
                console.log('error');
                console.log(data);
            }
        });
    }
    else
    {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'usuarios/destroy',
            type: 'POST',
            data: {_method: 'delete', usuario: usuario, sist_id: sist_id, new_sist_id:new_sist_id},
            beforeSend:function()
            {            
                $('.tblAsignarSistemas').block({ 
                    message: '<h1>PROCESANDO INFORMACION</h1>', 
                    css: { border: '5px solid #a00',width: '300px' } 
                }); 
            },
            success: function (data) 
            {
                if (data == 1) 
                {
                    jQuery("#tblAsignarSistemas").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_asignar_sistemas&usuario='+usuario}).trigger('reloadGrid');
                    $('.tblAsignarSistemas').unblock();
                }
                else
                {
                    MensajeAdvertencia('NO SE PUDO ENVIAR LA RESPUESTA');
                    console.log(data);
                }
            },
            error: function (data) {
                MensajeAdvertencia("hubo un error, Comunicar al Administrador");
                console.log('error');
                console.log(data);
            }
        });
    }
}

//ASIGNAR ROLES USUARIO
function fn_asignar_roles_usuario(sist_id,usuario)
{
    $.confirm({
        icon:'fa fa-tasks',
        title: 'SELECCIONAR ROLES',
        type: 'red',
        animationBounce: 2,
        typeAnimated: true,
        backgroundDismiss: false,
        backgroundDismissAnimation: 'glow',
        columnClass: 'large',
        closeIcon: true,
        theme:'material',
        buttons: {
            confirm: {
                text: 'GUARDAR',
                btnClass: 'btn-danger',
                keys: ['enter', 'shift'],
                action: function(){
                    if (!$("#FormularioRdbtn input[name='rdbtn_roles_sistema']").is(':checked')) 
                    {
                        $.alert({
                            title:'DEBES SELECCIONAR UNA OPCION',
                            content: false,
                            theme:'modern',
                            type: 'red',
                            typeAnimated: true
                        });
                        return false;
                    }
                    asignar_roles_sistema(sist_id,usuario);
                }
            },
            cancel: {
                text: 'CERRAR',
                btnClass: 'btn-warning',
            }
        },
        content: function () 
        {
            var self = this;
            self.setContent('<div class="form-group col-md-12 text-center" id="FormularioRdbtn">'+
                                '<center>'+
                                    '<fieldset id="formRoles">'+
                                    '</fieldset>'+
                                '</center>'+
                            '</div>');
            return $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'usuarios/0?show=traer_datos_roles&sist_id='+sist_id,
                method: 'GET',
            }).done(function (response) {
                html = "";
                for(i=0;i<response.length;i++)
                {
                    html = html + '<input type="radio" name="rdbtn_roles_sistema" class="rdbtn" style="height:30px; width:5%" value="'+response[i].sro_id+'" /><label for="sizeSmall">'+response[i].sro_descripcion+'</label>';
                }
                $("#formRoles").html(html);
            }).fail(function(){
                self.setContent('hubo un error, Comunicar al Administrador');
            });
        }
    });
}

function asignar_roles_sistema(sist_id,usuario)
{
    $.confirm({
        content: function () {
            var self = this;
            return $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: 'usuarios/create',
                method: 'get',
                data:
                {
                    sist_id:sist_id,
                    usuario:usuario,
                    sro_id:$('input:radio[name=rdbtn_roles_sistema]:checked').val(),
                    tipo:2
                },
            }).done(function (data) {
                if (data[0].asignar_menu_usuario == 'OK') 
                {
                    self.setContent('LOS PERMISOS FUERON AGREGADOS CORRECTAMENTE');
                    self.setTitle('ATENCION!');
                }
                else
                {
                    self.setContent('HUBO UN PROBLEMA, COMUNICARSE CON EL ADMINISTRADOR');
                }
            }).fail(function(){
                self.setContent('hubo un error, Comunicar al Administrador');
            });
        }
    });
}

//CAMBIAR PERMISO USUARIO
function cambiar_permiso_usuario(ume_id,columna,valor)
{
    sist_id = $('#tablaSistemas').jqGrid ('getGridParam', 'selrow');
    sro_id = $('#tablaRoles').jqGrid ('getGridParam', 'selrow');
    men_id = $('#tablaMenus').jqGrid ('getGridParam', 'selrow');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'usuarios/'+ume_id+'/edit',
        type: 'GET',
        data:
        {
            columna:columna,
            valor:valor
        },
        beforeSend:function()
        {            
            $('.tablaSubMenus').block({ 
                message: '<h1>PROCESANDO INFORMACION</h1>', 
                css: { border: '5px solid #a00',width: '300px' } 
            }); 
        },
        success: function(data) 
        { 
            if (data == 1) 
            {
                jQuery("#tablaSubMenus").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_submenus&sro_id='+sro_id+'&usuario='+$('#tablaSistemas').jqGrid ('getCell', sist_id, 'usuario')+'&men_id='+men_id+'&sist_id='+sist_id}).trigger('reloadGrid');
                $('.tablaSubMenus').unblock();
            }
            else
            {
                MensajeAdvertencia('NO SE PUDO ENVIAR LA RESPUESTA');
                console.log(data);
            }
        },
        error: function(data) {
            MensajeAdvertencia("hubo un error, Comunicar al Administrador");
            console.log('error');
            console.log(data);
        }
    });
}