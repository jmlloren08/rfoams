<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\AuditTrail;

class contactController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType) || $userType === 'Guest') {
            return view('admin.guest');
        }
        // log
        AuditTrail::create([
            'user_id' => Auth::user()->id,
            'event' => 'User viewed Contact Page.'
        ]);
        return view('admin.contact');
    }
}
