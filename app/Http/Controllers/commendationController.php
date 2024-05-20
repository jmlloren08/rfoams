<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class commendationController extends Controller
{
    public function index()
    {
        return view('admin.commendation');
    }
}
