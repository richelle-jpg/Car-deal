<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Profile;
use App\Models\Car; // make sure this matches your model
use App\Models\SearchHistory; // make sure this matches your model

class SearchAnalyticsController extends Controller
{
    public function search(Request $request)
    {
        $user = auth()->user();
        $myProfile = Profile::where('user_id', $user->id)->first(); // Adjust based on your actual profile model
    
        $startDate = $request->input('start_date', Carbon::now()->subMonth());
        $endDate = $request->input('end_date', Carbon::now());
    
        $searchHistories = SearchHistory::select('budget')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('budget')
            ->selectRaw('budget, COUNT(*) as count')
            ->get();
    
        $budgetLabels = $searchHistories->pluck('budget');
        $searchCounts = $searchHistories->pluck('count');
    
        return view('analytics.search', compact('searchHistories', 'budgetLabels', 'searchCounts', 'startDate', 'endDate', 'myProfile'));
    }

    public function analyticsSearch(Request $request)
    {
        $startDate = $request->start_date ?? now()->subMonth();
        $endDate = $request->end_date ?? now();
    
        // Query search histories based on the date range
        $searchHistories = SearchHistory::whereBetween('date', [$startDate, $endDate])->get();
    
        // For Car Type Chart
        $carTypes = $searchHistories->pluck('car_type')->unique();  // Get unique car types
        $carTypeCounts = $searchHistories->groupBy('car_type')->map(function ($group) {
            return $group->count();  // Count how many times each car type was searched
        })->values();
    
        // Pass data to view
        return view('analytics.search', compact('searchHistories', 'carTypes', 'carTypeCounts', 'startDate', 'endDate'));
    }
    

}    