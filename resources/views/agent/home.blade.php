@extends('layouts.container')

@section('title')
    Agent Profile
@endsection

@section('m-content')
<button id="darkModeToggle" class="btn btn-dark position-fixed top-0 end-0 m-3">🌙</button>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1">
        <div class="row">
            <div class="col-md-4">
                <div class="card agent-card">
                    <h5 class="card-header text-center">Agent Information</h5>
                    <div class="card-body text-center">
                        <img src="{{ asset('users/agents/default-avatar.png') }}" alt="Agent Avatar" class="rounded-circle mb-3 agent-avatar">
                        <h5 class="card-title">{{ $agent->name }}</h5>
                        <p class="card-text"><i class="fas fa-envelope"></i> {{ $agent->email }}</p>
                        <p class="card-text"><i class="fas fa-phone"></i> {{ $agent->contact }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <h5 class="card-header d-flex justify-content-between align-items-center">
                        Cars Posted
                        <a href="{{ route('cars-create') }}" class="btn btn-primary">+ Add New Car</a>
                    </h5>
                    <div class="card-body">
                        @if($cars->isEmpty())
                            <p class="text-center">No cars posted yet.</p>
                        @else
                            <div class="row">
                                @foreach($cars as $car)
                                    <div class="col-md-6 mb-3">
                                        <div class="card car-card">
                                            <img src="{{ asset('storage/cars/' . $car->picture) }}" class="card-img-top car-img" alt="{{ $car->name }}">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $car->name }}</h5>
                                                <p class="card-text">Type: <strong>{{ $car->type }}</strong></p>
                                                <p class="card-text">Color: <strong>{{ $car->color }}</strong></p>
                                                <p class="card-text price">₱{{ number_format($car->price, 2) }}</p>
                                                <a href="{{ route('cars-show', $car->id) }}" class="btn btn-info">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<style>
    body.dark-mode {
        background-color: #121212;
        color: #ffffff;
    }

    .dark-mode .card {
        background-color: #1e1e1e;
        color: #ffffff;
        border-color: #444;
    }

    .agent-card, .car-card {
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out;
    }

    .agent-card:hover, .car-card:hover {
        transform: scale(1.02);
    }

    .agent-avatar {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 4px solid #007bff;
    }

    .car-img {
        height: 180px;
        object-fit: cover;
        border-radius: 8px 8px 0 0;
    }

    .price {
        font-size: 1.2rem;
        font-weight: bold;
        color: #28a745;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const darkModeToggle = document.getElementById("darkModeToggle");
        const body = document.body;

        if (localStorage.getItem("darkMode") === "enabled") {
            body.classList.add("dark-mode");
        }

        darkModeToggle.addEventListener("click", function () {
            body.classList.toggle("dark-mode");
            localStorage.setItem("darkMode", body.classList.contains("dark-mode") ? "enabled" : "disabled");
        });
    });
</script>
