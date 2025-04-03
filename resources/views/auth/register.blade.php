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
                                    <img class="img-fluid" src="{{ asset('assets/img/logo.png') }}"
                                        alt="">
                                </span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-2">Welcome to Cars Deal! 👋</h4>
                        <form id="formAuthentication" class="mb-3" action="{{ route('register') }}"
                            method="POST">
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
                            <button class="btn btn-gold d-grid w-100">Sign up</button>
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

.dark-mode .btn-gold {
    background-color: #FFD700; /* Gold color */
    border-color: #FFD700; /* Gold color */
    color: black;
}

.dark-mode .text-center a {
    color: #bb86fc;
}

/* Make all text dark black in light mode */
body {
    color: #333333;
}

/* Button for toggling dark mode */
#dark-mode-toggle {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 24px;
}

/* Gold button styles */
.btn-gold {
    background-color: #FFD700;
    border-color: #FFD700;
    color: black;
}

/* Font Awesome icons */
.fas {
    font-size: 24px;
}

/* Styling for gold and black icon */
#dark-mode-icon {
    color: black; /* Black color for moon icon */
}

body.dark-mode #dark-mode-icon {
    color: #FFD700; /* Gold color for sun icon when dark mode is on */
}

    </style>
@endsection
