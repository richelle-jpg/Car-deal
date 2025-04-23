@extends('layouts.appCustomer')

@section('title')
    Home
@endsection

@section('m-content')

<div class="container">
    <!-- Mode Toggle -->
    <div class="text-end mb-3">
        <button id="modeToggle" class="btn btn-sm btn-toggle-mode">Switch to Light Mode</button>
    </div>

    <!-- Search Bar -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <form action="{{ route('search-cars') }}" method="GET" class="d-flex">
                <input type="text" name="search_term" class="form-control me-2" placeholder="Search cars...">
                <button type="submit" class="btn btn-orange">Search</button>
            </form>
        </div>
    </div>

    <h2 class="my-4 text-center">Welcome, {{ Auth::user()->name }}!</h2>

    @if($cars->isNotEmpty())
    <h4 class="text-center text-muted">
        Showing results tailored to your preference: 
        <span class="text-warning">{{ Auth::user()->car_type }}</span> 
        within a <span class="text-success">₱{{ number_format(Auth::user()->budget, 2) }}</span> budget.
    </h4>
    
        <div class="row justify-content-center">
            @foreach ($cars as $car)
                <div class="col-md-4">
                    <div class="card car-card shadow-lg mb-4">
                        <img class="card-img-top car-image" src="{{ asset('users/cars/' . $car->picture) }}" alt="Car image">
                        <div class="card-body">
                            <h5 class="card-title text-warning fw-bold">{{ $car->name }}</h5>
                            <p class="card-text">{!! nl2br(e($car->description)) !!}</p>
                            <p class="card-text text-capitalize text-info">
                                {{ $car->color }} | {{ $car->type }} | 
                                <span class="text-danger fw-bold">{{ number_format($car->price) }}₱</span>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="card-text">
                                    <small class="text-muted">Last updated {{ $car->updated_at->diffForHumans() }}</small>
                                </p>
                                <a href="{{ route('order-create', ['id' => $car->id]) }}" class="btn btn-warning rounded-pill btn-icon">
                                    <span class="tf-icons bx bxs-cart-add"></span>
                                </a>
                            </div>
                            <div class="mt-3 text-center">
                                <a href="{{ url('agent_profile/' . $car->user->id) }}" class="btn btn-outline-primary btn-sm">
                                    Created by: {{ $car->user->name }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <h4 class="text-center">No exact matches found for your selected preferences.</h4>
        <h5 class="text-center">Recommended for You</h5>
        <div class="row justify-content-center">
            @forelse ($recommendations as $car)
                <div class="col-md-4">
                    <div class="card car-card shadow mb-4">
                        @php
                            $imagePath = 'storage/car_images/' . $car->image;
                        @endphp
                        <img class="card-img-top" src="{{ asset(File::exists(public_path($imagePath)) ? $imagePath : 'images/default-car.png') }}" alt="{{ $car->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $car->name }}</h5>
                            <p class="card-text">Type: {{ $car->type }}</p>
                            <p class="card-text">Price: ₱{{ number_format($car->price) }}</p>
                            <a href="{{ route('cars.show', $car->id) }}" class="btn btn-outline-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>No recommended cars available at this time.</p>
                </div>
            @endforelse
        </div>
    @endif

    <!-- Find Agent Section -->
    <div class="find-agent-container text-center">
        <h1>Find an Agent</h1>
    </div>
    <div class="row justify-content-center">
        @foreach ($agents as $agent)
            <div class="col-md-4">
                <div class="card agent-card shadow-lg mb-4">
                    <img class="card-img-top agent-image" src="{{ asset('users/profile/' . $agent->picture) }}" alt="Agent image">
                    <div class="card-body">
                        <h5 class="card-title text-warning fw-bold">{{ $agent->name }}</h5>
                        <p class="card-text">{{ $agent->description }}</p>
                        <p class="card-text text-info">Contact: {{ $agent->contact }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="card-text">
                                <small class="text-muted">Joined {{ $agent->created_at->format('M Y') }}</small>
                            </p>
                            <a href="{{ url('agent_profile/' . $agent->id) }}" class="btn btn-warning rounded-pill btn-icon">
                                <span class="tf-icons bx bxs-user"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('styles')
<style>
    :root {
        --bg-color-dark: #111;
        --text-color-dark: #fff;
        --card-bg-dark: #1c1c1c;

        --bg-color-light: #f9f9f9;
        --text-color-light: #000;
        --card-bg-light: #fff;
    }

    body {
        background: var(--bg-color-dark);
        color: var(--text-color-dark);
        font-family: 'Poppins', sans-serif;
        transition: background 0.4s, color 0.4s;
    }

    .light-mode body {
        background: var(--bg-color-light);
        color: var(--text-color-light);
    }

    .container {
        max-width: 1200px;
        margin: auto;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .col-md-4 {
        display: flex;
        align-items: stretch;
        width: 100%;
        max-width: 30%;
    }

    .car-card, .agent-card {
        background: var(--card-bg-dark);
        border-radius: 15px;
        border: 2px solid #444;
        padding: 15px;
        width: 100%;
        transition: 0.3s;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .light-mode .car-card, .light-mode .agent-card {
        background: var(--card-bg-light);
        border-color: #ccc;
    }

    .car-card:hover, .agent-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 10px 25px rgba(255, 215, 0, 0.4);
        border-color: #ffcc00;
    }

    .car-image, .agent-image {
        height: 220px;
        object-fit: cover;
        width: 100%;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        transition: transform 0.3s ease-in-out;
    }

    .car-card:hover .car-image,
    .agent-card:hover .agent-image {
        transform: scale(1.05);
    }

    .card-title {
        font-size: 1.2rem;
        color: #ffcc00;
    }

    .card-text {
        font-size: 1rem;
        line-height: 1.4;
        color: #bbb;
    }

    .light-mode .card-text {
        color: #333;
    }

    .text-warning { color: #ffcc00 !important; }
    .text-danger { color: #ff4d4d !important; }

    .btn-orange {
        background: linear-gradient(135deg, #ff9900, #ff6600);
        color: white;
        font-weight: bold;
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
    }

    .btn-orange:hover {
        background: linear-gradient(135deg, #ffcc00, #ff9900);
    }

    .btn-icon {
        font-size: 1.2rem;
        padding: 8px 12px;
        background: linear-gradient(135deg, #ffcc00, #ff9900);
        color: #000;
        border-radius: 10px;
        transition: 0.3s;
    }

    .btn-icon:hover {
        background: linear-gradient(135deg, #ff9900, #ff6600);
        transform: scale(1.1);
    }

    .btn-toggle-mode {
        background-color: #444;
        color: #fff;
        border: none;
        padding: 5px 12px;
        border-radius: 8px;
    }

    .light-mode .btn-toggle-mode {
        background-color: #ccc;
        color: #000;
    }

    .find-agent-container h1 {
        font-size: 2rem;
        font-weight: bold;
        color: #ffcc00;
        text-shadow: 2px 2px 10px rgba(255, 204, 0, 0.7);
    }

</style>
@endsection

@section('scripts')
<script>
    const modeToggleBtn = document.getElementById('modeToggle');
    const body = document.body;

    function setMode(mode) {
        if (mode === 'light') {
            document.documentElement.classList.add('light-mode');
            modeToggleBtn.textContent = 'Switch to Dark Mode';
        } else {
            document.documentElement.classList.remove('light-mode');
            modeToggleBtn.textContent = 'Switch to Light Mode';
        }
        localStorage.setItem('theme', mode);
    }

    modeToggleBtn.addEventListener('click', () => {
        const isLight = document.documentElement.classList.contains('light-mode');
        setMode(isLight ? 'dark' : 'light');
    });

    // Load saved mode
    const savedMode = localStorage.getItem('theme') || 'dark';
    setMode(savedMode);
</script>
@endsection
