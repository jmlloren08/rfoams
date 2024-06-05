<?php

namespace App\Http\Controllers;

use App\Models\RFOsV2;
use App\Models\User;
use App\Models\RefRegionV2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class rfoController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType) || $userType === 'Guest') {
            return view('admin.guest');
        }

        $users = User::select('id', 'name')->get();
        $regions = RefRegionV2::select('regDesc', 'regCode')->get();

        return view('admin.rfos', [
            'users' => $users,
            'regions' => $regions
        ]);
    }
    public function store(Request $request)
    {
        try {
            // validation
            $request->validate([
                'rfo'               => ['required', 'string', 'max:255'],
                'user_id'           => ['required', 'numeric'],
                'position'          => ['required', 'string', 'max:255'],
                'contact_number'    => ['required', 'string', 'regex:/^09\d{9}$/'],
                'regCode'           => ['required', 'array'],
                'regCode.*'         => ['required', 'numeric']
            ]);
            // save record
            $rfo            = $request->rfo;
            $user_id        = $request->user_id;
            $position       = $request->position;
            $contact_number = $request->contact_number;
            $regCodes       = $request->regCode;

            foreach ($regCodes as $regCode) {
                $rfos = new RFOsV2;
                $rfos->rfo               = $rfo;
                $rfos->user_id           = $user_id;
                $rfos->position          = $position;
                $rfos->contact_number    = $contact_number;
                $rfos->regCode           = $regCode;
                $rfos->save();
            }
            // return response
            return response()->json(['success' => 'Data added successfully.'], 200);
        } catch (ValidationException $e) {

            return response()->json(['errors' => $e->getMessage()], 422);
        } catch (\Exception $e) {

            Log::error("Error adding RFOs: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function edit($id)
    {
        try {
            $data = RFOsV2::where('id', $id)->first();

            if (!$data) {
                return response()->json(['errors' => 'Data not found.'], 404);
            }

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error("Error getting data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'rfo'               => ['required', 'string', 'max:255'],
                'focal_person'      => ['required', 'string', 'max:255'],
                'position'          => ['required', 'string', 'max:255'],
                'contact_number'    => ['required', 'string', 'regex:/^09\d{9}$/'],
                'regCode'           => ['required', 'array'],
                'regCode.*'         => ['required', 'numeric']
            ]);

            $rfos = RFOsV2::findOrFail($id);

            $rfos->rfo              = $request->rfo;
            $rfos->focal_person     = $request->focal_person;
            $rfos->position         = $request->position;
            $rfos->contact_number   = $request->contact_number;
            $rfos->regCode          = $request->regCode;
            $rfos->save();

            return response()->json(['success' =>  'Data updated successfully.']);
        } catch (\Exception $e) {

            Log::error("Error updating data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function delete($id)
    {
        try {
            RFOsV2::where('id', $id)->delete();

            return response()->json(['success' => 'Data deleted successfully.'], 200);
        } catch (\Exception $e) {

            Log::error("Error deleting data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function getDataFromRFOs(Request $request)
    {
        try {

            $draw           = $request->input('draw');
            $start          = $request->input('start');
            $length         = $request->input('length');
            $searchValue    = $request->input('search.value');
            $orderColumn    = $request->input("columns.{$request->input('order.0.column')}.data");
            $orderDirection = $request->input('order.0.dir');

            $query          = RFOsV2::query();
            // join
            $query->join('users', 'r_f_os_v2_s.user_id', '=', 'users.id')
                ->join('ref_region_v2_s', 'r_f_os_v2_s.regCode', '=', 'ref_region_v2_s.regCode');
            // search functionality
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('r_f_os_v2_s.rfo', 'like', "%$searchValue%")
                        ->orWhere('users.name', 'like', "%$searchValue%")
                        ->orWhere('r_f_os_v2_s.position', 'like', "%$searchValue%")
                        ->orWhere('r_f_os_v2_s.contact_number', 'like', "%$searchValue%")
                        ->orWhere('ref_region_v2_s.regDesc', 'like', "%$searchValue%");
                });
            }
            // get the total records before pagination and filtering
            $totalRecords = $query->count();
            // select only the necessary columns
            $query->select('r_f_os_v2_s.*', 'users.name', 'ref_region_v2_s.regDesc');
            // order the results
            $query->orderBy($orderColumn, $orderDirection);
            // get total records after filtering
            $filteredRecords = $query->count();
            // pagination
            $rfos = $query->skip($start)
                ->take($length)
                ->get();
            // prepare the response
            $response = [
                'draw'              => intval($draw),
                'recordsTotal'      => $totalRecords,
                'recordsFiltered'   => $filteredRecords,
                'data'              => $rfos
            ];

            return response()->json($response, 200);
        } catch (\Exception $e) {

            Log::error("Error fetching RFOs: " . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }
}
