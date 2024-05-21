<?php

namespace App\Http\Controllers;

use App\Models\DepartmentAgency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class agenciesController extends Controller
{
    public function index()
    {
        return view('admin.agencies');
    }
    public function getDataFromDepartmentAgency(Request $request)
    {
        try {

            $draw           = $request->input('draw');
            $start          = $request->input('start');
            $length         = $request->input('length');
            $searchValue    = $request->input('search.value');
            $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query          = DepartmentAgency::query();

            if (!empty($searchValue)) {
                $query->whereAny([
                    'department_agencies',
                    'address',
                    'contact_number'
                ], 'like', "%$searchValue%")->get();
            }

            $totalRecords = $query->count();
            $query->orderBy($orderColumn, $orderDirection);
            $filteredRecords = $query->count();
            $departmentsagencies = $query->skip($start)
                ->take($length)
                ->get(['*']);

            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $departmentsagencies
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching departments/agencies: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
