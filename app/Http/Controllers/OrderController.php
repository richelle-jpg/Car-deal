<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Order;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function store_rate(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $user_id = Auth::id();
        $car_id = $request->car_id;
        $rating = $request->rating;

        // Check if the user has already rated the car
        $existingReview = Review::where('user_id', $user_id)->where('car_id', $car_id)->first();

        if ($existingReview) {
            return response()->json(['message' => 'You have already rated this car!'], 400);
        }

        // Store the review
        Review::create([
            'user_id' => $user_id,
            'car_id' => $car_id,
            'ratings' => $rating,
        ]);

        return response()->json(['message' => 'Thank you for your review!']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $myProfile = User::find(Auth::user()->id)->Profile;

        if (Auth::user()->role == 'Administrator') {
            $OrderCount = Order::where('status', '=', 'incomplete')->count();

            $orders = DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('cars', 'orders.car_id', '=', 'cars.id')
                ->select(
                    'orders.*', 
                    'cars.type', 'cars.price', 'cars.color', 
                    'users.name as userName', 
                    'cars.name as carName'
                )
                ->latest()
                ->paginate(10);

            $orderIncomplete = DB::table('orders')
                ->where('orders.status', '=', 'incomplete')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('cars', 'orders.car_id', '=', 'cars.id')
                ->select(
                    'orders.*', 
                    'cars.type', 'cars.price', 'cars.color', 
                    'users.name as userName', 
                    'cars.name as carName'
                )
                ->latest();

            return view('orders.adminIndex', compact('orders', 'myProfile', 'OrderCount', 'orderIncomplete'));
        } else {
            $OrderCount = Order::where('orders.user_id', '=', Auth::user()->id)
                ->where('status', '=', 'incomplete')
                ->count();

            $orders = DB::table('orders')
                ->where('orders.user_id', '=', Auth::user()->id)
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('cars', 'orders.car_id', '=', 'cars.id')
                ->select(
                    'orders.*', 
                    'cars.type', 'cars.price', 'cars.color', 
                    'users.name as userName', 
                    'cars.name as carName'
                )
                ->latest()
                ->paginate(10);

            $orderIncomplete = DB::table('orders')
                ->where('orders.user_id', '=', Auth::user()->id)
                ->where('orders.status', '=', 'incomplete')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('cars', 'orders.car_id', '=', 'cars.id')
                ->select(
                    'orders.*', 
                    'cars.type', 'cars.price', 'cars.color', 
                    'users.name as userName', 
                    'cars.name as carName'
                )
                ->latest();

            return view('orders.index', compact('orders', 'myProfile', 'OrderCount', 'orderIncomplete'));
        }
    }


    

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $user = Auth::user();

        if (!$user->name || !$user->email || !$user->Profile->lname || !$user->Profile->phone || !$user->Profile->address || !$user->Profile->national_id) {
            return redirect()->route('profile_index')->with('error', 'Your profile is incomplete');
        }

        $car = Car::with('reviews')->findOrFail($id);

        $OrderCount = Auth::user()->role == 'Agent' 
            ? Order::where('status', '=', 'incomplete')->count() 
            : Order::where('orders.user_id', '=', Auth::user()->id)->where('status', '=', 'incomplete')->count();

        $myProfile = $user->Profile;

        $averageRating = round($car->average_rating, 1); // Round to 1 decimal


        return view('cars.singleCar', compact('car', 'myProfile', 'OrderCount','averageRating'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($id)
    {
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->car_id = $id;
        $order->save();

        return response()->json([
            'status' => true,
            'success' => 'Order sent successfully'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'complete';
        $order->save();
    
        $OrderCount = Auth::user()->role == 'Administrator' 
            ? Order::where('status', '=', 'incomplete')->count() 
            : Order::where('user_id', '=', Auth::user()->id)->where('status', '=', 'incomplete')->count();
    
        return redirect()->route('order-index')->with('OrderCount', $OrderCount);
    }
}    