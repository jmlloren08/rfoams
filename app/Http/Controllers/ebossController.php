<?php

namespace App\Http\Controllers;

use App\Models\eBOSS;
use App\Models\RefCityMun;
use App\Models\RefProvince;
use App\Models\RefRegionV2;
use App\Models\RFOsV2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ebossController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType)) {
            return view('admin.guest');
        }
        // get the id of the logged in user
        $user_id = Auth::user()->id;
        // get the regions for the logged in user
        $regionData = RFOsV2::where('user_id', $user_id)->pluck('regCode');
        if ($userType === 'Administrator') {

            $regions = RefRegionV2::select('regDesc', 'regCode')->get();
            $counts = eBOSS::selectRaw("
            SUM(CASE WHEN type_of_boss = 'Fully-Automated' AND YEAR(date_of_inspection) = 2023 THEN 1 ELSE 0 END) as fullyAutomated2023,
            SUM(CASE WHEN type_of_boss = 'Fully-Automated' AND YEAR(date_of_inspection) = 2024 THEN 1 ELSE 0 END) as fullyAutomated2024,
            SUM(CASE WHEN type_of_boss = 'Partly-Automated' AND YEAR(date_of_inspection) = 2023 THEN 1 ELSE 0 END) as partlyAutomated2023,
            SUM(CASE WHEN type_of_boss = 'Partly-Automated' AND YEAR(date_of_inspection) = 2024 THEN 1 ELSE 0 END) as partlyAutomated2024,
            SUM(CASE WHEN type_of_boss = 'Physical/Collocated BOSS' AND YEAR(date_of_inspection) = 2023 THEN 1 ELSE 0 END) as physicalCollocated2023,
            SUM(CASE WHEN type_of_boss = 'Physical/Collocated BOSS' AND YEAR(date_of_inspection) = 2024 THEN 1 ELSE 0 END) as physicalCollocated2024,
            SUM(CASE WHEN type_of_boss = 'No Collocated BOSS' AND YEAR(date_of_inspection) = 2023 THEN 1 ELSE 0 END) as noCollocatedBOSS2023,
            SUM(CASE WHEN type_of_boss = 'No Collocated BOSS' AND YEAR(date_of_inspection) = 2024 THEN 1 ELSE 0 END) as noCollocatedBOSS2024
            ")
                ->first();
        } else {

            $regions = RefRegionV2::select('regDesc', 'regCode')
                ->whereIn('regCode', $regionData)
                ->get();
            $counts = eBOSS::selectRaw("
            SUM(CASE WHEN type_of_boss = 'Fully-Automated' AND YEAR(date_of_inspection) = 2023 THEN 1 ELSE 0 END) as fullyAutomated2023,
            SUM(CASE WHEN type_of_boss = 'Fully-Automated' AND YEAR(date_of_inspection) = 2024 THEN 1 ELSE 0 END) as fullyAutomated2024,
            SUM(CASE WHEN type_of_boss = 'Partly-Automated' AND YEAR(date_of_inspection) = 2023 THEN 1 ELSE 0 END) as partlyAutomated2023,
            SUM(CASE WHEN type_of_boss = 'Partly-Automated' AND YEAR(date_of_inspection) = 2024 THEN 1 ELSE 0 END) as partlyAutomated2024,
            SUM(CASE WHEN type_of_boss = 'Physical/Collocated BOSS' AND YEAR(date_of_inspection) = 2023 THEN 1 ELSE 0 END) as physicalCollocated2023,
            SUM(CASE WHEN type_of_boss = 'Physical/Collocated BOSS' AND YEAR(date_of_inspection) = 2024 THEN 1 ELSE 0 END) as physicalCollocated2024,
            SUM(CASE WHEN type_of_boss = 'No Collocated BOSS' AND YEAR(date_of_inspection) = 2023 THEN 1 ELSE 0 END) as noCollocatedBOSS2023,
            SUM(CASE WHEN type_of_boss = 'No Collocated BOSS' AND YEAR(date_of_inspection) = 2024 THEN 1 ELSE 0 END) as noCollocatedBOSS2024
            ")
                ->whereIn('region', $regionData)
                ->first();
        }

        return view('admin.eboss', [
            'regions'                   => $regions,
            'fullyAutomated2023'        => $counts->fullyAutomated2023,
            'fullyAutomated2024'        => $counts->fullyAutomated2024,
            'partlyAutomated2023'       => $counts->partlyAutomated2023,
            'partlyAutomated2024'       => $counts->partlyAutomated2024,
            'physicalCollocated2023'    => $counts->physicalCollocated2023,
            'physicalCollocated2024'    => $counts->physicalCollocated2024,
            'noCollocatedBOSS2023'      => $counts->noCollocatedBOSS2023,
            'noCollocatedBOSS2024'      => $counts->noCollocatedBOSS2024
        ]);
    }
    public function store(Request $request)
    {
        try {
            // validation
            $request->validate([
                'date_of_inspection'        => ['required', 'date'],
                'city_municipality'         => ['required', 'string', 'max:255'],
                'province'                  => ['required', 'string', 'max:255'],
                'region'                    => ['required', 'string', 'max:255'],
                'type_of_boss'              => ['required', 'string', 'max:255'],
                'remarks'                   => ['nullable', 'string', 'max:255'],
                'bplo_head'                 => ['nullable', 'string', 'max:255'],
                'contact_no'                => ['nullable', 'string', 'max:255']
            ]);
            // save record
            $inspection = new eBOSS;
            $inspection->date_of_inspection        = $request->date_of_inspection;
            $inspection->city_municipality         = $request->city_municipality;
            $inspection->province                  = $request->province;
            $inspection->region                    = $request->region;
            $inspection->eboss_submission          = $request->eboss_submission;
            $inspection->type_of_boss              = $request->type_of_boss;
            $inspection->deadline_of_action_plan   = $request->deadline_of_action_plan;
            $inspection->submission_of_action_plan = $request->submission_of_action_plan;
            $inspection->remarks                   = $request->remarks;
            $inspection->bplo_head                 = $request->bplo_head;
            $inspection->contact_no                = $request->contact_no;
            $inspection->save();
            // return response
            return response()->json(['success' => 'Data added successfully.'], 200);
        } catch (ValidationException $e) {

            return response()->json(['errors' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            Log::error("Error adding eBOSS: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function edit($id)
    {
        try {
            $data = eBOSS::where('id', $id)->first();

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
            eBOSS::where('id', $id)->delete();

            return response()->json(['success' => 'Data deleted successfully.'], 200);
        } catch (\Exception $e) {

            Log::error("Error deleting data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'date_of_inspection'        => ['required', 'date'],
                'city_municipality'         => ['required', 'string', 'max:255'],
                'province'                  => ['required', 'string', 'max:255'],
                'region'                    => ['required', 'string', 'max:255'],
                'type_of_boss'              => ['required', 'string', 'max:255'],
                'remarks'                   => ['nullable', 'string', 'max:255'],
                'bplo_head'                 => ['nullable', 'string', 'max:255'],
                'contact_no'                => ['nullable', 'string', 'max:255']
            ]);

            $inspection = eBOSS::findOrFail($id);

            $inspection->date_of_inspection        = $request->date_of_inspection;
            $inspection->city_municipality         = $request->city_municipality;
            $inspection->province                  = $request->province;
            $inspection->region                    = $request->region;
            $inspection->eboss_submission          = $request->has('eboss_submission') && $request->eboss_submission != null ? $request->eboss_submission : 'No submission';
            $inspection->type_of_boss              = $request->type_of_boss;
            $inspection->deadline_of_action_plan   = $request->has('deadline_of_action_plan') && $request->deadline_of_action_plan != null ? $request->deadline_of_action_plan : 'Not applicable';
            $inspection->submission_of_action_plan = $request->has('submission_of_action_plan') && $request->submission_of_action_plan != null ? $request->submission_of_action_plan : 'Not applicable';
            $inspection->remarks                   = $request->remarks;
            $inspection->bplo_head                 = $request->bplo_head;
            $inspection->contact_no                = $request->contact_no;
            $inspection->save();

            return response()->json(['success' =>  'Data updated successfully.']);
        } catch (\Exception $e) {

            Log::error("Error updating data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function getDataFromeBOSS(Request $request)
    {
        try {

            $draw           = $request->input('draw');
            $start          = $request->input('start');
            $length         = $request->input('length');
            $searchValue    = $request->input('search.value');
            $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query          = eBOSS::query()
                ->join('ref_city_muns', 'e_b_o_s_s.city_municipality', '=', 'ref_city_muns.citymunCode')
                ->join('ref_provinces', 'e_b_o_s_s.province', '=', 'ref_provinces.provCode')
                ->join('ref_region_v2_s', 'e_b_o_s_s.region', '=', 'ref_region_v2_s.regCode');

            // search functionality
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('e_b_o_s_s.date_of_inspection', 'like', "%$searchValue%")
                        ->orWhere('ref_city_muns.citymunDesc', 'like', "%$searchValue%")
                        ->orWhere('ref_provinces.provDesc', 'like', "%$searchValue%")
                        ->orWhere('ref_region_v2_s.regDesc', 'like', "%$searchValue%")
                        ->orWhere('e_b_o_s_s.eboss_submission', 'like', "%$searchValue%")
                        ->orWhere('e_b_o_s_s.type_of_boss', 'like', "%$searchValue%")
                        ->orWhere('e_b_o_s_s.deadline_of_action_plan', 'like', "%$searchValue%")
                        ->orWhere('e_b_o_s_s.submission_of_action_plan', 'like', "%$searchValue%")
                        ->orWhere('e_b_o_s_s.remarks', 'like', "%$searchValue%")
                        ->orWhere('e_b_o_s_s.bplo_head', 'like', "%$searchValue%")
                        ->orWhere('e_b_o_s_s.contact_no', 'like', "%$searchValue%");
                });
            }
            // get the total records before pagination and filtering
            $totalRecords = $query->count();
            // select only the necessary columns
            $user_id = Auth::user()->id;
            $userType = Auth::user()->roles;
            // get the regions for the logged in user
            $regionData = RFOsV2::where('user_id', $user_id)->pluck('regCode');
            if ($userType === 'Administrator') {
                $query->select('e_b_o_s_s.*', 'ref_city_muns.citymunDesc', 'ref_provinces.provDesc', 'ref_region_v2_s.regDesc');
            } else {
                $query->select('e_b_o_s_s.*', 'ref_city_muns.citymunDesc', 'ref_provinces.provDesc', 'ref_region_v2_s.regDesc')
                    ->whereIn('e_b_o_s_s.region', $regionData);
            }
            // order the results
            $query->orderBy($orderColumn, $orderDirection);
            // get total records after filtering
            $filteredRecords = $query->count();
            // pagination
            $eboss = $query->skip($start)
                ->take($length)
                ->get();
            // prepare the response
            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $eboss
            ];
            // send response json
            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching eBOSS: " . $e->getMessage());
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
