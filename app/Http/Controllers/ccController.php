<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ccController extends Controller
{
    public function index()
    {
        return view('admin.citizens-charter');
    }
}
