<?php

namespace App\Http\Controllers;

use App\Models\Commendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RFOsV2;
use App\Models\RefRegionV2;
use App\Models\RefProvince;
use App\Models\RefCityMun;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class commendationController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType) || $userType === 'Guest') {
            return view('admin.guest');
        }
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
        return view('admin.commendation', [
            'regions' => $regions
        ]);
    }
    public function store(Request $request)
    {
        try {
            // validate
            $request->validate([
                'date_of_commendation'  => ['required', 'date'],
                'city_municipality'     => ['required', 'string', 'max:255'],
                'province'              => ['required', 'string', 'max:255'],
                'region'                => ['required', 'string', 'max:255'],
                'date_of_inspection'    => ['required', 'date']
            ]);
            // save record
            $commendation = new Commendation;
            $commendation->date_of_commendation = $request->date_of_commendation;
            $commendation->city_municipality    = $request->city_municipality;
            $commendation->province             = $request->province;
            $commendation->region               = $request->region;
            $commendation->date_of_inspection   = $request->date_of_inspection;
            $commendation->service_provider     = $request->service_provider;
            $commendation->first_validation     = $request->first_validation;
            $commendation->remarks_1            = $request->remarks_1;
            $commendation->second_validation    = $request->second_Validation;
            $commendation->remarks_2            = $request->remarks_2;
            $commendation->other_activity       = $request->other_activity;
            $commendation->number_of_brgys      = $request->number_of_brgys;
            $commendation->save();
            // return response
            return response()->json(['success' => 'Data added successfully.'], 200);
        } catch (ValidationException $e) {

            return response()->json(['errors' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            Log::error("Error adding commendation: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function edit($id)
    {
        try {
            $data = Commendation::where('id', $id)->first();

            if (!$data) {
                return response()->json(['errors' => 'Data not found.'], 404);
            }

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error("Error getting data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function delete($id)
    {
        try {
            Commendation::where('id', $id)->delete();

            return response()->json(['success' => 'Date deleted successfully.'], 200);
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
                'date_of_commendation'  => ['required', 'date'],
                'city_municipality'     => ['required', 'string', 'max:255'],
                'province'              => ['required', 'string', 'max:255'],
                'region'                => ['required', 'string', 'max:255'],
                'date_of_inspection'    => ['required', 'date']
            ]);
            // save record
            $commendation = Commendation::findOrFail($id);

            $commendation->date_of_commendation = $request->date_of_commendation;
            $commendation->city_municipality    = $request->city_municipality;
            $commendation->province             = $request->province;
            $commendation->region               = $request->region;
            $commendation->date_of_inspection   = $request->date_of_inspection;
            $commendation->service_provider     = $request->service_provider;
            $commendation->first_validation     = $request->first_validation;
            $commendation->remarks_1            = $request->remarks_1;
            $commendation->second_validation    = $request->second_Validation;
            $commendation->remarks_2            = $request->remarks_2;
            $commendation->other_activity       = $request->other_activity;
            $commendation->number_of_brgys      = $request->number_of_brgys;
            $commendation->save();
            // return response
            return response()->json(['success' => 'Data updated successfully.'], 200);
        } catch (ValidationException $e) {

            return response()->json(['errors' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            Log::error("Error adding commendation: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function getDataFromCommendation(Request $request)
    {
        try {

            $draw           = $request->input('draw');
            $start          = $request->input('start');
            $length         = $request->input('length');
            $searchValue    = $request->input('search.value');
            $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query = Commendation::query()
                ->join('ref_city_muns', 'commendations.city_municipality', '=', 'ref_city_muns.citymunCode')
                ->join('ref_provinces', 'commendations.province', '=', 'ref_provinces.provCode')
                ->join('ref_region_v2_s', 'commendations.region', '=', 'ref_region_v2_s.regCode');

            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('commendations.date_of_commendation', 'like', "%$searchValue%")
                        ->orWhere('ref_city_muns.citymunDesc', 'like', "%$searchValue%")
                        ->orWhere('ref_provinces.provDesc', 'like', "%$searchValue%")
                        ->orWhere('ref_region_v2_s.regDesc', 'like', "%$searchValue%")
                        ->orWhere('commendations.date_of_inspection', 'like', "%$searchValue%")
                        ->orWhere('commendations.service_provider', 'like', "%$searchValue%")
                        ->orWhere('commendations.first_validation', 'like', "%$searchValue%")
                        ->orWhere('commendations.remarks_1', 'like', "%$searchValue%")
                        ->orWhere('commendations.second_validation', 'like', "%$searchValue%")
                        ->orWhere('commendations.remarks_2', 'like', "%$searchValue%")
                        ->orWhere('commendations.other_activity', 'like', "%$searchValue%")
                        ->orWhere('commendations.number_of_brgys', 'like', "%$searchValue%");
                });
            }
            // get the total records before pagination and filtering
            $totalRecords = $query->count();
            // load user id and roles
            $user_id = Auth::user()->id;
            $userType = Auth::user()->roles;
            // get the regions based on the logged in user id
            $regionData = RFOsV2::where('user_id', $user_id)->pluck('regCode');
            if ($userType === 'Administrator') {
                $query->select('commendations.*', 'ref_city_muns.citymunDesc', 'ref_provinces.provDesc', 'ref_region_v2_s.regDesc');
            } else {
                $query->select('commendations.*', 'ref_city_muns.citymunDesc', 'ref_provinces.provDesc', 'ref_region_v2_s.regDesc')
                    ->whereIn('commendations.region', $regionData);
            }
            // order the results
            $query->orderBy($orderColumn, $orderDirection);
            // get total records after filtering
            $filteredRecords = $query->count();
            // pagination
            $commendation = $query->skip($start)
                ->take($length)
                ->get();

            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $commendation
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching commendation: " . $e->getMessage());
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
