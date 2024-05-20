<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class lguController extends Controller
{
    public function index()
    {
        return view('admin.lgus');
    }
}
