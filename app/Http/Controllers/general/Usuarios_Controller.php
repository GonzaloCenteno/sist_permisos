<?php

namespace App\Http\Controllers\general;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Models\Tblusuariomenu_ume;

class Usuarios_Controller extends Controller
{
    
    public function conexion_ldap()
    {
        $ldap_dn = "CN=gcenteno,OU=sistemas,OU=Administrativos,OU=Cromotex_Usuarios,OU=Transportes Cromotex,DC=cromotex,DC=com,DC=pe";
        $ldap_password = "Abril2019";

        return response()->json([
            'ldap_dn' => $ldap_dn,
            'ldap_password' => $ldap_password
        ]);
    }
    
    public function index(Request $request)
    {
        return view('general/vw_usuarios');
    }

    public function show($id, Request $request)
    {
        if ($id > 0) 
        {
            
        }
        else
        {
            if ($request['tabla'] == 'usuarios') 
            {
                return $this->crear_tabla_usuarios($request);
            }
            if ($request['show'] == 'datos_sistema') 
            {
                return $this->traer_menu_sistemas($request);
            }
            if ($request['show'] == 'traer_datos_roles') 
            {
                return $this->traer_roles_sistemas($request);
            }
            if ($request['grid'] == 'tabla_sistemas') 
            {
                return $this->crear_tabla_sistemas($request);
            }
            if ($request['grid'] == 'tabla_roles') 
            {
                return $this->crear_tabla_roles($request);
            }
            if ($request['grid'] == 'tabla_menus') 
            {
                return $this->crear_tabla_menus($request);
            }
            if ($request['grid'] == 'tabla_asignar_sistemas') 
            {
                return $this->crear_tabla_asignar_sistemas($request);
            }
            if ($request['grid'] == 'tabla_submenus') 
            {
                return $this->crear_tabla_submenus($request);
            }
        }
    }

    public function create(Request $request)
    {
        if ($request['tipo'] == 1) 
        {
            return $this->crear_accesos_sistemas($request);
        }
        if ($request['tipo'] == 2) 
        {
            return $this->crear_accesos_roles($request);
        }
    }

