<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function destroy(Request $request)
    {
        // log the logout action before logging the user out
        AuditTrail::create([
            'user_id' => Auth::user()->id,
            'event' => 'User logged out'
        ]);

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function Profile()
    {
        return view('admin.admin_profile_view');
    }
    public function Users()
    {
        return view('admin.users');
    }
}
