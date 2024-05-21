<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class rfoController extends Controller
{
    public function index()
    {
        return view('admin.rfos');
    }
}
