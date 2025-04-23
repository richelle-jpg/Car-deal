@extends('layouts.app')

@section('title')
    Register Page
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/dark-mode.css') }}" /> <!-- Include custom dark mode styles -->
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="/" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo col-10 m-auto">
                                    <img class="img-fluid" src="{{ asset('assets/img/logo.png') }}" alt="">
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome to Cars Deal! 👋</h4>
                        <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" autocomplete="name" autofocus
                                    placeholder="Enter your name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" autocomplete="email"
                                    placeholder="Enter your email" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="car_type" class="form-label">What type of car do you want?</label>
                                <select id="car_type" class="form-select @error('car_type') is-invalid @enderror"
                                    name="car_type">
                                     <option value="">Select Type</option>
                                            <option value="Sedan" {{ old('type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                                            <option value="SUV" {{ old('type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                                            <option value="Truck" {{ old('type') == 'Truck' ? 'selected' : '' }}>Truck</option>
                                            <option value="Hatchback" {{ old('type') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                                            <option value="Coupe" {{ old('type') == 'Coupe' ? 'selected' : '' }}>Coupe</option>
                                            <option value="Convertible" {{ old('type') == 'Convertible' ? 'selected' : '' }}>Convertible</option>
                                            <option value="Minivan" {{ old('type') == 'Minivan' ? 'selected' : '' }}>Minivan</option>
                                            <option value="Van" {{ old('type') == 'Van' ? 'selected' : '' }}>Van</option>
                                            <option value="MPV" {{ old('type') == 'MPV' ? 'selected' : '' }}>MPV</option>
                                            <option value="Pickup" {{ old('type') == 'Pickup' ? 'selected' : '' }}>Pickup</option>
                                        </select>
                                <div id="custom_car_type_div" class="mt-2" style="display: none;">
                                    <label for="custom_car_type" class="form-label">Please specify your preferred car type</label>
                                    <input id="custom_car_type" type="text" class="form-control @error('custom_car_type') is-invalid @enderror"
                                    name="custom_car_type" value="{{ old('custom_car_type') }}" placeholder="Enter custom car type">
                                </div>
                                @error('car_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="budget" class="form-label">Budget</label>
                                <select id="budget" class="form-select @error('budget') is-invalid @enderror" name="budget">
                                    <option value="Under 350,000" {{ old('budget') == 'Under 350,000' ? 'selected' : '' }}>Under 350,000</option>
                                    <option value="350,000 - 1,000,000" {{ old('budget') == '350,000 - 1,000,000' ? 'selected' : '' }}>350,000 - 1,000,000</option>
                                    <option value="1,000,000 - 2,500,000" {{ old('budget') == '1,000,000 - 2,500,000' ? 'selected' : '' }}>1,000,000 - 2,500,000</option>
                                    <option value="2,500,000 - 5,000,000" {{ old('budget') == '2,500,000 - 5,000,000' ? 'selected' : '' }}>2,500,000 - 5,000,000</option>
                                    <option value="Custom">Custom</option>
                                </select>
                                <div id="custom_budget_div" class="mt-2" style="display: none;">
                                    <label for="custom_budget" class="form-label">Please specify your budget</label>
                                    <input id="custom_budget" type="text" class="form-control @error('custom_budget') is-invalid @enderror"
                                    name="custom_budget" value="{{ old('custom_budget') }}" placeholder="Enter custom budget">
                                </div>
                                @error('budget')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col form-password-toggle">
                                    <label class="form-label" for="password">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" value="{{ old('password') }}" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="col form-password-toggle">
                                    <label class="form-label" for="password">Password Confirm</label>
                                    <div class="input-group input-group-merge">
                                        <input id="password-confirm" type="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            name="password_confirmation"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            aria-describedby="password" value="{{ old('password_confirmation') }}" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>
                                <div class="col-12 mt-1 text-center">
                                    @error('password')
                                        <span class="text-danger" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input  @error('terms') is-invalid @enderror " type="checkbox"
                                        id="terms" name="terms" />
                                    <label class="form-check-label" for="terms">
                                        I agree to
                                        <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                </div>
                            </div>
                            <button class="btn btn-gold d-grid w-100" style="border: 2px solid gold; background-color: gold; color: white;">Sign up</button>
                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}">
                                <span>Sign in instead</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>

    <!-- Dark Mode Toggle Icon -->
    <button id="dark-mode-toggle" class="btn-dark-mode-toggle">
        <i class="fas fa-moon" id="dark-mode-icon"></i> <!-- Initial moon icon -->
    </button>
@endsection

@section('scripts')
    <script>
        const toggleButton = document.getElementById('dark-mode-toggle');
        const body = document.body;
        const darkModeIcon = document.getElementById('dark-mode-icon');

        // Check if dark mode is already enabled
        if (localStorage.getItem('dark-mode') === 'enabled') {
            body.classList.add('dark-mode');
            darkModeIcon.classList.remove('fa-moon');
            darkModeIcon.classList.add('fa-sun'); // Switch to sun icon
        }

        // Toggle dark mode on button click
        toggleButton.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            // Switch icons based on mode
            if (body.classList.contains('dark-mode')) {
                darkModeIcon.classList.remove('fa-moon');
                darkModeIcon.classList.add('fa-sun');
                localStorage.setItem('dark-mode', 'enabled');
            } else {
                darkModeIcon.classList.remove('fa-sun');
                darkModeIcon.classList.add('fa-moon');
                localStorage.setItem('dark-mode', 'disabled');
            }
        });

        // Show custom input fields based on dropdown selection
        document.getElementById('car_type').addEventListener('change', function() {
            var customCarTypeDiv = document.getElementById('custom_car_type_div');
            if (this.value === 'Custom') {
                customCarTypeDiv.style.display = 'block';
            } else {
                customCarTypeDiv.style.display = 'none';
            }
        });

        document.getElementById('budget').addEventListener('change', function() {
            var customBudgetDiv = document.getElementById('custom_budget_div');
            if (this.value === 'Custom') {
                customBudgetDiv.style.display = 'block';
            } else {
                customBudgetDiv.style.display = 'none';
            }
        });
    </script>
@endsection
