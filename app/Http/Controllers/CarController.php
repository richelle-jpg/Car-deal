<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $orderCount = Auth::user()->role == 'Administrator'
            ? Order::where('status', 'incomplete')->count()
            : Order::where('user_id', Auth::user()->id)->where('status', 'incomplete')->count();

        $cars = Car::where('number_of_cars', '>', 0)->latest()->paginate(10);
        $myProfile = Auth::user()->Profile;
        return view('cars.index', compact('myProfile', 'cars', 'orderCount'));
    }

    public function create()
    {
        $orderCount = Auth::user()->role == 'Administrator'
            ? Order::where('status', 'incomplete')->count()
            : Order::where('user_id', Auth::user()->id)->where('status', 'incomplete')->count();

        $myProfile = Auth::user()->Profile;
        return view('cars.create', compact('myProfile', 'orderCount'));
    }

    public function store(Request $request)
    {
        $request->merge(['price' => str_replace(',', '', $request->price)]);
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required|integer|min:1',
            'color' => 'required',
            'descriptions' => 'required|array',
            'descriptions.*' => 'required|string',
            'number_of_cars' => 'required',
            'picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        

        $fileName = null;
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move('users/cars', $fileName);
        }
        $car = new Car();
        $car->user_id = Auth::id();
        $car->name = $request->name;
        $car->type = $request->type;
        $car->price = $request->price;
        $car->color = $request->color;
        
        // Store multiple descriptions as a single string, each starting with a bullet point
        $car->description = '• ' . implode("\n• ", array_map('trim', $request->descriptions));
        
        $car->number_of_cars = $request->number_of_cars;
        $car->picture = $fileName;
        $car->save();
        

        return redirect()->back()->with('success', 'New Car Created successfully');
    }

    public function edit($id)
    {
        $orderCount = Auth::user()->role == 'Administrator'
            ? Order::where('status', 'incomplete')->count()
            : Order::where('user_id', Auth::user()->id)->where('status', 'incomplete')->count();

        $car = Car::findOrFail($id);
        $myProfile = Auth::user()->Profile;
        return view('cars.edit', compact('car', 'myProfile', 'orderCount'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'color' => 'required',
            'description' => 'required',
            'number_of_cars' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $car = Car::findOrFail($id);
        $car->fill($request->except('picture'));
        $car->description = '• ' . str_replace("\n", "\n• ", trim($request->description));

        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move('users/cars', $fileName);
            $car->picture = $fileName;
        }

        $car->save();
        return redirect()->route('cars-index')->with('success', 'Car details updated successfully');
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();
        return response()->json(['status' => true, 'success' => 'Car deleted successfully']);
    }
}
