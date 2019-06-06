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
        <h3 class="m-0">INICIO</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
        </div>
    </div>
    <div class="card-body">
        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center align-self-center">
                
                <div class="card text-center" style="width: 18rem;">
                    <div class="card-header">
                        <h3>REGISTRO DE USUARIOS</h3>
                    </div>
                    <div class="card-body" style="font-size: 24px;">
                        <button type="button" id="btn_href_usuarios" class="btn btn-danger btn-block"><i class="fa fa-users fa-5x"></i></button>     
                    </div>
                </div>
                <div class="card text-center" style="width: 18rem;">
                    <div class="card-header">
                        <h3>REGISTRO DE ROLES</h3>
                    </div>
                    <div class="card-body">
                        <button type="button" id="btn_href_roles" class="btn btn-danger btn-block"><i class="fa fa-list-alt fa-5x"></i></button>     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('page-js-script')
<script>
    jQuery(document).on("click","#btn_href_usuarios",function(){
        window.open('usuarios');
    });
    
    jQuery(document).on("click","#btn_href_roles",function(){
        window.open('roles');
    });
</script>
@stop
@endsection