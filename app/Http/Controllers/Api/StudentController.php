<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index() {
        return 'Obteniendo lista de estudiantes desde el controlador';
    }
}
