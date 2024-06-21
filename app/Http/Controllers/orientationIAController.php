<?php

namespace App\Http\Controllers;

use App\Models\DepartmentAgency;
use App\Models\OrientationInspectedAgencies;
use App\Models\RefCityMun;
use App\Models\RefProvince;
use App\Models\RefRegionV2;
use App\Models\RFOsV2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class orientationIAController extends Controller
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
        return view('admin.orientation-inspected-agencies', [
            'regions' => $regions,
            'agencies_lgus' => $agencies_lgus
        ]);
    }
    public function store(Request $request)
    {
        try {

            // validate
            $request->validate([
                'agency_lgu'            => ['required', 'string', 'max:255'],
                'date_of_inspection'    => ['required', 'date'],
                'office'                => ['required', 'string', 'max:255'],
                'city_municipality'     => ['required', 'string', 'max:255'],
                'province'              => ['required', 'string', 'max:255'],
                'region'                => ['required', 'string', 'max:255']
            ]);

            // save record
            $orientationIA = new OrientationInspectedAgencies;
            $orientationIA->agency_lgu                                          = $request->agency_lgu;
            $orientationIA->date_of_inspection                                  = $request->date_of_inspection;
            $orientationIA->office                                              = $request->office;
            $orientationIA->city_municipality                                   = $request->city_municipality;
            $orientationIA->province                                            = $request->province;
            $orientationIA->region                                              = $request->region;
            $orientationIA->action_plan_and_inspection_report_date_sent_to_cmeo = $request->action_plan_and_inspection_report_date_sent_to_cmeo;
            $orientationIA->feedback_date_sent_to_oddgo                         = $request->feedback_date_sent_to_oddgo;
            $orientationIA->official_report_date_sent_to_oddgo                  = $request->official_report_date_sent_to_oddgo;
            $orientationIA->feedback_date_received_from_oddgo                   = $request->feedback_date_received_from_oddgo;
            $orientationIA->official_report_date_received_from_oddgo            = $request->official_report_date_received_from_oddgo;
            $orientationIA->feedback_date_sent_to_agencies_lgus                 = $request->feedback_date_sent_to_agencies_lgus;
            $orientationIA->official_report_date_sent_to_agencies_lgus          = $request->official_report_date_sent_to_agencies_lgus;
            $orientationIA->orientation                                         = $request->orientation;
            $orientationIA->setup                                               = $request->setup;
            $orientationIA->resource_speakers                                   = $request->resource_speakers;
            $orientationIA->bpm_workshop                                        = $request->bpm_workshop;
            $orientationIA->re_engineering                                      = $request->re_engineering;
            $orientationIA->cc_workshop                                         = $request->cc_workshop;
            $orientationIA->save();

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
            $data = OrientationInspectedAgencies::where('id', $id)->first();

            if (!$data) {
                return response()->json(['errors' => 'Data not found'], 404);
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
            OrientationInspectedAgencies::where('id', $id)->delete();

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
                'agency_lgu'            => ['required', 'string', 'max:255'],
                'date_of_inspection'    => ['required', 'date'],
                'office'                => ['required', 'string', 'max:255'],
                'city_municipality'     => ['required', 'string', 'max:255'],
                'province'              => ['required', 'string', 'max:255'],
                'region'                => ['required', 'string', 'max:255']
            ]);

            $orientationIA =  OrientationInspectedAgencies::findOrFail($id);

            $orientationIA->agency_lgu                                          = $request->agency_lgu;
            $orientationIA->date_of_inspection                                  = $request->date_of_inspection;
            $orientationIA->office                                              = $request->office;
            $orientationIA->city_municipality                                   = $request->city_municipality;
            $orientationIA->province                                            = $request->province;
            $orientationIA->region                                              = $request->region;
            $orientationIA->action_plan_and_inspection_report_date_sent_to_cmeo = $request->action_plan_and_inspection_report_date_sent_to_cmeo;
            $orientationIA->feedback_date_sent_to_oddgo                         = $request->feedback_date_sent_to_oddgo;
            $orientationIA->official_report_date_sent_to_oddgo                  = $request->official_report_date_sent_to_oddgo;
            $orientationIA->feedback_date_received_from_oddgo                   = $request->feedback_date_received_from_oddgo;
            $orientationIA->official_report_date_received_from_oddgo            = $request->official_report_date_received_from_oddgo;
            $orientationIA->feedback_date_sent_to_agencies_lgus                 = $request->feedback_date_sent_to_agencies_lgus;
            $orientationIA->official_report_date_sent_to_agencies_lgus          = $request->official_report_date_sent_to_agencies_lgus;
            $orientationIA->orientation                                         = $request->orientation;
            $orientationIA->setup                                               = $request->setup;
            $orientationIA->resource_speakers                                   = $request->resource_speakers;
            $orientationIA->bpm_workshop                                        = $request->bpm_workshop;
            $orientationIA->re_engineering                                      = $request->re_engineering;
            $orientationIA->cc_workshop                                         = $request->cc_workshop;
            $orientationIA->save();

            return response()->json(['success' => 'Data updated successfully.'], 200);
        } catch (\Exception $e) {

            Log::error("Error updating data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function getDataFromOrientationIA(Request $request)
    {
        try {

            $draw           = $request->input('draw');
            $start          = $request->input('start');
            $length         = $request->input('length');
            $searchValue    = $request->input('search.value');
            $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query = OrientationInspectedAgencies::query()
                ->join('ref_city_muns', 'orientation_inspected_agencies.city_municipality', '=', 'ref_city_muns.citymunCode')
                ->join('ref_provinces', 'orientation_inspected_agencies.province', '=', 'ref_provinces.provCode')
                ->join('ref_region_v2_s', 'orientation_inspected_agencies.region', '=', 'ref_region_v2_s.regCode');

            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('orientation_inspected_agencies.agency_lgu', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.date_of_inspection', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.office', 'like', "%$searchValue%")
                        ->orWhere('ref_city_muns.city_municipality', 'like', "%$searchValue%")
                        ->orWhere('ref_provinces.province', 'like', "%$searchValue%")
                        ->orWhere('ref_region_v2_s.region', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.action_plan_and_inspection_report_date_sent_to_cmeo', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.feedback_date_sent_to_oddgo', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.official_report_date_sent_to_oddgo', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.feedback_date_received_from_oddgo', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.official_report_date_received_from_oddgo', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.feedback_date_sent_to_agencies_lgus', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.official_report_date_sent_to_agencies_lgus', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.orientation', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.setup', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.resource_speakers', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.bpm_workshop', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.re_engineering', 'like', "%$searchValue%")
                        ->orWhere('orientation_inspected_agencies.cc_workshop', 'like', "%$searchValue%");
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
                $query->select('orientation_inspected_agencies.*', 'ref_city_muns.citymunDesc', 'ref_provinces.provDesc', 'ref_region_v2_s.regDesc');
            } else {
                $query->select('orientation_inspected_agencies.*', 'ref_city_muns.citymunDesc', 'ref_provinces.provDesc', 'ref_region_v2_s.regDesc')
                    ->whereIn('region', $regionData);
            }
            // order the results
            $query->orderBy($orderColumn, $orderDirection);
            // get total records after filtering
            $filteredRecords = $query->count();
            // pagination
            $orientationsIA = $query->skip($start)
                ->take($length)
                ->get();
            // prepare the response
            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $orientationsIA
            ];
            // send response json
            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching Orientation (Inspected Agencies): " . $e->getMessage());
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
