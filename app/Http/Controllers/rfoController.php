<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use App\Models\User;
use App\Models\Region;
use App\Models\RegionalFieldOffice;
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
        $regions = Region::select('reg_desc', 'reg_code')->get();
        // log
        AuditTrail::create([
            'user_id' => Auth::user()->id,
            'event' => 'User viewed Profile Page.'
        ]);
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
                'reg_code'           => ['required', 'array'],
                'reg_code.*'         => ['required', 'numeric']
            ]);
            // save record
            $rfo            = $request->rfo;
            $user_id        = $request->user_id;
            $position       = $request->position;
            $contact_number = $request->contact_number;
            $reg_codes       = $request->reg_code;

            foreach ($reg_codes as $reg_code) {
                $rfos = new RegionalFieldOffice;
                $rfos->rfo               = $rfo;
                $rfos->user_id           = $user_id;
                $rfos->position          = $position;
                $rfos->contact_number    = $contact_number;
                $rfos->reg_code           = $reg_code;
                $rfos->save();
            }
            // log
            AuditTrail::create([
                'user_id' => Auth::user()->id,
                'event' => 'User added new data (RFO Page).'
            ]);
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
            $data = RegionalFieldOffice::where('id', $id)->first();

            if (!$data) {
                return response()->json(['errors' => 'Data not found.'], 404);
            }
            // log the login action
            AuditTrail::create([
                'user_id'   => Auth::user()->id,
                'event'     => 'User edit data for updating (RFO Page).'
            ]);
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
                'reg_code'           => ['required', 'array'],
                'reg_code.*'         => ['required', 'numeric']
            ]);

            $rfos = RegionalFieldOffice::findOrFail($id);

            $rfos->rfo              = $request->rfo;
            $rfos->focal_person     = $request->focal_person;
            $rfos->position         = $request->position;
            $rfos->contact_number   = $request->contact_number;
            $rfos->reg_code          = $request->reg_code;
            $rfos->save();
            // log the login action
            AuditTrail::create([
                'user_id'   => Auth::user()->id,
                'event'     => 'User modified data (RFO Page).'
            ]);
            return response()->json(['success' =>  'Data updated successfully.']);
        } catch (\Exception $e) {

            Log::error("Error updating data: " . $e->getMessage());
            return response()->json(['errors' => 'Internal server error'], 500);
        }
    }
    public function delete($id)
    {
        try {
            RegionalFieldOffice::where('id', $id)->delete();
            // log the login action
            AuditTrail::create([
                'user_id'   => Auth::user()->id,
                'event'     => 'User removed data (RFO Page)'
            ]);
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

            $query          = RegionalFieldOffice::query();
            // join
            $query->join('users', 'regional_field_offices.user_id', '=', 'users.id')
                ->join('regions', 'regional_field_offices.reg_code', '=', 'regions.reg_code');
            // search functionality
            if (!empty($searchValue)) {
                $query->where(function ($q) use ($searchValue) {
                    $q->where('regional_field_offices.rfo', 'like', "%$searchValue%")
                        ->orWhere('users.name', 'like', "%$searchValue%")
                        ->orWhere('regional_field_offices.position', 'like', "%$searchValue%")
                        ->orWhere('regional_field_offices.contact_number', 'like', "%$searchValue%")
                        ->orWhere('regions.reg_desc', 'like', "%$searchValue%");
                });
            }
            // get the total records before pagination and filtering
            $totalRecords = $query->count();
            // select only the necessary columns
            $query->select('regional_field_offices.*', 'users.name', 'regions.reg_desc');
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
