<?php

namespace App\Http\Controllers;

use App\Models\RefBrgy;
use App\Models\RefCityMun;
use App\Models\RefProvince;
use App\Models\RefRegionV2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class lguController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType) || $userType === 'Guest') {
            return view('admin.guest');
        }
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

            $query          = RefRegionV2::query();

            if (!empty($searchValue)) {
                $query->whereAny([
                    'psgcCode',
                    'regDesc',
                    'regCode'
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

            $query          = RefProvince::query();

            if (!empty($searchValue)) {
                $query->whereAny([
                    'psgcCode',
                    'provDesc',
                    'regCode',
                    'provCode'
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

            $query          = RefCityMun::query();

            if (!empty($searchValue)) {
                $query->whereAny([
                    'psgcCode',
                    'citymunDesc',
                    'regCode',
                    'provCode',
                    'citymunCode'
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

            Log::error("Error fetching citiesmunicipalities: " . $e->getMessage());
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

            $query          = RefBrgy::query();

            if (!empty($searchValue)) {
                $query->whereAny([
                    'brgyCode',
                    'brgyDesc',
                    'regCode',
                    'provCode',
                    'citymunCode'
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
