<?php

namespace App\Http\Controllers;

use App\Models\CitiesMunicipalities;
use App\Models\ElectronicBoss;
use App\Models\RegionalFieldOffice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\AuditTrail;
use App\Models\Province;
use App\Models\Region;

class ebossController extends Controller
{
    public function index()
    {
        try {
            $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType) || $userType === 'Guest') {

            return view('admin.guest');
        }
        // get the id of the logged in user
        $user_id = Auth::user()->id;
        // get the regions for the logged in user
        $regionData = RegionalFieldOffice::where('user_id', $user_id)->pluck('reg_code');
        if ($userType === 'Administrator') {

            $regions = Region::select('reg_desc', 'reg_code')->get();
            $counts = ElectronicBoss::selectRaw("
            SUM(CASE WHEN type_of_boss = 'Fully-Automated' AND EXTRACT(YEAR FROM date_of_inspection) = 2023 THEN 1 ELSE 0 END) as fullyautomated2023,
            SUM(CASE WHEN type_of_boss = 'Fully-Automated' AND EXTRACT(YEAR FROM date_of_inspection) = 2024 THEN 1 ELSE 0 END) as fullyautomated2024,
            SUM(CASE WHEN type_of_boss = 'Partly-Automated' AND EXTRACT(YEAR FROM date_of_inspection) = 2023 THEN 1 ELSE 0 END) as partlyautomated2023,
            SUM(CASE WHEN type_of_boss = 'Partly-Automated' AND EXTRACT(YEAR FROM date_of_inspection) = 2024 THEN 1 ELSE 0 END) as partlyautomated2024,
            SUM(CASE WHEN type_of_boss = 'Physical/Collocated BOSS' AND EXTRACT(YEAR FROM date_of_inspection) = 2023 THEN 1 ELSE 0 END) as physicalcollocated2023,
            SUM(CASE WHEN type_of_boss = 'Physical/Collocated BOSS' AND EXTRACT(YEAR FROM date_of_inspection) = 2024 THEN 1 ELSE 0 END) as physicalcollocated2024,
            SUM(CASE WHEN type_of_boss = 'No Collocated BOSS' AND EXTRACT(YEAR FROM date_of_inspection) = 2023 THEN 1 ELSE 0 END) as nocollocatedboss2023,
            SUM(CASE WHEN type_of_boss = 'No Collocated BOSS' AND EXTRACT(YEAR FROM date_of_inspection) = 2024 THEN 1 ELSE 0 END) as nocollocatedboss2024
            ")
                ->first();
        } else {

            $regions = Region::select('reg_desc', 'reg_code')
                ->whereIn('reg_code', $regionData)
                ->get();
            $counts = ElectronicBoss::selectRaw("
            SUM(CASE WHEN type_of_boss = 'Fully-Automated' AND EXTRACT(YEAR FROM date_of_inspection) = 2023 THEN 1 ELSE 0 END) as fullyautomated2023,
            SUM(CASE WHEN type_of_boss = 'Fully-Automated' AND EXTRACT(YEAR FROM date_of_inspection) = 2024 THEN 1 ELSE 0 END) as fullyautomated2024,
            SUM(CASE WHEN type_of_boss = 'Partly-Automated' AND EXTRACT(YEAR FROM date_of_inspection) = 2023 THEN 1 ELSE 0 END) as partlyautomated2023,
            SUM(CASE WHEN type_of_boss = 'Partly-Automated' AND EXTRACT(YEAR FROM date_of_inspection) = 2024 THEN 1 ELSE 0 END) as partlyautomated2024,
            SUM(CASE WHEN type_of_boss = 'Physical/Collocated BOSS' AND EXTRACT(YEAR FROM date_of_inspection) = 2023 THEN 1 ELSE 0 END) as physicalcollocated2023,
            SUM(CASE WHEN type_of_boss = 'Physical/Collocated BOSS' AND EXTRACT(YEAR FROM date_of_inspection) = 2024 THEN 1 ELSE 0 END) as physicalcollocated2024,
            SUM(CASE WHEN type_of_boss = 'No Collocated BOSS' AND EXTRACT(YEAR FROM date_of_inspection) = 2023 THEN 1 ELSE 0 END) as nocollocatedboss2023,
            SUM(CASE WHEN type_of_boss = 'No Collocated BOSS' AND EXTRACT(YEAR FROM date_of_inspection) = 2024 THEN 1 ELSE 0 END) as nocollocatedboss2024
            ")
                ->whereIn('region', $regionData)
                ->first();
        }
        // log
        AuditTrail::create([
            'user_id' => Auth::user()->id,
            'event' => 'User viewed eBOSS Page.'
        ]);

        // dd($counts);
        Log::info($counts->toArray());
        Log::info($regions->toArray());

        return view('admin.eboss', [
            'regions'                   => $regions,
            'fullyautomated2023'        => $counts->fullyautomated2023,
            'fullyautomated2024'        => $counts->fullyautomated2024,
            'partlyautomated2023'       => $counts->partlyautomated2023,
            'partlyautomated2024'       => $counts->partlyautomated2024,
            'physicalcollocated2023'    => $counts->physicalcollocated2023,
            'physicalcollocated2024'    => $counts->physicalcollocated2024,
            'nocollocatedboss2023'      => $counts->nocollocatedboss2023,
            'nocollocatedboss2024'      => $counts->nocollocatedboss2024
        ]);
        } catch (\Exception $e) {
            
            Log::error("Error loading eBOSS: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
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
            $inspection = new ElectronicBoss;
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
            // log
            AuditTrail::create([
                'user_id' => Auth::user()->id,
                'event' => 'User added new data (eBOSS Page).'
            ]);
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
            $data = ElectronicBoss::where('id', $id)->first();

            if (!$data) {
                return response()->json(['errors' => 'Data not found.'], 404);
            }
            // log
            AuditTrail::create([
                'user_id' => Auth::user()->id,
                'event' => 'User edit data for updating (eBOSS Page).'
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
            ElectronicBoss::where('id', $id)->delete();
            // log
            AuditTrail::create([
                'user_id' => Auth::user()->id,
                'event' => 'User removed data (eBOSS Page).'
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

            $inspection = ElectronicBoss::findOrFail($id);

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
            // log
            AuditTrail::create([
                'user_id' => Auth::user()->id,
                'event' => 'User modified data (eBOSS Page).'
            ]);
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

            $query          = ElectronicBoss::query()
                ->join('cities_municipalities', 'electronic_bosses.city_municipality', '=', 'cities_municipalities.citymun_code')
                ->join('provinces', 'electronic_bosses.province', '=', 'provinces.prov_code')
                ->join('regions', 'electronic_bosses.region', '=', 'regions.reg_code');

            // search functionality
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('electronic_bosses.date_of_inspection', 'like', "%$searchValue%")
                        ->orWhere('cities_municipalities.citymun_desc', 'like', "%$searchValue%")
                        ->orWhere('provinces.prov_desc', 'like', "%$searchValue%")
                        ->orWhere('regions.reg_desc', 'like', "%$searchValue%")
                        ->orWhere('electronic_bosses.eboss_submission', 'like', "%$searchValue%")
                        ->orWhere('electronic_bosses.type_of_boss', 'like', "%$searchValue%")
                        ->orWhere('electronic_bosses.deadline_of_action_plan', 'like', "%$searchValue%")
                        ->orWhere('electronic_bosses.submission_of_action_plan', 'like', "%$searchValue%")
                        ->orWhere('electronic_bosses.remarks', 'like', "%$searchValue%")
                        ->orWhere('electronic_bosses.bplo_head', 'like', "%$searchValue%")
                        ->orWhere('electronic_bosses.contact_no', 'like', "%$searchValue%");
                });
            }
            // select only the necessary columns
            $user_id = Auth::user()->id;
            $userType = Auth::user()->roles;
            // get the regions for the logged in user
            $regionData = RegionalFieldOffice::where('user_id', $user_id)->pluck('reg_code');

            if ($userType === 'Administrator') {
                $query->select('electronic_bosses.*', 'cities_municipalities.citymun_desc', 'provinces.prov_desc', 'regions.reg_desc');
            } else {
                $query->select('electronic_bosses.*', 'cities_municipalities.citymun_desc', 'provinces.prov_desc', 'regions.reg_desc')
                    ->whereIn('electronic_bosses.region', $regionData);
            }

            // order the results
            $query->orderBy($orderColumn, $orderDirection);

            // get the total records before pagination and filtering
            $totalRecords = $query->count();

            if ($length != -1) {
                // get total records after filtering
                $filteredRecords = $query->count();

                // pagination
                $eboss = $query->skip($start)
                    ->take($length)
                    ->get();
            } else {
                $filteredRecords = $totalRecords;
                $eboss = $query->get();
            }

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
        $provinces = Province::where('reg_code', $regionCode)->get();
        return response()->json($provinces);
    }
    public function getCityMunicipalityByProvince(Request $request)
    {
        $provinceCode = $request->province;
        $citymunicipality = CitiesMunicipalities::where('prov_code', $provinceCode)->get();

        return response()->json($citymunicipality);
    }
    public function getDataForPrint(Request $request)
    {
        try {

            $draw = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');
            $orderColumn = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            if (!in_array($orderDirection, ['asc', 'desc'])) {
                $orderDirection = 'desc';
            }

            $query = ElectronicBoss::query()
                ->join('cities_municipalities', 'electronic_bosses.city_municipality', '=', 'cities_municipalities.citymun_code')
                ->join('provinces', 'electronic_bosses.province', '=', 'provinces.prov_code')
                ->join('regions', 'electronic_bosses.region', '=', 'regions.reg_code');

            $query->orderBy('type_of_boss.' . $orderColumn, $orderDirection);

            $totalRecords = $query->count();

            if ($length != -1) {
                $filteredRecords = $query->count();
                $eboss = $query->skip($start)
                    ->take($length)
                    ->get();
            } else {
                $filteredRecords = $totalRecords;
                $eboss = $query->get();
            }

            $response = [
                'draw' => intval($draw),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $filteredRecords,
                'data' => $eboss
            ];
            // send response json
            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching data for printing: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
