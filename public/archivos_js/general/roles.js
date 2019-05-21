jQuery(document).ready(function($){   
    jQuery("#tblsistemas_sist").jqGrid({
        url: 'roles/0?tabla=sistemas',
        datatype: 'json', mtype: 'GET',
        height: '550px', autowidth: true,
        toolbarfilter: true,
        colNames: ['ID', 'DESCRIPCION', 'RUTA', 'ESTADO', 'AGREGAR'],
        rowNum: 10, sortname: 'sist_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE SISTEMAS', align: "center",
        colModel: [
            {name: 'sist_id', index: 'sist_id', align: 'center',width: 50, hidden:true},
            {name: 'sist_desc', index: 'sist_desc', align: 'left', width: 50},
            {name: 'sist_rut', index: 'sist_rut', align: 'left', width: 40},
            {name: 'sist_est', index: 'sist_est', align: 'left', width: 10},
            {name: 'agregar', index: 'agregar', align: 'center', width: 10,sortable: false}
        ],
        pager: '#paginador_tblsistemas_sist',
        rowList: [10, 20, 30, 40, 50],
        gridComplete: function () {
            var idarray = jQuery('#tblsistemas_sist').jqGrid('getDataIDs');
            if (idarray.length > 0) {
            var firstid = jQuery('#tblsistemas_sist').jqGrid('getDataIDs')[0];
                    $("#tblsistemas_sist").setSelection(firstid);    
                }
        },
        ondblClickRow: function (sist_id){fn_traer_roles_sistema(sist_id);}
    });  
    
    jQuery("#tblroles_rol").jqGrid({
        url: '',
        datatype: 'json', mtype: 'GET',
        height: '490px', autowidth: false,
        toolbarfilter: true,
        colNames: ['ID', 'DESCRIPCION', 'ESTADO'],
        rowNum: 10, sortname: 'sro_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE ROLES', align: "center",
        colModel: [
            {name: 'sro_id', index: 'sro_id', align: 'center',width: 50, hidden:true},
            {name: 'sro_descripcion', index: 'sro_descripcion', align: 'left', width: 260},
            {name: 'sro_estado', index: 'sro_estado', align: 'left', width: 120}
        ],
        pager: '#paginador_tblroles_rol',
        rowList: [10, 20, 30, 40, 50],
        gridComplete: function () {
            var idarray = jQuery('#tblroles_rol').jqGrid('getDataIDs');
            if (idarray.length > 0) {
            var firstid = jQuery('#tblroles_rol').jqGrid('getDataIDs')[0];
                    $("#tblroles_rol").setSelection(firstid);    
                }
        },
        loadComplete: function(data){ 
            if (data.total == 0) 
            {
                jQuery("#tblmenu_men").jqGrid('setGridParam', {url: 'roles/0?tabla=menus&sro_id=0&sist_id=0'}).trigger('reloadGrid');    
            }
        },
        onSelectRow: function (sro_id){fn_traer_menu_rol(sro_id);}
    }); 
    
    jQuery("#tblmenu_men").jqGrid({
        url: '',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: false,
        toolbarfilter: true,
        colNames: ['ID', 'MEN_ID', 'DESCRIPCION', 'TITULO', 'SISTEMA'],
        rowNum: 100, sortname: 'rme_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE MENUS', align: "center",
        colModel: [
            {name: 'rme_id', index: 'rme_id', align: 'center',width: 50, hidden:true},
            {name: 'men_id', index: 'men_id', align: 'center', width: 50, hidden:true},
            {name: 'men_descripcion', index: 'men_descripcion', align: 'left', width: 280},
            {name: 'men_titulo', index: 'men_titulo', align: 'left', width: 230},
            {name: 'men_sistema', index: 'men_sistema', align: 'left', width: 156}
        ],
        pager: '#paginador_tblmenu_men',
        rowList: [],       
        pgbuttons: false,     
        pgtext: null,  
        sortable:false,
        cmTemplate: { sortable: false },
        gridComplete: function () {
            var idarray = jQuery('#tblmenu_men').jqGrid('getDataIDs');
            if (idarray.length > 0) {
            var firstid = jQuery('#tblmenu_men').jqGrid('getDataIDs')[0];
                    $("#tblmenu_men").setSelection(firstid);    
                }
        },
        loadComplete: function(data){ 
            if (data.total == 0) 
            {
                jQuery("#tblsubmenu_sme").jqGrid('setGridParam', {url: 'roles/0?tabla=submenus&men_id=0&sist_id=0&sro_id=0'}).trigger('reloadGrid');    
            }
        },
        onSelectRow: function (rme_id){fn_traer_submenu_menu(rme_id);}
    });
    
    jQuery("#tblsubmenu_sme").jqGrid({
        url: '',
        datatype: 'json', mtype: 'GET',
        height: 'auto', autowidth: false,
        toolbarfilter: true,
        colNames: ['ID', 'SME_ID', 'MEN_ID', 'SIST_ID', 'SRO_ID', 'TITULO', 'VER', 'CREAR', 'EDITAR', 'ELIMINAR', 'IMPRIMIR'],
        rowNum: 100, sortname: 'rms_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE SUB-MENUS', align: "center",
        colModel: [
            {name: 'rms_id', index: 'rms_id', align: 'center',width: 10, hidden:true},
            {name: 'sme_id', index: 'sme_id', align: 'center', width: 10, hidden:true},
            {name: 'men_id', index: 'men_id', align: 'center', width: 10, hidden:true},
            {name: 'sist_id', index: 'sist_id', align: 'center', width: 10, hidden:true},
            {name: 'sro_id', index: 'sro_id', align: 'center', width: 10, hidden:true},
            {name: 'sme_titulo', index: 'sme_titulo', align: 'left', width: 211},
            {name: 'btn_view', index: 'btn_view', align: 'center', width: 91,
            formatter:function (cellvalue, options, rowObject) 
            {
                var estado = (parseInt(cellvalue) == 0) ? 'fa fa-square-o' : 'fa fa-check-square-o';
                var valor = (parseInt(cellvalue) == 0) ? 1 : 0;
                var html = '<i style="width:100%" class="'+estado+' fa-3x" aria-hidden="true" onclick="cambiar_estado_permiso('+rowObject[0]+',\'btn_view\','+valor+')"></i>';
                return html;                                                                        
            }},
            {name: 'btn_new', index: 'btn_new', align: 'center', width: 91,formatter:function (cellvalue, options, rowObject) 
            {
                var estado = (parseInt(cellvalue) == 0) ? 'fa fa-square-o' : 'fa fa-check-square-o';
                var valor = (parseInt(cellvalue) == 0) ? 1 : 0;
                var html = '<i style="width:100%" class="'+estado+' fa-3x" aria-hidden="true" onclick="cambiar_estado_permiso('+rowObject[0]+',\'btn_new\','+valor+')"></i>';
                return html;                                                                        
            }},
            {name: 'btn_edit', index: 'btn_edit', align: 'center', width: 91,formatter:function (cellvalue, options, rowObject) 
            {
                var estado = (parseInt(cellvalue) == 0) ? 'fa fa-square-o' : 'fa fa-check-square-o';
                var valor = (parseInt(cellvalue) == 0) ? 1 : 0;
                var html = '<i style="width:100%" class="'+estado+' fa-3x" aria-hidden="true" onclick="cambiar_estado_permiso('+rowObject[0]+',\'btn_edit\','+valor+')"></i>';
                return html;                                                                        
            }},
            {name: 'btn_del', index: 'btn_del', align: 'center', width: 91,formatter:function (cellvalue, options, rowObject) 
            {
                var estado = (parseInt(cellvalue) == 0) ? 'fa fa-square-o' : 'fa fa-check-square-o';
                var valor = (parseInt(cellvalue) == 0) ? 1 : 0;
                var html = '<i style="width:100%" class="'+estado+' fa-3x" aria-hidden="true" onclick="cambiar_estado_permiso('+rowObject[0]+',\'btn_del\','+valor+')"></i>';
                return html;                                                                        
            }},
            {name: 'btn_print', index: 'btn_print', align: 'center', width: 91,formatter:function (cellvalue, options, rowObject) 
            {
                var estado = (parseInt(cellvalue) == 0) ? 'fa fa-square-o' : 'fa fa-check-square-o';
                var valor = (parseInt(cellvalue) == 0) ? 1 : 0;
                var html = '<i style="width:100%" class="'+estado+' fa-3x" aria-hidden="true" onclick="cambiar_estado_permiso('+rowObject[0]+',\'btn_print\','+valor+')"></i>';
                return html;                                                                        
            }}
        ],
        pager: '#paginador_tblsubmenu_sme',
        rowList: [],       
        pgbuttons: false,     
        pgtext: null,  
        sortable:false,
        cmTemplate: { sortable: false },
        gridComplete: function () {
            var idarray = jQuery('#tblsubmenu_sme').jqGrid('getDataIDs');
            if (idarray.length > 0) {
            var firstid = jQuery('#tblsubmenu_sme').jqGrid('getDataIDs')[0];
                    $("#tblsubmenu_sme").setSelection(firstid);    
                }
        }
    });
    
});

