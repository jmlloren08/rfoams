<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ebossController extends Controller
{
    public function index()
    {
        return view('admin.eboss');
    }
}
