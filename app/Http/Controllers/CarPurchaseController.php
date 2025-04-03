<?php

namespace App\Http\Controllers;

use App\Models\CarPurchase;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;


class CarPurchaseController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $myProfile = User::find($user->id); // Assuming user profile is in the `users` table
    $carPurchases = CarPurchase::where('user_id', $user->id)->get();
    $purchaseData = [];

    foreach ($carPurchases as $car) {
        $totalSpent = $car->price * $car->quantity;
        $formattedDate = $car->purchase_date 
            ? Carbon::parse($car->purchase_date)->format('Y-M') 
            : 'N/A';

        $purchaseData[] = [
            'date' => $formattedDate,
            'amount' => $totalSpent
        ];
    }

    // Pass $purchaseData to the view
    return view('carpurchase.index', compact('myProfile', 'carPurchases', 'purchaseData'));
}
}