function fn_traer_roles_sistema(sist_id)
{
    Roles = $('#ModalRoles').modal({backdrop: 'static', keyboard: false});
    Roles.find('.modal-title').text('ROLES REGISTRADOS');
    jQuery("#tblroles_rol").jqGrid('setGridParam', {url: 'roles/0?tabla=roles&sist_id='+sist_id}).trigger('reloadGrid');    
}

function fn_traer_menu_rol(sro_id)
{
    sist_id = $('#tblsistemas_sist').jqGrid ('getGridParam', 'selrow');
    jQuery("#tblmenu_men").jqGrid('setGridParam', {url: 'roles/0?tabla=menus&sro_id='+sro_id+'&sist_id='+sist_id}).trigger('reloadGrid');
}

function fn_traer_submenu_menu(rme_id)
{
    sist_id = $('#tblsistemas_sist').jqGrid ('getGridParam', 'selrow');
    sro_id = $('#tblroles_rol').jqGrid ('getGridParam', 'selrow');
    jQuery("#tblsubmenu_sme").jqGrid('setGridParam', {url: 'roles/0?tabla=submenus&men_id='+$('#tblmenu_men').jqGrid ('getCell', rme_id, 'men_id')+'&sist_id='+sist_id+'&sro_id='+sro_id}).trigger('reloadGrid');    
}

