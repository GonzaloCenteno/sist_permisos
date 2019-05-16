<?php

namespace App\Http\Controllers\general;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Usuarios_Controller extends Controller
{
    
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
        }
    }

    public function create(Request $request)
    {
       
    }

    public function edit($id,Request $request)
    {
        
    }

    public function destroy(Request $request)
    {
        
    }

    public function store(Request $request)
    {
       
    }
    
    public function crear_tabla_usuarios(Request $request)
    {
        $ldap_dn = "CN=gcenteno,OU=sistemas,OU=Administrativos,OU=Cromotex_Usuarios,OU=Transportes Cromotex,DC=cromotex,DC=com,DC=pe";
        $ldap_password = "Abril2019";
        $ldap_con = ldap_connect("cromotex.com.pe/",389)or die ("Could not connect to LDAP server.");
        
        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_con, LDAP_OPT_REFERRALS, 0);
       
        if (@ldap_bind($ldap_con, $ldap_dn, $ldap_password)) 
        {
            $base_dn = "DC=cromotex,DC=com,DC=pe";
            
            $filter = "(cn=*)";
            $result = @ldap_search($ldap_con,$base_dn, $filter) or exit("NO SE PUDO CONECTAR");
            $entries = ldap_get_entries($ldap_con, $result);
            
            $arreglo = array();
            
            for ($i=0; $i<$entries["count"]; $i++) 
            {
                $cn                 = isset($entries[$i]["cn"][0]) ? $entries[$i]["cn"][0] : '-';
                $displayname        = isset($entries[$i]["displayname"][0]) ? $entries[$i]["displayname"][0] : '-';
                $dn                 = isset($entries[$i]["dn"]) ? $entries[$i]["dn"] : '-';
                $userprincipalname  = isset($entries[$i]["userprincipalname"][0]) ? $entries[$i]["userprincipalname"][0] : '-';
                if(isset($entries[$i]['useraccountcontrol'][0]))
                {
                    if (($entries[$i]['useraccountcontrol'][0] & 2) == 0) 
                    {
                        $estado = 'HABILITADO';
                    }
                    else
                    {
                        $estado = 'INHABILITADO';
                    }
                }
                else
                {
                    $estado = '-';
                }

                $arreglo[$i]["cn"] = $cn;
                $arreglo[$i]["displayname"] = $displayname;
                $arreglo[$i]["dn"] = $dn;
                $arreglo[$i]["userprincipalname"] = $userprincipalname;
                $arreglo[$i]["estado"] = $estado;
                $arreglo[$i]["ver"] = 1;
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
        $ldap_dn = "CN=gcenteno,OU=sistemas,OU=Administrativos,OU=Cromotex_Usuarios,OU=Transportes Cromotex,DC=cromotex,DC=com,DC=pe";
        $ldap_password = "Abril2019";
        $ldap_con = ldap_connect("cromotex.com.pe/",389)or die ("Could not connect to LDAP server.");
        
        ldap_set_option($ldap_con, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_con, LDAP_OPT_REFERRALS, 0);
       
        if (@ldap_bind($ldap_con, $ldap_dn, $ldap_password)) 
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
        $totalg = DB::select("select count(*) as total from tblsistemas_sis where sist_id in(".$request['datos'].") and sist_est = 1");
        $sql = DB::select("select * from tblsistemas_sis where sist_id in(".$request['datos'].") and sist_est = 1 order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

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
                trim($Datos->sist_rut)
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
        $totalg = DB::select("select count(*) as total from tblsistemasrol_sro where sist_id = ".$request['sist_id']." and sro_estado = 1");
        $sql = DB::select("select * from tblsistemasrol_sro where sist_id = ".$request['sist_id']." and sro_estado = 1 order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

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
        $totalg = DB::select("select count(*) as total from tblmenu_men where sist_id = ".$request['sist_id']." ");
        $sql = DB::select("select * from tblmenu_men where sist_id = ".$request['sist_id']." order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

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
                trim($Datos->men_descripcion),
                trim($Datos->men_titulo),
                trim($Datos->men_sistema),
            );
        }
        return response()->json($Lista);
    }

}
