<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tblsubmenu_sme extends Model
{
    public $timestamps = false;
    protected $table = 'permisos.tblsubmenu_sme';
    protected $primaryKey= 'sme_id';
    
    public function scopeTblsubmenucount($query) 
    {
      return $query->select(DB::raw('count(*) as total'));
    }
    
    public function scopePaginacion($query,$sidx,$sord,$limit,$start) 
    {
      return $query->orderBy($sidx, $sord)->limit($limit)->offset($start);
    }
    
    public function scopeRecuperar($query,$sme_id) 
    {
      return $query->where('sme_id',$sme_id);
    }
}
