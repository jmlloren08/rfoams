<?php

namespace App\Http\Controllers;

use App\Models\RFOsV2;
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
        return view('admin.rfos');
    }
    public function store(Request $request)
    {
        try {
            // validation
            $request->validate([
                'rfo'               => ['required', 'string', 'max:255'],
                'focal_person'      => ['required', 'string', 'max:255'],
                'position'          => ['required', 'string', 'max:255'],
                'contact_number'    => ['required', 'string', 'regex:/^09\d{9}$/'],
                'email_address'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . RFOsV2::class],
            ]);
            // save record
            $rfo = new RFOsV2;
            $rfo->rfo               = $request->rfo;
            $rfo->focal_person      = $request->focal_person;
            $rfo->position          = $request->position;
            $rfo->contact_number    = $request->contact_number;
            $rfo->email_address     = $request->email_address;
            $rfo->save();
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
                'email_address'     => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . RFOsV2::class],
            ]);

            $rfos = RFOsV2::findOrFail($id);

            $rfos->rfo              = $request->rfo;
            $rfos->focal_person     = $request->focal_person;
            $rfos->position         = $request->position;
            $rfos->contact_number   = $request->contact_number;
            $rfos->email_address    = $request->email_address;
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

            if (!empty($searchValue)) {
                $query->whereAny([
                    'rfo',
                    'focal_person',
                    'position',
                    'contact_number',
                    'email_address'
                ], 'like', "%$searchValue%")->get();
            }

            $totalRecords = $query->count();
            $query->orderBy($orderColumn, $orderDirection);
            $filteredRecords = $query->count();
            $rfos = $query->skip($start)
                ->take($length)
                ->get(['*']);

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
