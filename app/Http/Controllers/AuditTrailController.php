<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuditTrailController extends Controller
{
    public function index()
    {
        AuditTrail::create([
            'user_id' => Auth::user()->id,
            'event' => 'User viewed Audit Trail page.'
        ]);
        return view('admin.audit');
    }
    public function getDataFromAuditTrail(Request $request)
    {
        try {

            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');
            $searchValue = $request->input('search.value');
            $orderColumn = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query = AuditTrail::query()
                ->join('users', 'audit_trails.user_id', '=', 'users.id');

            if (!empty($searchValue)) {
                $query->whereAny([
                    'name',
                    'email',
                    'roles'
                ], 'like', "%$searchValue%")->get();
            }
            // get the total records before pagination and filtering
            $totalRecords = $query->count();
            // select name from users
            $query->select('audit_trails.*', 'users.name');
            // order the results
            $query->orderBy($orderColumn, $orderDirection);
            // get total records after filtering
            $filteredRecords = $query->count();
            // pagination
            $logs = $query->skip($start)
                ->take($length)
                ->get();
            // prepare the response
            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $logs
            ];
            // send the response
            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching logs: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
