<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Validate the incoming search request data
        $validated = $request->validate([
            'budget' => ['required', 'string'], // Ensure budget is selected
            'search_query' => ['nullable', 'string'], // Search query (e.g., product type)
        ]);

        // Capture the user's search activity
        SearchHistory::create([
            'user_id' => Auth::id(),
            'budget' => $validated['budget'],
        ]);

       $searchTerm = $request->query('search_term');
        $cars = Car::where('name', 'like', "%$searchTerm%")->get();

        return view('analytics.search.results', [
            'results' => $this->getSearchResults($validated['search_query'], $validated['budget'])
        ]);
    }

    private function getSearchResults($searchQuery, $budget)
    {
        // Example of fetching results (you can replace this with your own logic)
        return Car::where('price', '<=', $budget)
            ->where('name', 'like', "%$searchQuery%")
            ->get();
    }
}
