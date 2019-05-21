<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tblusuariomenu_ume extends Model
{
    public $timestamps = false;
    protected $table = 'permisos.tblusuariomenu_ume';
    protected $primaryKey= 'ume_id';
}
