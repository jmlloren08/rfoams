<?php

namespace App\Http\Controllers;

use App\Models\DepartmentAgency;
use App\Models\RefCityMun;
use App\Models\RefProvince;
use App\Models\RefRegionV2;
use App\Models\RFOsV2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\OrientationOverall;
use App\Models\AuditTrail;

class orientationOverallController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType) || $userType === 'Guest') {
            return view('admin.guest');
        }
        // get the id of the logged in user
        $user_id = Auth::user()->id;
        // get the regions for the logged in user
        $regionData = RFOsV2::where('user_id', $user_id)->pluck('regCode');
        if ($userType === 'Administrator') {
            $regions = RefRegionV2::select('regDesc', 'regCode')->get();
        } else {
            $regions = RefRegionV2::select('regDesc', 'regCode')
                ->whereIn('regCode', $regionData)
                ->get();
        }

        $agencies_lgus = DepartmentAgency::select('id', 'department_agencies')->get();
        // log
        AuditTrail::create([
            'user_id' => Auth::user()->id,
            'event' => 'User viewed Orientation - Inspected Agencies Page.'
        ]);
        return view('admin.orientation-overalls', [
            'regions_overall' => $regions,
            'agencies_lgus' => $agencies_lgus
        ]);
    }
    public function store(Request $request)
    {
        try {

            // validate
            $request->validate([
                'orientation_date'          => ['required', 'string', 'max:255'],
                'agency_lgu'                => ['required', 'string', 'max:255'],
                'office'                    => ['required', 'string', 'max:255'],
                'city_municipality'         => ['required', 'string', 'max:255'],
                'province'                  => ['required', 'string', 'max:255'],
                'region'                    => ['required', 'string', 'max:255'],
                'is_ra_11032'               => ['required', 'string', 'max:255'],
                'is_cart'                   => ['required', 'string', 'max:255'],
                'is_programs_and_services'  => ['required', 'string', 'max:255'],
                'is_cc_orientation'         => ['required', 'string', 'max:255'],
                'is_cc_workshop'            => ['required', 'string', 'max:255'],
                'is_bpm_workshop'           => ['required', 'string', 'max:255'],
                'is_ria'                    => ['required', 'string', 'max:255'],
                'is_eboss'                  => ['required', 'string', 'max:255'],
                'is_csm'                    => ['required', 'string', 'max:255'],
                'is_reeng'                  => ['required', 'string', 'max:255']
            ]);

            // save record
            $orientationOverall = new OrientationOverall;
            $orientationOverall->orientation_date           = $request->orientation_date;
            $orientationOverall->agency_lgu                 = $request->agency_lgu;
            $orientationOverall->office                     = $request->office;
            $orientationOverall->city_municipality          = $request->city_municipality;
            $orientationOverall->province                   = $request->province;
            $orientationOverall->region                     = $request->region;
            $orientationOverall->is_ra_11032                = $request->is_ra_11032;
            $orientationOverall->is_cart                    = $request->is_cart;
            $orientationOverall->is_programs_and_services   = $request->is_programs_and_services;
            $orientationOverall->is_cc_orientation          = $request->is_cc_orientation;
            $orientationOverall->is_cc_workshop             = $request->is_cc_workshop;
            $orientationOverall->is_bpm_workshop            = $request->is_bpm_workshop;
            $orientationOverall->is_ria                     = $request->is_ria;
            $orientationOverall->is_eboss                   = $request->is_eboss;
            $orientationOverall->is_csm                     = $request->is_csm;
            $orientationOverall->is_reeng                   = $request->is_reeng;
            $orientationOverall->save();
            // log
            AuditTrail::create([
                'user_id' => Auth::user()->id,
                'event' => 'User added new data (Orientation - Overall Page).'
            ]);
            return response()->json(['success' => 'Data added successfully.'], 200);
        } catch (ValidationException $e) {

            return response()->json(['errors' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            Log::error("Error adding orientation (overall): " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function edit($id)
    {
        try {

            $data = OrientationOverall::where('id', $id)->first();

            if (!$data) {
                return response()->json(['errors' => 'Data not found.'], 404);
            }
            // log
            AuditTrail::create([
                'user_id' => Auth::user()->id,
                'event' => 'User edit data for updating (Orientation - Overall Page).'
            ]);
            return response()->json($data);
        } catch (\Exception $e) {
            Log::error("Error getting data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function delete($id)
    {
        try {

            OrientationOverall::where('id', $id)->delete();
            // log
            AuditTrail::create([
                'user_id' => Auth::user()->id,
                'event' => 'User removed data (Orientation - Overall Page).'
            ]);
            return response()->json(['success' => 'Data deleted successfully.'], 200);
        } catch (\Exception $e) {
            Log::error("Error deleting data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            // validate
            $request->validate([
                'orientation_date'          => ['required', 'string', 'max:255'],
                'agency_lgu'                => ['required', 'string', 'max:255'],
                'office'                    => ['required', 'string', 'max:255'],
                'city_municipality'         => ['required', 'string', 'max:255'],
                'province'                  => ['required', 'string', 'max:255'],
                'region'                    => ['required', 'string', 'max:255'],
                'is_ra_11032'               => ['required', 'string', 'max:255'],
                'is_cart'                   => ['required', 'string', 'max:255'],
                'is_programs_and_services'  => ['required', 'string', 'max:255'],
                'is_cc_orientation'         => ['required', 'string', 'max:255'],
                'is_cc_workshop'            => ['required', 'string', 'max:255'],
                'is_bpm_workshop'           => ['required', 'string', 'max:255'],
                'is_ria'                    => ['required', 'string', 'max:255'],
                'is_eboss'                  => ['required', 'string', 'max:255'],
                'is_csm'                    => ['required', 'string', 'max:255'],
                'is_reeng'                  => ['required', 'string', 'max:255']
            ]);

            $orientationOverall = OrientationOverall::findOrFail($id);

            // update record
            $orientationOverall->orientation_date           = $request->orientation_date;
            $orientationOverall->agency_lgu                 = $request->agency_lgu;
            $orientationOverall->office                     = $request->office;
            $orientationOverall->city_municipality          = $request->city_municipality;
            $orientationOverall->province                   = $request->province;
            $orientationOverall->region                     = $request->region;
            $orientationOverall->is_ra_11032                = $request->is_ra_11032;
            $orientationOverall->is_cart                    = $request->is_cart;
            $orientationOverall->is_programs_and_services   = $request->is_programs_and_services;
            $orientationOverall->is_cc_orientation          = $request->is_cc_orientation;
            $orientationOverall->is_cc_workshop             = $request->is_cc_workshop;
            $orientationOverall->is_bpm_workshop            = $request->is_bpm_workshop;
            $orientationOverall->is_ria                     = $request->is_ria;
            $orientationOverall->is_eboss                   = $request->is_eboss;
            $orientationOverall->is_csm                     = $request->is_csm;
            $orientationOverall->is_reeng                   = $request->is_reeng;
            $orientationOverall->save();
            // log
            AuditTrail::create([
                'user_id' => Auth::user()->id,
                'event' => 'User modified data (Orientation - Overall Page).'
            ]);
            return response()->json(['success' => 'Data updated successfully.'], 200);
        } catch (\Exception $e) {

            Log::error("Error updating data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function getDataFromOrientationOverall(Request $request)
    {
        try {

            $draw           = $request->input('draw');
            $start          = $request->input('start');
            $length         = $request->input('length');
            $searchValue    = $request->input('search.value');
            $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query = OrientationOverall::query()
                ->join('ref_city_muns', 'orientation_overalls.city_municipality', '=', 'ref_city_muns.citymunCode')
                ->join('ref_provinces', 'orientation_overalls.province', '=', 'ref_provinces.provCode')
                ->join('ref_region_v2_s', 'orientation_overalls.region', '=', 'ref_region_v2_s.regCode');

            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('orientation_overalls.orientation_date', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.agency_lgu', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.office', 'like', "%$searchValue%")
                        ->orWhere('ref_city_muns.citymunDesc', 'like', "%$searchValue%")
                        ->orWhere('ref_provinces.provDesc', 'like', "%$searchValue%")
                        ->orWhere('ref_region_v2_s.regDesc', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.is_ra_11032', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.is_cart', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.is_programs_and_services', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.is_cc_orientation', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.is_cc_workshop', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.is_bpm_workshop', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.is_ria', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.is_eboss', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.is_csm', 'like', "%$searchValue%")
                        ->orWhere('orientation_overalls.is_reeng', 'like', "%$searchValue%");
                });
            }
            // get the total records before pagination and filtering
            $totalRecords = $query->count();
            // select only the necessary columns
            $user_id = Auth::user()->id;
            $userType = Auth::user()->roles;
            // get the regions for the logged in user
            $regionData = RFOsv2::where('user_id', $user_id)->pluck('regCode');
            if ($userType === 'Administrator') {
                $query->select('orientation_overalls.*', 'ref_city_muns.citymunDesc', 'ref_provinces.provDesc', 'ref_region_v2_s.regDesc');
            } else {
                $query->select('orientation_overalls.*', 'ref_city_muns.citymunDesc', 'ref_provinces.provDesc', 'ref_region_v2_s.regDesc')
                    ->whereIn('region', $regionData);
            }
            // order the results
            $query->orderBy($orderColumn, $orderDirection);
            // get total records after filtering
            $filteredRecords = $query->count();
            // pagination
            $orientationsOverall = $query->skip($start)
                ->take($length)
                ->get();
            // prepare the response
            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $orientationsOverall
            ];
            // send response json
            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching Orientation (Overall): " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
    public function getProvincesByRegion(Request $request)
    {
        $regionCode = $request->region;
        $provinces = RefProvince::where('regCode', $regionCode)->get();

        return response()->json($provinces);
    }
    public function getCityMunicipalityByProvince(Request $request)
    {
        $provinceCode = $request->province;
        $citymunicipality = RefCityMun::where('provCode', $provinceCode)->get();

        return response()->json($citymunicipality);
    }
}