function cambiar_estado_permiso(rms_id,columna,valor)
{
    //alert(sme_id+'-'+columna+'->'+valor);
    rme_id = $('#tblmenu_men').jqGrid ('getGridParam', 'selrow');
    sist_id = $('#tblsistemas_sist').jqGrid ('getGridParam', 'selrow');
    sro_id = $('#tblroles_rol').jqGrid ('getGridParam', 'selrow');
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'roles/'+rms_id+'/edit',
        type: 'GET',
        data:
        {
            columna:columna,
            valor:valor
        },
        beforeSend:function()
        {            
            $('.tblsubmenu_sme').block({ 
                message: '<h1>PROCESANDO INFORMACION</h1>', 
                css: { border: '5px solid #a00',width: '300px' } 
            }); 
        },
        success: function(data) 
        { 
            if (data == 1) 
            {
                jQuery("#tblsubmenu_sme").jqGrid('setGridParam', {
                    url: 'roles/0?tabla=submenus&men_id='+$('#tblmenu_men').jqGrid ('getCell', rme_id, 'men_id')+'&sist_id='+sist_id+'&sro_id='+sro_id
                }).trigger('reloadGrid');
                $('.tblsubmenu_sme').unblock();
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

function limpiar_datos_menu()
{
    $("#txt_menu_descripcion").val('');
    $("#txt_menu_titulo").val('');
    $("#txt_menu_sistema").val('');
}

jQuery(document).on("click", "#btn_agregar_menus", function(){
    Menu = $('#ModalMenu').modal({backdrop: 'static', keyboard: false});
    Menu.find('.modal-title').text('REGISTRAR MENUS');
    limpiar_datos_menu();
    limpiar_datos_submenu();
});

jQuery(document).on("click", "#btn_crear_menu", function(){
    sist_id = $('#tblsistemas_sist').jqGrid ('getGridParam', 'selrow');
    if ($('#txt_menu_titulo').val() == '') {
        mostraralertasconfoco('* EL CAMPO TITULO ES OBLIGATORIO...', '#txt_menu_titulo');
        return false;
    }
    
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'roles/create',
        type: 'GET',
        data:
        {
            sist_id:sist_id,
            men_descripcion:$("#txt_menu_descripcion").val(),
            men_titulo:$("#txt_menu_titulo").val(),
            men_sistema:$("#txt_menu_sistema").val(),
            tipo:1
        },
        beforeSend:function()
        {            
            MensajeEspera('ENVIANDO INFORMACION');  
        },
        success: function(data) 
        {
            if (data == 1) 
            {
                MensajeConfirmacion('EL RESPUESTA FUE ENVIADA CON EXITO');
                limpiar_datos_menu();
                limpiar_datos_submenu();
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
});

jQuery(document).on("click", "#btn_agregar_menus_rol", function(){
//    MenuSeleccion = $('#ModalSeleccionMenu').modal({backdrop: 'static', keyboard: false});
//    MenuSeleccion.find('.modal-title').text('SELECCIONAR MENU');
    $.dialog({
        icon:'fa fa-tasks',
        title: 'SELECCIONAR MENU',
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
                    '<div class="col-md-12 tblselectmenu">'+
                        '<div class="form-group">'+
                            '<table id="tblselectmenu"></table>'+
                            '<div id="paginador_tblselectmenu"></div>'+                                                                  
                        '</div>'+
                    '</div>'+
                '</div>',
        onOpen: function () 
        {
            sist_id = $('#tblsistemas_sist').jqGrid ('getGridParam', 'selrow');
            sro_id = $('#tblroles_rol').jqGrid ('getGridParam', 'selrow');
            jQuery("#tblselectmenu").jqGrid({
                url: 'roles/0?tabla=selectmenu&sist_id='+sist_id+'&sro_id='+sro_id,
                datatype: 'json', mtype: 'GET',
                height: 'auto', autowidth: false,
                toolbarfilter: true,
                colNames: ['ID', 'TITULO', 'ESTADO'],
                rowNum: 100, sortname: 'men_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE MENUS', align: "center",
                colModel: [
                    {name: 'men_id', index: 'men_id', align: 'center',width: 50, hidden:true},
                    {name: 'men_titulo', index: 'men_titulo', align: 'center', width: 350},
                    {name: 'marcas', index: 'marcas', align: 'center', width: 120}
                ],
                pager: '#paginador_tblselectmenu',
                rowList: [],       
                pgbuttons: false,     
                pgtext: null,  
                sortable:false,
                cmTemplate: { sortable: false },
                gridComplete: function () {
                    var idarray = jQuery('#tblselectmenu').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#tblselectmenu').jqGrid('getDataIDs')[0];
                            $("#tblselectmenu").setSelection(firstid);    
                        }
                }
            });
        }
    });
});

function fn_crear_menus_rol(id,opcion)
{
    sist_id = $('#tblsistemas_sist').jqGrid ('getGridParam', 'selrow');
    sro_id = $('#tblroles_rol').jqGrid ('getGridParam', 'selrow');
    if (opcion == 1) 
    {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'roles/destroy',
            type: 'POST',
            data: {_method: 'delete', rme_id: id, tipo:1},
            beforeSend:function()
            {            
                $('.tblselectmenu').block({ 
                    message: '<h1>PROCESANDO INFORMACION</h1>', 
                    css: { border: '5px solid #a00',width: '300px' } 
                }); 
            },
            success: function (data) 
            {
                if (data == 1) 
                {
                    jQuery("#tblselectmenu").jqGrid('setGridParam', {url: 'roles/0?tabla=selectmenu&sro_id='+sro_id+'&sist_id='+sist_id}).trigger('reloadGrid');
                    jQuery("#tblmenu_men").jqGrid('setGridParam', {url: 'roles/0?tabla=menus&sro_id='+sro_id+'&sist_id='+sist_id}).trigger('reloadGrid');
                    $('.tblselectmenu').unblock();
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
    else
    {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'roles/create',
            type: 'GET',
            data:
            {
                men_id:id,
                sro_id:sro_id,
                tipo:2
            },
            beforeSend:function()
            {            
                $('.tblselectmenu').block({ 
                    message: '<h1>PROCESANDO INFORMACION</h1>', 
                    css: { border: '5px solid #a00',width: '300px' } 
                }); 
            },
            success: function(data) 
            {
                if (data == 1) 
                {
                    jQuery("#tblselectmenu").jqGrid('setGridParam', {url: 'roles/0?tabla=selectmenu&sro_id='+sro_id+'&sist_id='+sist_id}).trigger('reloadGrid');
                    jQuery("#tblmenu_men").jqGrid('setGridParam', {url: 'roles/0?tabla=menus&sro_id='+sro_id+'&sist_id='+sist_id}).trigger('reloadGrid');
                    $('.tblselectmenu').unblock();
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
}

//SUBMENU

function limpiar_datos_submenu()
{
    $("#txt_submenu_descripcion").val('');
    $("#txt_submenu_titulo").val('');
    $("#txt_submenu_sistema").val('');
    $("#txt_submenu_ruta").val('');
}

jQuery(document).on("click", "#btn_crear_submenu", function(){
    sist_id = $('#tblsistemas_sist').jqGrid ('getGridParam', 'selrow');
    if ($('#txt_submenu_titulo').val() == '') {
        mostraralertasconfoco('* EL CAMPO TITULO ES OBLIGATORIO...', '#txt_submenu_titulo');
        return false;
    }
    if ($('#txt_submenu_ruta').val() == '') {
        mostraralertasconfoco('* EL CAMPO RUTA ES OBLIGATORIO...', '#txt_submenu_ruta');
        return false;
    }
    
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url: 'roles/create',
        type: 'GET',
        data:
        {
            sist_id:sist_id,
            sme_descripcion:$("#txt_submenu_descripcion").val(),
            sme_titulo:$("#txt_submenu_titulo").val(),
            sme_sistema:$("#txt_submenu_sistema").val(),
            sme_ruta:$("#txt_submenu_ruta").val(),
            tipo:3
        },
        beforeSend:function()
        {            
            MensajeEspera('ENVIANDO INFORMACION');  
        },
        success: function(data) 
        {
            if (data == 1) 
            {
                MensajeConfirmacion('EL RESPUESTA FUE ENVIADA CON EXITO');
                limpiar_datos_menu();
                limpiar_datos_submenu();
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
});

jQuery(document).on("click", "#btn_agregar_submenus_rol", function(){
    $.dialog({
        icon:'fa fa-tasks',
        title: 'SELECCIONAR SUB-MENU',
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
                    '<div class="col-md-12 tblselectsubmenu">'+
                        '<div class="form-group">'+
                            '<table id="tblselectsubmenu"></table>'+
                            '<div id="paginador_tblselectsubmenu"></div>'+                                                                  
                        '</div>'+
                    '</div>'+
                '</div>',
        onOpen: function () 
        {
            sist_id = $('#tblsistemas_sist').jqGrid ('getGridParam', 'selrow');
            sro_id = $('#tblroles_rol').jqGrid ('getGridParam', 'selrow');
            men_id = $('#tblmenu_men').jqGrid ('getGridParam', 'selrow');
            
            jQuery("#tblselectsubmenu").jqGrid({
                url: 'roles/0?tabla=selectsubmenu&sist_id='+sist_id+'&sro_id='+sro_id+'&men_id='+$('#tblmenu_men').jqGrid ('getCell', men_id, 'men_id'),
                datatype: 'json', mtype: 'GET',
                height: 'auto', autowidth: false,
                toolbarfilter: true,
                colNames: ['ID', 'TITULO', 'ESTADO'],
                rowNum: 100, sortname: 'sme_id', sortorder: 'asc', viewrecords: true, caption: 'LISTA DE SUB-MENUS', align: "center",
                colModel: [
                    {name: 'sme_id', index: 'sme_id', align: 'center',width: 50, hidden:true},
                    {name: 'sme_titulo', index: 'sme_titulo', align: 'center', width: 350},
                    {name: 'marcass', index: 'marcass', align: 'center', width: 120}
                ],
                pager: '#paginador_tblselectsubmenu',
                rowList: [],       
                pgbuttons: false,     
                pgtext: null,  
                sortable:false,
                cmTemplate: { sortable: false },
                gridComplete: function () {
                    var idarray = jQuery('#tblselectsubmenu').jqGrid('getDataIDs');
                    if (idarray.length > 0) {
                    var firstid = jQuery('#tblselectsubmenu').jqGrid('getDataIDs')[0];
                            $("#tblselectsubmenu").setSelection(firstid);    
                        }
                }
            });
        }
    });
});

function fn_crear_submenus_rol(id,opcion)
{
    sist_id = $('#tblsistemas_sist').jqGrid ('getGridParam', 'selrow');
    sro_id = $('#tblroles_rol').jqGrid ('getGridParam', 'selrow');
    men_id = $('#tblmenu_men').jqGrid ('getGridParam', 'selrow');
    if (opcion == 1) 
    {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'roles/destroy',
            type: 'POST',
            data: {_method: 'delete', rms_id: id, tipo:2},
            beforeSend:function()
            {            
                $('.tblselectsubmenu').block({ 
                    message: '<h1>PROCESANDO INFORMACION</h1>', 
                    css: { border: '5px solid #a00',width: '300px' } 
                }); 
            },
            success: function (data) 
            {
                if (data == 1) 
                {
                    jQuery("#tblselectsubmenu").jqGrid('setGridParam', {url: 'roles/0?tabla=selectsubmenu&sist_id='+sist_id+'&sro_id='+sro_id+'&men_id='+$('#tblmenu_men').jqGrid ('getCell', men_id, 'men_id')}).trigger('reloadGrid');
                    jQuery("#tblsubmenu_sme").jqGrid('setGridParam', {url: 'roles/0?tabla=submenus&men_id='+$('#tblmenu_men').jqGrid ('getCell', men_id, 'men_id')+'&sist_id='+sist_id+'&sro_id='+sro_id}).trigger('reloadGrid');    
                    $('.tblselectsubmenu').unblock();
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
    else
    {
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: 'roles/create',
            type: 'GET',
            data:
            {
                sro_id:sro_id,
                men_id:$('#tblmenu_men').jqGrid ('getCell', men_id, 'men_id'),
                sme_id:id,
                tipo:4
            },
            beforeSend:function()
            {            
                $('.tblselectsubmenu').block({ 
                    message: '<h1>PROCESANDO INFORMACION</h1>', 
                    css: { border: '5px solid #a00',width: '300px' } 
                }); 
            },
            success: function(data) 
            {
                if (data == 1) 
                {
                    jQuery("#tblselectsubmenu").jqGrid('setGridParam', {url: 'roles/0?tabla=selectsubmenu&sist_id='+sist_id+'&sro_id='+sro_id+'&men_id='+$('#tblmenu_men').jqGrid ('getCell', men_id, 'men_id')}).trigger('reloadGrid');
                    jQuery("#tblsubmenu_sme").jqGrid('setGridParam', {url: 'roles/0?tabla=submenus&men_id='+$('#tblmenu_men').jqGrid ('getCell', men_id, 'men_id')+'&sist_id='+sist_id+'&sro_id='+sro_id}).trigger('reloadGrid');    
                    $('.tblselectsubmenu').unblock();
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
}