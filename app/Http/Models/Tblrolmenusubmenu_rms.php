<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tblrolmenusubmenu_rms extends Model
{
    public $timestamps = false;
    protected $table = 'permisos.tblrolmenusubmenu_rms';
    protected $primaryKey= 'rms_id';
}
