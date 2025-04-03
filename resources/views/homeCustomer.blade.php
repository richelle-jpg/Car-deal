@extends('layouts.appCustomer')

@section('title')
    Home
@endsection

@section('m-content')
    <div class="container">
        <div class="row">
        @foreach ($cars as $car)
    <div class="col-md-4"> <!-- Changed from col-md-6 to col-md-4 for 3 columns -->
        <div class="card car-card shadow-lg mb-4">
            <img class="card-img-top car-image" src="{{ asset('users/cars/' . $car->picture) }}" alt="Car image">
            <div class="card-body">
                <h5 class="card-title text-warning fw-bold">{{ $car->name }}</h5>
                <p class="card-text text-light">{!! nl2br(e($car->description)) !!}</p>
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

        <!-- Find Agent Section -->
        <div class="find-agent-container">
            <h1>Find an Agent</h1>
        </div>
        <div class="row">
            @foreach ($agents as $agent)
                <div class="col-md-4"> <!-- 3 columns -->
                    <div class="card agent-card shadow-lg mb-4">
                        <img class="card-img-top agent-image" src="{{ asset('storage/users/agents/' . $agent->picture) }}" alt="Agent image">

                        <div class="card-body">
                            <h5 class="card-title text-warning fw-bold">{{ $agent->name }}</h5>
                            <p class="card-text text-light">{{ $agent->description }}</p>
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
  /* Global Styles */
body {
    background: #111;
    color: #fff;
    font-family: 'Poppins', sans-serif;
}

.container {
    max-width: 1200px;
    margin: auto;
}

/* 3-Column Layout */
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
    max-width: 30%; /* Adjust for 3-column layout */
}

/* Card Styles */
.car-card, .agent-card {
    background: #1c1c1c;
    border-radius: 15px;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    overflow: hidden;
    border: 2px solid #444;
    padding: 15px;
    width: 100%;
    height: auto;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.car-card:hover, .agent-card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 10px 25px rgba(255, 215, 0, 0.4);
    border-color: #ffcc00;
}

/* Card Images */
.car-image, .agent-image {
    height: 220px;
    object-fit: cover;
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
    transition: transform 0.3s ease-in-out;
    width: 100%;
}

.car-card:hover .car-image, .agent-card:hover .agent-image {
    transform: scale(1.05);
}

/* Card Text */
.card-title {
    font-size: 1.2rem;
    color: #ffcc00;
}

.card-text {
    font-size: 1rem;
    line-height: 1.4;
    color: #bbb;
}

.text-warning {
    color: #ffcc00 !important;
}

.text-danger {
    color: #ff4d4d !important;
}

/* Buttons */
.btn-icon {
    font-size: 1.2rem;
    padding: 8px 12px;
    background: linear-gradient(135deg, #ffcc00, #ff9900);
    color: #000;
    transition: background 0.3s ease-in-out, transform 0.2s;
    border-radius: 10px;
}

.btn-icon:hover {
    background: linear-gradient(135deg, #ff9900, #ff6600);
    transform: scale(1.1);
}

/* Created by Section */
.text-center .btn-outline-primary {
    border-color: #ffcc00;
    color: #ffcc00;
    font-size: 0.9rem;
}

.text-center .btn-outline-primary:hover {
    background: #ffcc00;
    color: #111;
}

/* Find an Agent Section */
.find-agent-container {
    text-align: center;
    margin: 40px 0 20px;
}

.find-agent-container h1 {
    font-size: 2rem;
    font-weight: bold;
    color: #ffcc00;
    text-shadow: 2px 2px 10px rgba(255, 204, 0, 0.7);
}

</style>
@endsection
