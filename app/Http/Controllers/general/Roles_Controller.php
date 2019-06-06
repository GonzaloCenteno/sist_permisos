<?php

namespace App\Http\Controllers\general;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Models\Tblsubmenu_sme;
use App\Http\Models\Tblmenu_men;
use App\Http\Models\Tblrolmenu_rme;
use App\Http\Models\Tblrolmenusubmenu_rms;
use App\Http\Models\Tblusuariosubmenu_usm;
use App\Http\Models\Tblusuariomenu_ume;

class Roles_Controller extends Controller
{
    public function TblSubmenu_Sme()
    {
        $Tblsubmenu_sme = new Tblsubmenu_sme;
        return $Tblsubmenu_sme;
    }
    
    public function index(Request $request)
    {
        return view('general/vw_roles');
    }

    public function show($id, Request $request)
    {
        if ($id > 0) 
        {
            
        }
        else
        {
            if ($request['tabla'] == 'sistemas') 
            {
                return $this->crear_tabla_sistemas($request);
            }
            if ($request['tabla'] == 'roles') 
            {
                return $this->crear_tabla_roles_sistema($request);
            }
            if ($request['tabla'] == 'menus') 
            {
                return $this->crear_tabla_menu_roles($request);
            }
            if ($request['tabla'] == 'submenus') 
            {
                return $this->crear_tabla_submenu_menus($request);
            }
            if ($request['tabla'] == 'selectmenu') 
            {
                return $this->crear_tabla_seleccionar_menu($request);
            }
            if ($request['tabla'] == 'selectsubmenu') 
            {
                return $this->crear_tabla_seleccionar_sub_menu($request);
            }
            if ($request['show'] == 'traer_datos_menu') 
            {
                return $this->traer_datos_menu($request);
            }
            if ($request['show'] == 'traer_datos_submenu') 
            {
                return $this->traer_datos_submenu($request);
            }
        }
    }

    public function create(Request $request)
    {
        if ($request['tipo'] == 1) 
        {
            return $this->crear_menu($request);
        }
        if ($request['tipo'] == 2) 
        {
            return $this->crear_asignacion_menu_rol($request);
        }
        if ($request['tipo'] == 3) 
        {
            return $this->crear_submenu($request);
        }
        if ($request['tipo'] == 4) 
        {
            return $this->crear_asignacion_submenu_rol($request);
        }
        if ($request['tipo'] == 5) 
        {
            return $this->crear_rol_sistema($request);
        }
    }

    public function edit($id,Request $request)
    {
        if ($request['tipo'] == 1) 
        {
            return $this->editar_submenu_rol($id,$request);
        }
        if ($request['tipo'] == 2) 
        {
            return $this->editar_menu_rol($id,$request);
        }
    }

    public function destroy(Request $request)
    {
        if ($request['tipo'] == 1) 
        {
            return $this->eliminar_asignacion_menu_rol($request);
        }
        if ($request['tipo'] == 2) 
        {
            return $this->eliminar_asignacion_submenu_rol($request);
        }
    }

    public function store(Request $request)
    {
        if ($request['tipo'] == 1) 
        {
            return $this->modificar_orden_menu($request);
        }
        if ($request['tipo'] == 2) 
        {
            return $this->modificar_orden_submenu($request);
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
        $totalg = DB::select("select count(*) as total from permisos.tblsistemas_sis where sist_est = 1");
        $sql = DB::select("select * from permisos.tblsistemas_sis where sist_est = 1 order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

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
                trim($Datos->sist_est),
                '<button class="btn btn-xl btn-danger" type="button" id="btn_agregar_roles"><i class="fa fa-plus"></i> AGREGAR</button>',
                '<button class="btn btn-xl btn-success" type="button" id="btn_agregar_menus"><i class="fa fa-plus"></i> AGREGAR</button>',  
            );
        }
        return response()->json($Lista);
    }
    
