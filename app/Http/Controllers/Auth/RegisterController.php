<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['accepted'],
            'car_type' => ['required', 'string'],
            'budget' => [
                'required',
                'string',
                // New validation rule for budget range
                function ($attribute, $value, $fail) {
                    // Allow custom budget or validate the new range
                    if ($value !== 'Custom' && !in_array($value, [
                        'Under 350,000', '350,000 - 500,000', '500,000 - 1,000,000', '1,000,000 - 3,000,000', '3,000,000 - 5,000,000', 'Over 5,000,000'
                    ])) {
                        return $fail('The budget is not valid. Please choose a valid budget range.');
                    }
                },
            ],
        ]);
    }

    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Create Profile model with car type and budget
        Profile::create([
            'user_id' => $user->id,
            'car_type' => $data['car_type'],
            'custom_car_type' => $data['car_type'] === 'Custom' ? $data['custom_car_type'] : null,
            'budget' => $data['budget'],
            'custom_budget' => $data['budget'] === 'Custom' ? $data['custom_budget'] : null,
        ]);

        return $user;
    }
}
