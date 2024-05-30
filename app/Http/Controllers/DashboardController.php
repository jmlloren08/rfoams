<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\eBOSS;

class DashboardController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType) || $userType === 'Guest') {
            return view('admin.guest');
        }
        
        $counteBOSS = eBOSS::count('date_of_inspection');

        return view('admin.dashboard', [
            'counteBOSS' => $counteBOSS
        ]);
    }
}
