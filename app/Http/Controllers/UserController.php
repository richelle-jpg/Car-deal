<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|Factory|Response
    {
        if (Auth::user()->role == 'Administrator' || Auth::user()->role == 'Agent') {
            $OrderCount = Order::where('status', 'incomplete')->count();
        } else {
            $OrderCount = Order::where('user_id', Auth::id())->where('status', 'incomplete')->count();
        }

        $users = User::latest()->paginate(10);
        $myProfile = Auth::user()->Profile ?? null;

        return view('users', compact('myProfile', 'users', 'OrderCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create'); // Adjust the view if needed
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Your store logic here

        return response()->json([
            'status' => true,
            'message' => 'User Successfully Created!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found!',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'data' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json([
            'success' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $user = User::find($request->id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found!',
            ], 404);
        }

        $user->fill($request->all())->save();

        return response()->json([
            'status' => true,
            'message' => 'User Successfully Updated!',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found!',
            ], 404);
        }

        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'User Successfully Deleted!',
        ]);
    }
}
