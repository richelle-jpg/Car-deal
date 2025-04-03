<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $profile = \App\Models\Profile::where('user_id', $id)->firstOrFail();
        return view('agent.agent_profile', compact('profile'));
    }
    

    public function index()
    {
        $myProfile = User::find(Auth::user()->id)->Profile;

        if (Auth::user()->role == 'Administrator') {
            $carsCount = Car::where('user_id', auth()->id())->sum('number_of_cars');
            $cars = Car::where('number_of_cars', '>', 0)->latest()->paginate(5);
            
            $carsAll = Car::where('user_id', auth()->id())->get();
            $sumCarPrise = 0;
            foreach ($carsAll as $car) {
                $sumCarPrise += $car->price * $car->number_of_cars;
            }
            
            $OraderTotalSum  = DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('cars', 'orders.car_id', '=', 'cars.id')
                ->where('cars.user_id', auth()->id())
                ->select('orders.*', 'cars.type', 'cars.price', 'cars.color', 'users.name as userName', 'cars.name as carName')
                ->latest()->get();
            
            $OraderIncompleteSum =  DB::table('orders')
                ->where('status', '=', 'incomplete')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('cars', 'orders.car_id', '=', 'cars.id')
                ->where('cars.user_id', auth()->id())
                ->select('orders.*', 'cars.type', 'cars.price', 'cars.color', 'users.name as userName', 'cars.name as carName')
                ->latest()->get();
            
            $OraderCount = Order::where('status', '=', 'incomplete')
                ->whereHas('car', function ($query) {
                    $query->where('user_id', auth()->id());
                })
                ->count();

            $orderCounts = DB::table('orders')
                ->join('cars', 'orders.car_id', '=', 'cars.id')
                ->where('cars.user_id', auth()->id())
                ->select(
                    DB::raw('MONTH(orders.created_at) as month'),
                    DB::raw('COUNT(*) as total_orders')
                )
                ->groupBy('month')
                ->orderBy('month')
                ->get();
    
            $months = [];
            $totals = [];
    
            foreach ($orderCounts as $order) {
                $months[] = Carbon::create()->month($order->month)->format('F');
                $totals[] = $order->total_orders;
            }

            $carTypesData = Car::selectRaw('type, COUNT(*) as count')
                ->groupBy('type')
                ->get();
            
            $carTypes = $carTypesData->pluck('type')->toArray();
            $carTypeCounts = $carTypesData->pluck('count')->toArray();
            
            return view('home', compact('myProfile', 'OraderCount', 'OraderTotalSum', 'OraderIncompleteSum', 'carsCount', 'sumCarPrise', 'months', 'totals', 'carTypes', 'carTypeCounts'));
        }
        else if (Auth::user()->role == 'Agent') {
            $carsCount = Car::all()->sum('number_of_cars');
            $cars = Car::where('number_of_cars', '>', 0)->latest()->paginate(5);
    
            $carsAll = Car::all();
            $sumCarPrise = 0;
            foreach ($carsAll as $car) {
                $sumCarPrise = $sumCarPrise  + ($car->price * $car->number_of_cars);
            }
            $OraderTotalSum  = DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('cars', 'orders.car_id', '=', 'cars.id')
                ->select('orders.*', 'cars.type', 'cars.price', 'cars.color', 'users.name as userName', 'cars.name as carName')
                ->latest()->get();
            // return $OraderTotalSum;
            $OraderIncompleteSum =  DB::table('orders')
                ->where('status', '=', 'incomplete')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->join('cars', 'orders.car_id', '=', 'cars.id')
                ->select('orders.*', 'cars.type', 'cars.price', 'cars.color', 'users.name as userName', 'cars.name as carName')
                ->latest()->get();
            $OraderCount = Order::where('status', '=', 'incomplete')->count();


            $OraderTotalSum  = DB::table('orders')
    ->join('users', 'orders.user_id', '=', 'users.id')
    ->join('cars', 'orders.car_id', '=', 'cars.id')
    ->select('orders.*', 'cars.type', 'cars.price', 'cars.color', 'users.name as userName', 'cars.name as carName')
    ->latest()->get();

// Get all incomplete orders
$OraderIncompleteSum = DB::table('orders')
    ->where('status', '=', 'incomplete')
    ->join('users', 'orders.user_id', '=', 'users.id')
    ->join('cars', 'orders.car_id', '=', 'cars.id')
    ->select('orders.*', 'cars.type', 'cars.price', 'cars.color', 'users.name as userName', 'cars.name as carName')
    ->latest()->get();

// Calculate completed orders
$completedOrdersCount = $OraderTotalSum->count() - $OraderIncompleteSum->count();
$completedOrdersPrice = $OraderTotalSum->sum('price') - $OraderIncompleteSum->sum('price');

// **Prepare Data for Charts**
$months = [];
$totals = [];
$incompleteTotals = [];
$completedTotals = [];

// Get data for the past 6 months
for ($i = 5; $i >= 0; $i--) {
    $month = Carbon::now()->subMonths($i)->format('Y-m');
    $months[] = Carbon::now()->subMonths($i)->format('F'); // Example: January, February, etc.

    // Total orders per month
    $totals[] = DB::table('orders')->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonths($i)->month)
        ->count();

    // Incomplete orders per month
    $incompleteTotals[] = DB::table('orders')->whereYear('created_at', Carbon::now()->year)
        ->whereMonth('created_at', Carbon::now()->subMonths($i)->month)
        ->where('status', 'incomplete')
        ->count();

    // Completed orders per month
    $completedTotals[] = $totals[count($totals) - 1] - $incompleteTotals[count($incompleteTotals) - 1];
}
            return view('agent.index', compact('myProfile', 'OraderCount', 'OraderTotalSum', 'OraderIncompleteSum', 'carsCount', 'sumCarPrise', 'OraderTotalSum', 
    'OraderIncompleteSum', 
    'completedOrdersCount',
    'completedOrdersPrice',
    'months', 'totals', 'incompleteTotals', 'completedTotals'));
        }
        else {
 $carsCount = Car::all()->sum('number_of_cars');
    $cars = Car::where('number_of_cars', '>', 0)->latest()->paginate(5);

    $carsAll = Car::all();
    $sumCarPrise = 0;
    foreach ($carsAll as $car) {
        $sumCarPrise += ($car->price * $car->number_of_cars);
    }

    $OraderCount = Order::where('user_id', '=', Auth::user()->id)
                        ->where('status', '=', 'incomplete')
                        ->count();

    // Fetch agents (users with role "Agent")
    $agents = User::where('role', 'Administrator')->get();

    return view('homeCustomer', compact('myProfile', 'cars', 'OraderCount', 'agents'));
        }
    }
}
