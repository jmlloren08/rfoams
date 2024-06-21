<?php

namespace App\Http\Controllers;

use App\Models\OrientationInspectedAgencies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\eBOSS;
use App\Models\RFOsV2;
use App\Models\Commendation;

class DashboardController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType)) {
            return view('admin.guest');
        }
        $user_id = Auth::user()->id;
        // get the regions for the logged in user
        $regionData = RFOsV2::where('user_id', $user_id)->pluck('regCode');
        // get the count of eBOSS inspections for the user's regions
        if ($userType === 'Administrator') {
            // get count all eBOSS
            $counteBOSS = eBOSS::count('date_of_inspection');
            $countCommendation = Commendation::count('date_of_commendation');
            $countOrientationIA = OrientationInspectedAgencies::count('agency_lgu');
            // get count type_of_boss per region
            $data = eBOSS::select('ref_region_v2_s.regDesc as region', 'type_of_boss')
                ->selectRaw('count(*) as count')
                ->join('ref_region_v2_s', 'ref_region_v2_s.regCode', '=', 'e_b_o_s_s.region')
                ->groupBy('ref_region_v2_s.regDesc', 'type_of_boss')
                ->get();
            // get count date_of_commendation per month
            $commendations = Commendation::selectRaw('COUNT(*) as count, MONTH(date_of_commendation) as month')
                ->groupBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();

            $commendationsData = array_fill(1, 12, 0);
            foreach ($commendations as $month => $count) {
                $commendationsData[$month] = $count;
            }
        } else {
            // get count eBOSS per region
            $counteBOSS = eBOSS::whereIn('region', $regionData)->count('date_of_inspection');
            $countCommendation = Commendation::whereIn('region', $regionData)->count('date_of_commendation');
            $countOrientationIA = OrientationInspectedAgencies::whereIn('region', $regionData)->count('agency_lgu');
            // get count type_of_boss per region
            $data = eBOSS::select('ref_region_v2_s.regDesc as region', 'type_of_boss')
                ->whereIn('e_b_o_s_s.region', $regionData)
                ->join('ref_region_v2_s', 'ref_region_v2_s.regCode', '=', 'e_b_o_s_s.region')
                ->selectRaw('count(*) as count')
                ->groupBy('ref_region_v2_s.regDesc', 'type_of_boss')
                ->get();
            // get count date_of_commendation per month
            $commendations = Commendation::selectRaw('COUNT(*) as count, MONTH(date_of_commendation) as month')
                ->whereIn('region', $regionData)
                ->groupBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();
            $commendationsData = array_fill(1, 12, 0);
            foreach ($commendations as $month => $count) {
                $commendationsData[$month] = $count;
            }
        }
        // initialize
        $chartData = [];
        $fullyAutomated = 0;
        $partlyAutomated = 0;
        $physicalCollocatedBOSS = 0;
        $noCollocatedBOSS = 0;
        // iterate
        foreach ($data as $item) {
            $chartData[$item->region][$item->type_of_boss] = $item->count;
            // increment total number of type_of_boss
            if ($item->type_of_boss === 'Fully-Automated') {
                $fullyAutomated += $item->count;
            } elseif ($item->type_of_boss === 'Partly-Automated') {
                $partlyAutomated += $item->count;
            } elseif ($item->type_of_boss === 'Physical/Collocated BOSS') {
                $physicalCollocatedBOSS += $item->count;
            } elseif ($item->type_of_boss === '	No Collocated BOSS') {
                $noCollocatedBOSS += $item->count;
            }
        }
        // prepare data for chart
        $regions = array_keys($chartData);
        $types = ['Fully-Automated', 'Partly-Automated', 'Physical/Collocated BOSS', 'No Collocated BOSS'];
        $chartDataFormatted = [];

        foreach ($regions as $region) {
            $regionData = [];
            foreach ($types as $type) {
                $regionData[] = $chartData[$region][$type] ?? 0;
            }
            $chartDataFormatted[] = [
                'region'    => $region,
                'data'      => $regionData
            ];
        }
        return view('admin.dashboard', [
            'counteBOSS'                => $counteBOSS,
            'countCommendation'         => $countCommendation,
            'countOrientationIA'        => $countOrientationIA,
            'fullyAutomated'            => $fullyAutomated,
            'partlyAutomated'           => $partlyAutomated,
            'physicalCollocatedBOSS'    => $physicalCollocatedBOSS,
            'noCollocatedBOSS'          => $noCollocatedBOSS,
            'chartData'                 => $chartDataFormatted,
            'types'                     => $types,
            'commendationsData'         => $commendationsData
        ]);
    }
}
