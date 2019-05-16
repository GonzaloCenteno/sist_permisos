<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tblrolmenu_rme extends Model
{
    public $timestamps = false;
    protected $table = 'permisos.tblrolmenu_rme';
    protected $primaryKey= 'rme_id';
}
