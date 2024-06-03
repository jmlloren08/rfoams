<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\eBOSS;

class DashboardController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType) || $userType === 'Guest') {
            return view('admin.guest');
        }

        $counteBOSS = eBOSS::count('date_of_inspection');
        // get count type_of_boss per region
        $data = eBOSS::select('ref_region_v2_s.regDesc as region', 'type_of_boss')
            ->selectRaw('count(*) as count')
            ->join('ref_region_v2_s', 'ref_region_v2_s.regCode', '=', 'e_b_o_s_s.region')
            ->groupBy('ref_region_v2_s.regDesc', 'type_of_boss')
            ->get();
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
            'fullyAutomated'            => $fullyAutomated,
            'partlyAutomated'           => $partlyAutomated,
            'physicalCollocatedBOSS'    => $physicalCollocatedBOSS,
            'noCollocatedBOSS'          => $noCollocatedBOSS,
            'chartData'                 => $chartDataFormatted,
            'types'                     => $types
        ]);
    }
}
