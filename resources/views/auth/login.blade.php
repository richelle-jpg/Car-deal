@extends('layouts.app')

@section('title')
    Login Page
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/dark-mode.css') }}" /> <!-- Include custom dark mode styles -->
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
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
                        <form id="formAuthentication" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                       name="email" placeholder="Enter your email .." autofocus value="{{ old('email') }}" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                    <a href="{{ route('password.request') }}">
                                        <small>Forgot Password?</small>
                                    </a>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="{{ route('register') }}">
                                <span>Create an account</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- Dark Mode Toggle Button -->
    <button id="dark-mode-toggle">
        <i class="bx bx-moon"></i> <!-- Dark Mode Icon -->
    </button>
@endsection

@section('scripts')
    <script>
        const toggleButton = document.getElementById('dark-mode-toggle');
        const body = document.body;

        // Check if dark mode is already enabled
        if (localStorage.getItem('dark-mode') === 'enabled') {
            body.classList.add('dark-mode');
        }

        // Toggle dark mode on button click
        toggleButton.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
            // Save the state in local storage
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('dark-mode', 'enabled');
            } else {
                localStorage.setItem('dark-mode', 'disabled');
            }
        });
    </script>

    <style>
        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        .dark-mode .card {
            background-color: #333333;
            border-color: #444444;
        }

        .dark-mode .form-control {
            background-color: #444444;
            color: #ffffff;
            border-color: #555555;
        }

        .dark-mode .form-check-input:checked {
            background-color: #666666;
            border-color: #666666;
        }

        .dark-mode .btn-primary {
            background-color: #FFD700;
            border-color: #FFD700;
            color: black;;
        }

        .dark-mode .text-center a {
            color: #bb86fc;
        }

        /* Make all text dark black in light mode */
        body {
            color: #333333;
        }

        /* Dark Mode Toggle Button */
        #dark-mode-toggle {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: black;
            color: gold;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            box-shadow: 0 0 10px rgba(255, 215, 0, 0.6); /* Gold highlight effect */
        }

        #dark-mode-toggle:hover {
            background-color: gold;
            color: black;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.9); /* Brighter gold highlight */
        }

        #dark-mode-toggle i {
            font-size: 20px; /* Dark Mode Icon Size */
        }
    </style>
@endsection
