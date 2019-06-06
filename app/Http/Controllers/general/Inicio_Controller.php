<?php

namespace App\Http\Controllers\general;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Inicio_Controller extends Controller
{
    
    public function index()
    {
        return view('general/vw_inicio');
    }
    
}
