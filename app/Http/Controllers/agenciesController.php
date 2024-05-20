<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class agenciesController extends Controller
{
    public function index()
    {
        return view('admin.agencies');
    }
}
