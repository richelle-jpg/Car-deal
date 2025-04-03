<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'Administrator') {
            $OrderCount = Order::where('status', '=', 'incomplete')->count();
        } else if (Auth::user()->role == 'Agent') {
            $OrderCount = Order::where('status', '=', 'incomplete')->count();
        } else {
            $OrderCount = Order::where('user_id', '=', Auth::user()->id)
                ->where('status', '=', 'incomplete')
                ->count();
        }

        $users = User::latest()->paginate(10);
        $myProfile = User::find(Auth::user()->id)->profile;

        return view('users', compact('myProfile', 'users', 'OrderCount'));
    }
}
