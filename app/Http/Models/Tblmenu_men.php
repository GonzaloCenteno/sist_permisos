<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tblmenu_men extends Model
{
    public $timestamps = false;
    protected $table = 'permisos.tblmenu_men';
    protected $primaryKey= 'men_id';
}
