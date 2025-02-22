<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class userController extends Controller
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
            'event' => 'User viewed User Page.'
        ]);
        return view('admin.users');
    }
    public function edit($id)
    {
        try {
            $data = User::where('id', $id)->first();

            if (!$data) {
                return response()->json(['errors' => 'Data not found.'], 404);
            }
            // log the login action
            AuditTrail::create([
                'user_id'   => Auth::user()->id,
                'event'     => 'User edit data for updating (User Page).'
            ]);
            return response()->json($data);
        } catch (\Exception $e) {
            Log::error("Error getting data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'roles' => ['required', 'string', 'max:255']
            ]);

            $role = User::findOrFail($id);

            $role->roles = $request->roles;
            $role->save();
            // log the login action
            AuditTrail::create([
                'user_id'   => Auth::user()->id,
                'event'     => 'User modified role assignment (User Page).'
            ]);
            return response()->json(['assigned' =>  'User role was successfully assigned.'], 200);
        } catch (\Exception $e) {

            Log::error("Error assigning role: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function removeAssignedRole(Request $request, $id)
    {
        try {

            $role = User::findOrFail($id);

            $role->roles    = $request->roles;
            $role->save();
            // log 
            AuditTrail::create([
                'user_id'   => Auth::user()->id,
                'event'     => 'User removed role assignment (User Page).'
            ]);
            return response()->json(['removed' =>  'User role assigned was successfully removed.'], 200);
        } catch (\Exception $e) {

            Log::error("Error removing role: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function getDataFromUsers(Request $request)
    {
        try {

            $draw           = $request->input('draw');
            $start          = $request->input('start');
            $length         = $request->input('length');
            $searchValue    = $request->input('search.value');
            $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query = User::query();

            if (!empty($searchValue)) {
                $query->whereAny([
                    'name',
                    'email',
                    'roles'
                ], 'like', "%$searchValue%")->get();
            }

            $totalRecords = $query->count();
            $query->orderBy($orderColumn, $orderDirection);
            $filteredRecords = $query->count();
            $users = $query->skip($start)
                ->take($length)
                ->get();

            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $users
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching Users: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function delete($id)
    {
        try {
            User::where('id', $id)->delete();
            // log 
            AuditTrail::create([
                'user_id'   => Auth::user()->id,
                'event'     => 'User removed user (User Page).'
            ]);
            return response()->json(['success' => 'Data deleted successfully.'], 200);
        } catch (\Exception $e) {

            Log::error("Error deleting data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
}
