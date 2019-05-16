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
            {data: 'dn',class:'text-center',searchable: false,orderable: false},
            {data: 'estado',class:'text-center',orderable: false},
            {data: 'ver',class:'text-center',searchable: false,orderable: false},
        ],
        "columnDefs":[
            {
                "targets": [5], 
                "data": "estado", 
                "render": function(data, type, row) 
                {
                    return '<button type="button" onClick="ver_permisos_usuario(\''+row.cn+'\')" class="btn btn-warning btn-lg"><span class="btn-label"><i class="fa fa-pencil"></i></span> EDITAR</button>';
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
        height: '550px', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'DESCRIPCION', 'RUTA'],
        rowNum: 10, sortname: 'sist_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE SISTEMAS', align: "center",
        colModel: [
            {name: 'sist_id', index: 'sist_id', align: 'center',width: 50, hidden:true},
            {name: 'sist_desc', index: 'sist_desc', align: 'left', width: 119},
            {name: 'sist_rut', index: 'sist_rut', align: 'left', width: 146}
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
        onSelectRow: function (Id){
            fn_llamar_roles_sistema(Id);
        }
    });
    
    jQuery("#tablaRoles").jqGrid({
        url: '',
        datatype: 'json', mtype: 'GET',
        height: '550px', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'DESCRIPCION'],
        rowNum: 10, sortname: 'sro_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE ROLES', align: "center",
        colModel: [
            {name: 'sro_id', index: 'sro_id', align: 'center',width: 50},
            {name: 'sro_descripcion', index: 'sro_descripcion', align: 'left', width: 215}
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
//        onSelectRow: function (Id){
//            $('#inp_id_rol').val($("#tabla_rol").getCell(Id, "id_rol"));
//        }
    });
    
    jQuery("#tablaMenus").jqGrid({
        url: '',
        datatype: 'json', mtype: 'GET',
        height: '215px', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'DESCRIPCION','TITULO','MENU SISTEMA'],
        rowNum: 10, sortname: 'men_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE MENUS', align: "center",
        colModel: [
            {name: 'men_id', index: 'men_id', align: 'center',width: 50},
            {name: 'men_descripcion', index: 'men_descripcion', align: 'left', width: 140},
            {name: 'men_titulo', index: 'men_titulo', align: 'left', width: 154},
            {name: 'men_sistema', index: 'men_sistema', align: 'left', width: 140}
        ],
        pager: '#paginador_tablaMenus',
        rowList: [10, 20, 30, 40, 50],
        gridComplete: function () {
            var idarray = jQuery('#tablaMenus').jqGrid('getDataIDs');
            if (idarray.length > 0) {
            var firstid = jQuery('#tablaMenus').jqGrid('getDataIDs')[0];
                    $("#tablaMenus").setSelection(firstid);    
                }
        },
//        onSelectRow: function (Id){
//            $('#inp_id_rol').val($("#tabla_rol").getCell(Id, "id_rol"));
//        }
    });
    
    jQuery("#tablaSubMenus").jqGrid({
        url: '',
        datatype: 'json', mtype: 'GET',
        height: '215px', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'DESCRIPCION','TITULO','MENU SISTEMA'],
        rowNum: 10, sortname: 'men_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE MENUS', align: "center",
        colModel: [
            {name: 'men_id', index: 'men_id', align: 'center',width: 50},
            {name: 'men_descripcion', index: 'men_descripcion', align: 'left', width: 140},
            {name: 'men_titulo', index: 'men_titulo', align: 'left', width: 154},
            {name: 'men_sistema', index: 'men_sistema', align: 'left', width: 140}
        ],
        pager: '#paginador_tablaSubMenus',
        rowList: [10, 20, 30, 40, 50],
        gridComplete: function () {
            var idarray = jQuery('#tablaSubMenus').jqGrid('getDataIDs');
            if (idarray.length > 0) {
            var firstid = jQuery('#tablaSubMenus').jqGrid('getDataIDs')[0];
                    $("#tablaSubMenus").setSelection(firstid);    
                }
        },
//        onSelectRow: function (Id){
//            $('#inp_id_rol').val($("#tabla_rol").getCell(Id, "id_rol"));
//        }
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
                jQuery("#tablaSistemas").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_sistemas&datos='+data}).trigger('reloadGrid');
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
    if(sist_id==null){
        return false;
    }
    jQuery("#tablaRoles").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_roles&sist_id='+sist_id}).trigger('reloadGrid');
    jQuery("#tablaMenus").jqGrid('setGridParam', {url: 'usuarios/0?grid=tabla_menus&sist_id='+sist_id}).trigger('reloadGrid');
}