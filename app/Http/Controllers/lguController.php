<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditTrail;
use App\Models\Barangay;
use App\Models\CitiesMunicipalities;
use App\Models\Province;
use App\Models\Region;

class lguController extends Controller
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
            'event' => 'User viewed LGUs Page.'
        ]);
        return view('admin.lgus');
    }
    public function getDataFromRefRegion(Request $request)
    {
        try {

            $draw           = $request->input('draw');
            $start          = $request->input('start');
            $length         = $request->input('length');
            $searchValue    = $request->input('search.value');
            $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query          = Region::query();

            if (!empty($searchValue)) {
                $query->whereAny([
                    'psgc_code',
                    'reg_desc',
                    'reg_code'
                ], 'like', "%$searchValue%")->get();
            }

            $totalRecords = $query->count();
            $query->orderBy($orderColumn, $orderDirection);
            $filteredRecords = $query->count();
            $regions = $query->skip($start)
                ->take($length)
                ->get(['*']);

            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $regions
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching region: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function getDataFromRefProvince(Request $request)
    {
        try {

            $draw           = $request->input('draw');
            $start          = $request->input('start');
            $length         = $request->input('length');
            $searchValue    = $request->input('search.value');
            $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query          = Province::query();

            if (!empty($searchValue)) {
                $query->whereAny([
                    'psgc_code',
                    'prov_desc',
                    'reg_code',
                    'prov_code'
                ], 'like', "%$searchValue%")->get();
            }

            $totalRecords = $query->count();
            $query->orderBy($orderColumn, $orderDirection);
            $filteredRecords = $query->count();
            $provinces = $query->skip($start)
                ->take($length)
                ->get(['*']);

            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $provinces
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching province: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function getDataFromRefCityMun(Request $request)
    {
        try {

            $draw           = $request->input('draw');
            $start          = $request->input('start');
            $length         = $request->input('length');
            $searchValue    = $request->input('search.value');
            $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query          = CitiesMunicipalities::query();

            if (!empty($searchValue)) {
                $query->whereAny([
                    'psgc_code',
                    'citymun_desc',
                    'reg_code',
                    'prov_code',
                    'citymun_code'
                ], 'like', "%$searchValue%")->get();
            }

            $totalRecords = $query->count();
            $query->orderBy($orderColumn, $orderDirection);
            $filteredRecords = $query->count();
            $citiesmunicipalities = $query->skip($start)
                ->take($length)
                ->get(['*']);

            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $citiesmunicipalities
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching cities/municipalities: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function getDataFromRefBarangay(Request $request)
    {
        try {

            $draw           = $request->input('draw');
            $start          = $request->input('start');
            $length         = $request->input('length');
            $searchValue    = $request->input('search.value');
            $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query          = Barangay::query();

            if (!empty($searchValue)) {
                $query->whereAny([
                    'brgy_code',
                    'brgy_desc',
                    'reg_code',
                    'prov_code',
                    'citymun_code'
                ], 'like', "%$searchValue%")->get();
            }

            $totalRecords = $query->count();
            $query->orderBy($orderColumn, $orderDirection);
            $filteredRecords = $query->count();
            $barangays = $query->skip($start)
                ->take($length)
                ->get(['*']);

            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $barangays
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching barangays: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