    public function edit($ume_id,Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                $Tblusuariomenu_ume = new Tblusuariomenu_ume;
                $Tblusuariomenu_ume::where('ume_id',$ume_id)->update([
                    $request['columna'] => $request['valor'],
                ]);
                $success = 1;
                DB::commit();
            } catch (\Exception $ex) {
                $success = 2;
                $error = $ex->getMessage();
                DB::rollback();
            }
        }

        if ($success == 1) 
        {
            return $success;
        }
        else
        {
            return $error;
        } 
    }

    public function destroy(Request $request)
    {
        $ldap_con = ldap_connect("cromotex.com.pe/",389)or die ("Could not connect to LDAP server.");
        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_con, LDAP_OPT_REFERRALS, 0);
        if (@ldap_bind($ldap_con, $this->conexion_ldap()->original['ldap_dn'], $this->conexion_ldap()->original['ldap_password'])) 
        {
            $base_dn = "DC=cromotex,DC=com,DC=pe";

            $filter = "(cn=".$request['usuario'].")";
            $result = @ldap_search($ldap_con,$base_dn, $filter) or exit("NO SE PUDO CONECTAR");
            $entries = ldap_get_entries($ldap_con, $result);
            for ($i=0; $i<$entries["count"]; $i++) 
            {
                $sistema = isset($entries[$i]["department"][0]) ? $entries[$i]["department"][0] : 'cromotex';
                $dn = isset($entries[$i]["dn"]) ? $entries[$i]["dn"] : '-';
            }
            $arreglo = explode(";", $sistema);
            unset($arreglo[$request['sist_id']]);
            $attr['department'] = implode(";", $arreglo);
            $respuesta = ldap_modify($ldap_con, $dn, $attr);
            if (TRUE === $respuesta) 
            {
                $Tblusuariomenu_ume = new Tblusuariomenu_ume;
                $Tblusuariomenu_ume::where([['ume_usuario',"=",$request['usuario']],['sist_id',"=",$request['new_sist_id']]])->delete();
                return 1;
            } 
            else 
            {
                return 0;
            }
        }
        else
        {
            echo "conexion invalida";
        }
    }

    public function store(Request $request)
    {
       
    }
    
    public function crear_tabla_usuarios(Request $request)
    {
        $ldap_con = ldap_connect("cromotex.com.pe/",389)or die ("Could not connect to LDAP server.");
        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_con, LDAP_OPT_REFERRALS, 0);
        if (@ldap_bind($ldap_con, $this->conexion_ldap()->original['ldap_dn'], $this->conexion_ldap()->original['ldap_password'])) 
        {
            $base_dn = "DC=cromotex,DC=com,DC=pe";
            
            $filter = "(cn=*)";
            $result = @ldap_search($ldap_con,$base_dn, $filter) or exit("NO SE PUDO CONECTAR");
            $entries = ldap_get_entries($ldap_con, $result);
            
            $arreglo = array();
            
            for ($i=0; $i<$entries["count"]; $i++) 
            {
                $arreglo[$i]["cn"] = isset($entries[$i]["cn"][0]) ? $entries[$i]["cn"][0] : '-';
                $arreglo[$i]["displayname"] = isset($entries[$i]["displayname"][0]) ? $entries[$i]["displayname"][0] : '-';
                $arreglo[$i]["dn"] = isset($entries[$i]["dn"]) ? $entries[$i]["dn"] : '-';
                $arreglo[$i]["userprincipalname"] = isset($entries[$i]["userprincipalname"][0]) ? $entries[$i]["userprincipalname"][0] : '-';
                if(isset($entries[$i]['useraccountcontrol'][0]))
                {
                    if (($entries[$i]['useraccountcontrol'][0] & 2) == 0) 
                    {
                        $arreglo[$i]["estado"] = 'HABILITADO';
                    }
                    else
                    {
                        $arreglo[$i]["estado"] = 'INHABILITADO';
                    }
                }
                else
                {
                    $arreglo[$i]["estado"] = '-';
                }
                $arreglo[$i]["ver"] = 1;
                $arreglo[$i]["asignar"] = 1;
                //$values = array((object)["cn"=>$cn,"displayname"=>$displayname,"userprincipalname"=>$userprincipalname,"dn"=>$dn]); 
            }
            return datatables($arreglo)->toJson();
        }
        else
        {
            echo "conexion invalida";
        }
    }
    
    public function traer_menu_sistemas(Request $request)
    {
        $ldap_con = ldap_connect("cromotex.com.pe/",389)or die ("Could not connect to LDAP server.");
        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_con, LDAP_OPT_REFERRALS, 0);
        if (@ldap_bind($ldap_con, $this->conexion_ldap()->original['ldap_dn'], $this->conexion_ldap()->original['ldap_password'])) 
        {
            $base_dn = "DC=cromotex,DC=com,DC=pe";
            
            $filter = "(cn=".$request['usuario'].")";
            $result = @ldap_search($ldap_con,$base_dn, $filter) or exit("NO SE PUDO CONECTAR");
            $entries = ldap_get_entries($ldap_con, $result);
            
            for ($i=0; $i<$entries["count"]; $i++) 
            {
                $sistema = isset($entries[$i]["department"][0]) ? $entries[$i]["department"][0] : 0;
            }
            return str_replace(";", ",", $sistema);
        }
        else
        {
            echo "conexion invalida";
        }
    }
    
    public function crear_tabla_sistemas(Request $request)
    {
        header('Content-type: application/json');
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $start = ($limit * $page) - $limit;
        if ($start < 0) {
            $start = 0;
        }
        $totalg = DB::select("select count(*) as total from permisos.tblsistemas_sis where sist_id in(".$request['datos'].") and sist_est = 1");
        $sql = DB::select("select * from permisos.tblsistemas_sis where sist_id in(".$request['datos'].") and sist_est = 1 order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

        $total_pages = 0;
        if (!$sidx) {
            $sidx = 1;
        }
        $count = $totalg[0]->total;
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $Lista = new \stdClass();
        $Lista->page = $page;
        $Lista->total = $total_pages;
        $Lista->records = $count;
        foreach ($sql as $Index => $Datos) {
            $Lista->rows[$Index]['id'] = $Datos->sist_id;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->sist_id),
                trim($Datos->sist_desc),
                trim($Datos->sist_rut),
                $request['usuario']
            );
        }
        return response()->json($Lista);
    }
    
    public function crear_tabla_roles(Request $request)
    {
        header('Content-type: application/json');
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $start = ($limit * $page) - $limit;
        if ($start < 0) {
            $start = 0;
        }
        $totalg = DB::select("select count(*) as total from permisos.vw_rol_usuario where sist_id = ".$request['sist_id']." and ume_usuario = '".$request['usuario']."' ");
        $sql = DB::select("select * from permisos.vw_rol_usuario where sist_id = ".$request['sist_id']." and ume_usuario = '".$request['usuario']."' order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

        $total_pages = 0;
        if (!$sidx) {
            $sidx = 1;
        }
        $count = $totalg[0]->total;
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $Lista = new \stdClass();
        $Lista->page = $page;
        $Lista->total = $total_pages;
        $Lista->records = $count;
        foreach ($sql as $Index => $Datos) {
            $Lista->rows[$Index]['id'] = $Datos->sro_id;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->sro_id),
                trim($Datos->sro_descripcion)
            );
        }
        return response()->json($Lista);
    }
    
    public function crear_tabla_menus(Request $request)
    {
        header('Content-type: application/json');
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $start = ($limit * $page) - $limit;
        if ($start < 0) {
            $start = 0;
        }
        $totalg = DB::select("select count(*) as total from permisos.vw_rol_menu_usuario where sro_id = ".$request['sro_id']." and ume_usuario = '".$request['usuario']."' ");
        $sql = DB::select("select * from permisos.vw_rol_menu_usuario where sro_id = ".$request['sro_id']." and ume_usuario = '".$request['usuario']."' order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

        $total_pages = 0;
        if (!$sidx) {
            $sidx = 1;
        }
        $count = $totalg[0]->total;
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $Lista = new \stdClass();
        $Lista->page = $page;
        $Lista->total = $total_pages;
        $Lista->records = $count;
        foreach ($sql as $Index => $Datos) {
            $Lista->rows[$Index]['id'] = $Datos->men_id;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->men_id),
                trim($Datos->men_titulo),
                trim($Datos->men_descripcion),
                trim($Datos->men_sistema),
            );
        }
        return response()->json($Lista);
    }
    
    public function crear_tabla_asignar_sistemas(Request $request)
    {
        header('Content-type: application/json');
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $start = ($limit * $page) - $limit;
        if ($start < 0) {
            $start = 0;
        }
        $totalg = DB::select("select count(*) as total from permisos.tblsistemas_sis where sist_est = 1");
        $sql = DB::select("select * from permisos.tblsistemas_sis where sist_est = 1 order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);
        
        $ldap_con = ldap_connect("cromotex.com.pe/",389)or die ("Could not connect to LDAP server.");
        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_con, LDAP_OPT_REFERRALS, 0);
        if (@ldap_bind($ldap_con, $this->conexion_ldap()->original['ldap_dn'], $this->conexion_ldap()->original['ldap_password'])) 
        {
            $base_dn = "DC=cromotex,DC=com,DC=pe";

            $filter = "(cn=".$request['usuario'].")";
            $result = @ldap_search($ldap_con,$base_dn, $filter) or exit("NO SE PUDO CONECTAR");
            $entries = ldap_get_entries($ldap_con, $result);
            for ($i=0; $i<$entries["count"]; $i++) 
            {
                $sistema = isset($entries[$i]["department"][0]) ? $entries[$i]["department"][0] : 'cromotes';
            }
            $arreglo = explode(";", $sistema);
        }
        else
        {
            echo "conexion invalida";
        }

        $total_pages = 0;
        if (!$sidx) {
            $sidx = 1;
        }
        $count = $totalg[0]->total;
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $Lista = new \stdClass();
        $Lista->page = $page;
        $Lista->total = $total_pages;
        $Lista->records = $count;
        foreach ($sql as $Index => $Datos) 
        {
            $clave = array_search($Datos->sist_id, $arreglo);
            if ($clave) 
            {
                $marcas = '<i style="width:100%" class="fa fa-check-square-o fa-3x" aria-hidden="true" onclick="fn_asignar_sistemas_usuario('.$clave.',\''.trim($request['usuario']).'\',1,'.$Datos->sist_id.')"></i>';
                $roles = '<button class="btn btn-xs btn-block btn-success" onclick="fn_asignar_roles_usuario('.$Datos->sist_id.',\''.trim($request['usuario']).'\')"><i class="fa fa-plus-square"></i> ROLES</button>';
            }
            else
            {
                $marcas = '<i style="width:100%" class="fa fa-square-o fa-3x" aria-hidden="true" onclick="fn_asignar_sistemas_usuario('.$Datos->sist_id.',\''.trim($request['usuario']).'\',0,'.$Datos->sist_id.')"></i>';
                $roles = '<button class="btn btn-xs btn-block btn-success" disabled="disabled"><i class="fa fa-plus-square"></i> ROLES</button>';
            }
            $Lista->rows[$Index]['id'] = $Datos->sist_id;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->sist_id),
                trim($Datos->sist_desc),
                trim($Datos->sist_rut),
                $marcas,
                $roles
            );
        }
        return response()->json($Lista);
    }
    
    public function traer_roles_sistemas(Request $request)
    {
        $roles = DB::table('permisos.tblsistemasrol_sro')->where([['sist_id',$request['sist_id']],['sro_estado',1]])->get();
        return $roles;
    }
    
    public function crear_accesos_sistemas(Request $request)
    {
        $ldap_con = ldap_connect("cromotex.com.pe/",389)or die ("Could not connect to LDAP server.");
        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_con, LDAP_OPT_REFERRALS, 0);
        if (@ldap_bind($ldap_con, $this->conexion_ldap()->original['ldap_dn'], $this->conexion_ldap()->original['ldap_password'])) 
        {
            $base_dn = "DC=cromotex,DC=com,DC=pe";
            
            $filter = "(cn=".$request['usuario'].")";
            $result = @ldap_search($ldap_con,$base_dn, $filter) or exit("NO SE PUDO CONECTAR");
            $entries = ldap_get_entries($ldap_con, $result);
            
            for ($i=0; $i<$entries["count"]; $i++) 
            {
                $sistema = isset($entries[$i]["department"][0]) ? $entries[$i]["department"][0] : 'cromotex';
                $dn = isset($entries[$i]["dn"]) ? $entries[$i]["dn"] : '-';
            }
            
            if ($sistema == 'cromotex') 
            {
                $attr['department'] = '0;'.$request['sist_id'];
                $respuesta = ldap_modify($ldap_con, $dn, $attr);
            }
            else
            {
                $nuevo = $sistema.';'.$request['sist_id'];
                $attr['department'] = $nuevo;
                $respuesta = ldap_modify($ldap_con, $dn, $attr);
            }
            
            if (TRUE === $respuesta) 
            {
                return 1;
            } 
            else 
            {
                return 0;
            }

        }
        else
        {
            echo "conexion invalida";
        }
    }
    
    public function crear_accesos_roles(Request $request)
    {
        $asignacion = DB::select("select * from permisos.asignar_menu_usuario('".$request['usuario']."',".$request['sro_id'].",".$request['sist_id'].")");
        return $asignacion;
    }
    
    public function crear_tabla_submenus(Request $request)
    {
        header('Content-type: application/json');
        $page = $_GET['page'];
        $limit = $_GET['rows'];
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $start = ($limit * $page) - $limit;
        if ($start < 0) {
            $start = 0;
        }
        $totalg = DB::select("select count(*) as total from permisos.vw_rol_submenu_usuario where sro_id = ".$request['sro_id']." and ume_usuario = '".$request['usuario']."' and men_id = ".$request['men_id']." and sist_id = ".$request['sist_id']." ");
        $sql = DB::select("select * from permisos.vw_rol_submenu_usuario where sro_id = ".$request['sro_id']." and ume_usuario = '".$request['usuario']."' and men_id = ".$request['men_id']." and sist_id = ".$request['sist_id']." order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

        $total_pages = 0;
        if (!$sidx) {
            $sidx = 1;
        }
        $count = $totalg[0]->total;
        if ($count > 0) {
            $total_pages = ceil($count / $limit);
        }
        if ($page > $total_pages) {
            $page = $total_pages;
        }
        $Lista = new \stdClass();
        $Lista->page = $page;
        $Lista->total = $total_pages;
        $Lista->records = $count;
        foreach ($sql as $Index => $Datos) {
            $Lista->rows[$Index]['id'] = $Datos->ume_id;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->ume_id),
                trim($Datos->ume_usuario),
                trim($Datos->sro_id),
                trim($Datos->men_id),
                trim($Datos->sist_id),
                trim($Datos->sme_titulo),
                trim($Datos->btn_view),
                trim($Datos->btn_new),
                trim($Datos->btn_edit),
                trim($Datos->btn_del),
                trim($Datos->btn_print),
            );
        }
        return response()->json($Lista);
    }
    
}
