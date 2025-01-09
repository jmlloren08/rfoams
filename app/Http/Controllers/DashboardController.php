<?php

namespace App\Http\Controllers;

use App\Models\ElectronicBoss;
use App\Models\OrientationInspectedAgencies;
use App\Models\OrientationOverall;
use App\Models\RegionalFieldOffice;
use Illuminate\Support\Facades\Auth;
use App\Models\Commendation;
use App\Models\AuditTrail;

class DashboardController extends Controller
{
    public function index()
    {
        $userType = Auth::user()->roles;
        if (is_null($userType) || empty($userType) || $userType === 'Guest') {
            return view('admin.guest');
        }
        $user_id = Auth::user()->id;
        // get the regions for the logged in user
        $regionData = RegionalFieldOffice::where('user_id', $user_id)->pluck('reg_code');
        // get the count of eBOSS inspections for the user's regions
        if ($userType === 'Administrator') {
            // get count all eBOSS
            $counteBOSS = ElectronicBoss::count('date_of_inspection');
            // get count all commendation
            $countCommendation = Commendation::count('date_of_commendation');
            // get count all orientation IA and overall
            $countOrientationIA = OrientationInspectedAgencies::count('agency_lgu');
            $countOrientationOverall = OrientationOverall::count('orientation_date');
            // get count type_of_boss per region
            $data = ElectronicBoss::select('regions.reg_desc as region', 'type_of_boss')
                ->selectRaw('count(*) as count')
                ->join('regions', 'regions.reg_code', '=', 'electronic_bosses.region')
                ->groupBy('regions.reg_desc', 'type_of_boss')
                ->get();
            // get count date_of_commendation per month
            $commendations = Commendation::selectRaw('COUNT(*) as count, EXTRACT(MONTH FROM date_of_commendation) as month')
                ->groupBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();
            $commendationsData = array_fill(1, 12, 0);
            foreach ($commendations as $month => $count) {
                $commendationsData[$month] = $count;
            }
            // get count yes/no by program
            // list of programs
            $programs = [
                'is_ra_11032',
                'is_cart',
                'is_programs_and_services',
                'is_cc_orientation',
                'is_cc_workshop',
                'is_bpm_workshop',
                'is_ria',
                'is_eboss',
                'is_csm',
                'is_reeng'
            ];
            // initialize arrays to hold the counts
            $programsData = [];
            foreach ($programs as $program) {
                $countYes = OrientationOverall::where($program, 'Yes')->count();
                $countNo = OrientationOverall::where($program, 'No')->count();
                $programsData[] = [
                    'programs'  => $programs,
                    'countYes'  => $countYes,
                    'countNo'   => $countNo
                ];
            }
        } else {
            // get count eBOSS per region
            $counteBOSS = ElectronicBoss::whereIn('region', $regionData)->count('date_of_inspection');
            // get count commendation per region
            $countCommendation = Commendation::whereIn('region', $regionData)->count('date_of_commendation');
            // get count orientationIA per region
            $countOrientationIA = OrientationInspectedAgencies::whereIn('region', $regionData)->count('agency_lgu');
            // get count orientationOverall per region
            $countOrientationOverall = OrientationOverall::whereIn('region', $regionData)->count('orientation_date');
            // get count type_of_boss per region
            $data = ElectronicBoss::select('regions.reg_desc as region', 'type_of_boss')
                ->whereIn('electronic_bosses.region', $regionData)
                ->join('regions', 'regions.reg_code', '=', 'electronic_bosses.region')
                ->selectRaw('count(*) as count')
                ->groupBy('regions.reg_desc', 'type_of_boss')
                ->get();
            // get count date_of_commendation per month
            $commendations = Commendation::selectRaw('COUNT(*) as count, EXTRACT(MONTH FROM date_of_commendation) as month')
                ->whereIn('region', $regionData)
                ->groupBy('month')
                ->get()
                ->pluck('count', 'month')
                ->toArray();
            $commendationsData = array_fill(1, 12, 0);
            foreach ($commendations as $month => $count) {
                $commendationsData[$month] = $count;
            }
            // get count yes/no by program
            // list of programs
            $programs = [
                'is_ra_11032',
                'is_cart',
                'is_programs_and_services',
                'is_cc_orientation',
                'is_cc_workshop',
                'is_bpm_workshop',
                'is_ria',
                'is_eboss',
                'is_csm',
                'is_reeng'
            ];
            // initialize arrays to hold the counts
            $programsData = [];
            foreach ($programs as $program) {
                $countYes = OrientationOverall::whereIn('region', $regionData)
                    ->where($program, 'Yes')
                    ->count();
                $countNo = OrientationOverall::whereIn('region', $regionData)
                    ->where($program, 'No')
                    ->count();
                $programsData[] = [
                    'programs'  => $programs,
                    'countYes'  => $countYes,
                    'countNo'   => $countNo
                ];
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
        // log
        AuditTrail::create([
            'user_id' => Auth::user()->id,
            'event' => 'User viewed Dashboard Page.'
        ]);
        return view('admin.dashboard', [
            'counteBOSS'                => $counteBOSS,
            'countCommendation'         => $countCommendation,
            'countOrientationIA'        => $countOrientationIA,
            'countOrientationOverall'   => $countOrientationOverall,
            'fullyAutomated'            => $fullyAutomated,
            'partlyAutomated'           => $partlyAutomated,
            'physicalCollocatedBOSS'    => $physicalCollocatedBOSS,
            'noCollocatedBOSS'          => $noCollocatedBOSS,
            'chartData'                 => $chartDataFormatted,
            'types'                     => $types,
            'commendationsData'         => $commendationsData,
            'programsData'              => $programsData
        ]);
    }
}