    public function crear_tabla_roles_sistema(Request $request)
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
        $totalg = DB::select("select count(*) as total from permisos.tblsistemasrol_sro where sro_estado = 1 and sist_id = ".$request['sist_id']." ");
        $sql = DB::select("select * from permisos.tblsistemasrol_sro where sro_estado = 1 and sist_id = ".$request['sist_id']." order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

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
                trim($Datos->sro_descripcion),
                trim($Datos->sro_estado)
            );
        }
        return response()->json($Lista);
    }
    
    public function crear_tabla_menu_roles(Request $request)
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
        $totalg = DB::select("select count(*) as total from permisos.vw_rol_menu where sro_id = ".$request['sro_id']." and sist_id = ".$request['sist_id']." ");
        $sql = DB::select("select * from permisos.vw_rol_menu where sro_id = ".$request['sro_id']." and sist_id = ".$request['sist_id']." order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

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
            $Lista->rows[$Index]['id'] = $Datos->rme_id;    
            if($Datos->rme_estado == 1)
            {
                $marcas = '<i style="width:100%" class="fa fa-check-square-o fa-3x" aria-hidden="true" onclick="fn_cambiar_estado_menu_roles('.$Datos->rme_id.',0)"></i>';
            }
            else
            {
                $marcas = '<i style="width:100%" class="fa fa-square-o fa-3x" aria-hidden="true" onclick="fn_cambiar_estado_menu_roles('.$Datos->rme_id.',1)"></i>';
            }
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->rme_id),
                trim($Datos->men_id),
                $marcas,
                trim($Datos->men_titulo),
                trim($Datos->men_descripcion),
                trim($Datos->men_sistema),
            );
        }
        return response()->json($Lista);
    }
    
    public function crear_tabla_submenu_menus(Request $request)
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
        $totalg = DB::select("select count(*) as total from permisos.vw_rol_submenu where men_id = ".$request['men_id']." and sist_id = ".$request['sist_id']." and sro_id = ".$request['sro_id']." ");
        $sql = DB::select("select * from permisos.vw_rol_submenu where men_id = ".$request['men_id']." and sist_id = ".$request['sist_id']." and sro_id = ".$request['sro_id']." order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

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
            $Lista->rows[$Index]['id'] = $Datos->rms_id;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->rms_id),
                trim($Datos->sme_id),
                trim($Datos->men_id),
                trim($Datos->sist_id),
                trim($Datos->sro_id),
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
    
    public function crear_menu(Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                $Tblmenu_men = new Tblmenu_men;
                $Tblmenu_men->insert([
                    'men_descripcion' => trim(strtoupper($request['men_descripcion'])),
                    'men_titulo' => trim(strtoupper($request['men_titulo'])),
                    'men_sistema' => trim(strtolower($request['men_sistema'])),
                    'sist_id' => $request['sist_id'],
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
    
    public function crear_tabla_seleccionar_menu(Request $request)
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
        $totalg = DB::select("select count(*) as total from permisos.tblmenu_men where sist_id = ".$request['sist_id']." ");
        $sql = DB::select("select * from permisos.tblmenu_men where sist_id = ".$request['sist_id']." order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

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
            $menus = DB::table('permisos.tblrolmenu_rme')->where([['sro_id',$request['sro_id']],['men_id',$Datos->men_id]])->get();
            if (count($menus) >= 1) 
            {
                $marcas = '<i style="width:100%" class="fa fa-check-square-o fa-3x" aria-hidden="true" onclick="fn_crear_menus_rol('.$menus[0]->rme_id.',1)"></i>';
            }
            else
            {
                $marcas = '<i style="width:100%" class="fa fa-square-o fa-3x" aria-hidden="true" onclick="fn_crear_menus_rol('.$Datos->men_id.',0)"></i>';
            }
            $Lista->rows[$Index]['id'] = $Datos->men_id;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->men_id),
                trim($Datos->men_titulo),
                $marcas
            );
        }
        return response()->json($Lista);
    }
    
    public function crear_asignacion_menu_rol(Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                $Tblrolmenu_rme = new Tblrolmenu_rme;
                $Tblusuariomenu_ume = new Tblusuariomenu_ume;
                $Tblrolmenu_rme->sro_id = $request['sro_id'];
                $Tblrolmenu_rme->men_id = $request['men_id'];
                $Tblrolmenu_rme->save();
                
                $datos = $Tblusuariomenu_ume::select(DB::raw('distinct ume_usuario,sist_id'))->where([['sro_id',$request['sro_id']],['sist_id',$request['sist_id']]])->get();
                for($i = 0; $i < $datos->count();$i++)
                {
                    $Tblusuariomenu_ume->insert([
                        'ume_usuario' => $datos[$i]->ume_usuario,
                        'sist_id' => $datos[$i]->sist_id,
                        'sro_id' => $request['sro_id'],
                        'men_id' => $request['men_id'],
                        'rme_id' => $Tblrolmenu_rme->rme_id
                    ]);
                }
                
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
    
    public function crear_submenu(Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                
                $this->TblSubmenu_Sme()->insert([
                    'sme_descripcion' => trim(strtoupper($request['sme_descripcion'])),
                    'sme_titulo' => trim(strtoupper($request['sme_titulo'])),
                    'sme_sistema' => trim(strtolower($request['sme_sistema'])),
                    'sme_ruta' => trim(strtolower($request['sme_ruta'])),
                    'sist_id' => $request['sist_id'],
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
    
    public function crear_tabla_seleccionar_sub_menu(Request $request)
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
        $totalg = DB::select("select count(*) as total from permisos.tblsubmenu_sme where sist_id = ".$request['sist_id']." ");
        $sql = DB::select("select * from permisos.tblsubmenu_sme where sist_id = ".$request['sist_id']." order by ".$sidx." ".$sord." limit ".$limit." offset ".$start);

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
            $submenus = DB::table('permisos.tblrolmenusubmenu_rms')->where([['sro_id',$request['sro_id']],['men_id',$request['men_id']],['sme_id',$Datos->sme_id]])->get();
            if (count($submenus) >= 1) 
            {
                $marcas = '<i style="width:100%" class="fa fa-check-square-o fa-3x" aria-hidden="true" onclick="fn_crear_submenus_rol('.$submenus[0]->rms_id.',1)"></i>';
            }
            else
            {
                $marcas = '<i style="width:100%" class="fa fa-square-o fa-3x" aria-hidden="true" onclick="fn_crear_submenus_rol('.$Datos->sme_id.',0)"></i>';
            }
            $Lista->rows[$Index]['id'] = $Datos->sme_id;            
            $Lista->rows[$Index]['cell'] = array(
                trim($Datos->sme_id),
                trim($Datos->sme_titulo),
                $marcas
            );
        }
        return response()->json($Lista);
    }
    
    public function crear_asignacion_submenu_rol(Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                $Tblrolmenusubmenu_rms = new Tblrolmenusubmenu_rms;
                $Tblusuariosubmenu_usm = new Tblusuariosubmenu_usm;
                
                $Tblrolmenusubmenu_rms->sro_id = $request['sro_id'];
                $Tblrolmenusubmenu_rms->men_id = $request['men_id'];
                $Tblrolmenusubmenu_rms->sme_id = $request['sme_id'];

                $Tblrolmenusubmenu_rms->save();
                
                $datos = $Tblusuariosubmenu_usm::select(DB::raw('distinct usm_usuario,sist_id'))->where([['sro_id',$request['sro_id']],['men_id',$request['men_id']],['sist_id',$request['sist_id']]])->get();
                for($i = 0; $i < $datos->count();$i++)
                {
                    $Tblusuariosubmenu_usm->insert([
                        'usm_usuario' => $datos[$i]->usm_usuario,
                        'sist_id' => $datos[$i]->sist_id,
                        'sro_id' => $request['sro_id'],
                        'men_id' => $request['men_id'],
                        'sme_id' => $request['sme_id'],
                        'rms_id' => $Tblrolmenusubmenu_rms->rms_id
                    ]);
                }
                
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
    
    public function eliminar_asignacion_menu_rol(Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                $Tblrolmenu_rme = new Tblrolmenu_rme;
                $Tblusuariomenu_ume = new Tblusuariomenu_ume;
                $Tblrolmenu_rme::where('rme_id',"=",$request['rme_id'])->delete();
                $Tblusuariomenu_ume::where('rme_id',"=",$request['rme_id'])->delete();
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
    
    public function eliminar_asignacion_submenu_rol(Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                $Tblrolmenusubmenu_rms = new Tblrolmenusubmenu_rms;
                $Tblusuariosubmenu_usm = new Tblusuariosubmenu_usm;
                $Tblrolmenusubmenu_rms::where('rms_id',"=",$request['rms_id'])->delete();
                $Tblusuariosubmenu_usm::where('rms_id',"=",$request['rms_id'])->delete();
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
    
    public function traer_datos_menu(Request $request)
    {
        $menu = DB::select("select * from permisos.vw_rol_menu where sro_id = ".$request['sro_id']." and sist_id = ".$request['sist_id']." order by rme_orden asc");
        return $menu;
    }
    
    public function modificar_orden_menu(Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                $Tblrolmenu_rme = new Tblrolmenu_rme;
                $Tblusuariomenu_ume = new Tblusuariomenu_ume;
                $filas = count($request['contador']);
                for($i=0; $i<$filas; $i++)
                {
                    $Tblrolmenu_rme::where('rme_id',$request['rme_id'][$i])->update([
                        'rme_orden' => isset($request['rme_orden'][$i]) ? $request['rme_orden'][$i] : 0,
                    ]);
                    
                    $Tblusuariomenu_ume::where('rme_id',$request['rme_id'][$i])->update([
                        'ume_orden' => isset($request['rme_orden'][$i]) ? $request['rme_orden'][$i] : 0,
                    ]);
                }
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
    
    public function traer_datos_submenu(Request $request)
    {
        $submenu = DB::select("select * from permisos.vw_rol_submenu where men_id = ".$request['men_id']." and sist_id = ".$request['sist_id']." and sro_id = ".$request['sro_id']." order by rms_orden asc");
        return $submenu;
    }
    
    public function modificar_orden_submenu(Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                $Tblrolmenusubmenu_rms = new Tblrolmenusubmenu_rms;
                $Tblusuariosubmenu_usm = new Tblusuariosubmenu_usm;
                $filas = count($request['contador1']);
                for($i=0; $i<$filas; $i++)
                {
                    $Tblrolmenusubmenu_rms::where('rms_id',$request['rms_id'][$i])->update([
                        'rms_orden' => isset($request['rms_orden'][$i]) ? $request['rms_orden'][$i] : 0,
                    ]);
                    
                    $Tblusuariosubmenu_usm::where('rms_id',$request['rms_id'][$i])->update([
                        'usm_orden' => isset($request['rms_orden'][$i]) ? $request['rms_orden'][$i] : 0,
                    ]);
                }
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
    
    public function crear_rol_sistema(Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                
                DB::table('permisos.tblsistemasrol_sro')->insert([
                    'sist_id' => $request['sist_id'],
                    'sro_descripcion' => strtoupper(trim($request['sro_descripcion'])),
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
    
    public function editar_submenu_rol($rms_id,Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                $Tblrolmenusubmenu_rms = new Tblrolmenusubmenu_rms;
                $Tblusuariosubmenu_usm = new Tblusuariosubmenu_usm;
                $Tblrolmenusubmenu_rms::where('rms_id',$rms_id)->update([
                    $request['columna'] => $request['valor'],
                ]);
                
                $Tblusuariosubmenu_usm::where('rms_id',$rms_id)->update([
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
    
    public function editar_menu_rol($rme_id,Request $request)
    {
        if($request->ajax())
        {
            $error = null;

            DB::beginTransaction();
            try{
                $Tblrolmenu_rme = new Tblrolmenu_rme;
                $Tblrolmenusubmenu_rms = new Tblrolmenusubmenu_rms;
                $Tblusuariomenu_ume = new Tblusuariomenu_ume;
                $Tblusuariosubmenu_usm = new Tblusuariosubmenu_usm;
                
                $detalle = $Tblrolmenu_rme::where("rme_id","=",$rme_id)->first();
                if($detalle)
                {
                    $detalle->rme_estado = $request['estado'];
                    $detalle->save();
                }
                
                $Tblrolmenusubmenu_rms::where([['sro_id',$detalle->sro_id],['men_id',$detalle->men_id]])->update([
                    'btn_view' => $detalle->rme_estado,
                ]);
                
                $Tblusuariomenu_ume::where("rme_id","=",$rme_id)->update([
                    'ume_estado' => $request['estado']
                ]);
                
                $Tblusuariosubmenu_usm::where([['sro_id',$detalle->sro_id],['men_id',$detalle->men_id]])->update([
                    'btn_view' => $request['estado']
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
}
