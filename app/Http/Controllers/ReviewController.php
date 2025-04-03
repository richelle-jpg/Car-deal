<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;


class ReviewController extends Controller
{
    public function store_rate(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);
    
        // Check if the user has already rated this car
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('car_id', $request->car_id)
                                ->first();
    
        if ($existingReview) {
            return response()->json(['message' => 'You have already rated this car!'], 403);
        }
    
        // Store the new rating
        Review::create([
            'user_id' => Auth::id(),
            'car_id' => $request->car_id,
            'ratings' => $request->rating
        ]);
    
        return response()->json(['message' => 'Rating submitted successfully!']);
    }
}
