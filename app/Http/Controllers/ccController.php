<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\AuditTrail;

class ccController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType) || $userType === 'Guest') {
            return view('admin.guest');
        }
        AuditTrail::create([
            'user_id' => Auth::user()->id,
            'event' => 'User viewed citizen(s) charter page.'
        ]);
        return view('admin.citizens-charter');
    }
}
