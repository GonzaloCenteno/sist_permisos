<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tblusuariosubmenu_usm extends Model
{
    public $timestamps = false;
    protected $table = 'permisos.tblusuariosubmenu_usm';
    protected $primaryKey= 'usm_id';
}
