<?php

namespace App\Http\Controllers;

use App\Models\eBOSS;
use App\Models\RefCityMun;
use App\Models\RefProvince;
use App\Models\RefRegion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ebossController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType) || $userType === 'Guest') {
            return view('admin.guest');
        }
        $ref_regions = RefRegion::select('regDesc', 'regCode')->get();
        $counteBOSS = eBOSS::select('date_of_inspection')
            ->selectRaw('count(*) as count')
            ->groupBy('date_of_inspection')
            ->get();

        return view('admin.eboss', [
            'ref_regions'   => $ref_regions,
            'counteBOSS'    => $counteBOSS
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
            $rfo = new eBOSS;
            $rfo->date_of_inspection        = $request->date_of_inspection;
            $rfo->city_municipality         = $request->city_municipality;
            $rfo->province                  = $request->province;
            $rfo->region                    = $request->region;
            $rfo->eboss_submission          = $request->eboss_submission;
            $rfo->type_of_boss              = $request->type_of_boss;
            $rfo->deadline_of_action_plan   = $request->deadline_of_action_plan;
            $rfo->submission_of_action_plan = $request->submission_of_action_plan;
            $rfo->remarks                   = $request->remarks;
            $rfo->bplo_head                 = $request->bplo_head;
            $rfo->contact_no                = $request->contact_no;
            $rfo->save();
            // return response
            return response()->json(['success' => 'Data added successfully.'], 200);
        } catch (ValidationException $e) {

            return response()->json(['errors' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            Log::error("Error adding eBOSS: " . $e->getMessage());
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

            $query          = eBOSS::query();
            // join
            $query->join('ref_city_muns', 'e_b_o_s_s.city_municipality', '=', 'ref_city_muns.citymunCode')
                ->join('ref_provinces', 'e_b_o_s_s.province', '=', 'ref_provinces.provCode')
                ->join('ref_regions', 'e_b_o_s_s.region', '=', 'ref_regions.regCode');
            // search functionality
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('e_b_o_s_s.date_of_inspection', 'like', "%$searchValue%")
                        ->orWhere('ref_city_muns.citymunDesc', 'like', "%$searchValue%")
                        ->orWhere('ref_provinces.provDesc', 'like', "%$searchValue%")
                        ->orWhere('ref_regions.regDesc', 'like', "%$searchValue%")
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
            $query->select('e_b_o_s_s.*', 'ref_city_muns.citymunDesc', 'ref_provinces.provDesc', 'ref_regions.regDesc');
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
    public function getCityMuncipalityByProvinceURL(Request $request)
    {
        $provinceCode = $request->province;
        $citymunicipaliy = RefCityMun::where('provCode', $provinceCode)->get();

        return response()->json($citymunicipaliy);
    }
}
