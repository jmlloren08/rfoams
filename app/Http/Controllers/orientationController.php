<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class orientationController extends Controller
{
    public function index()
    {
        return view('admin.orientation');
    }
}
