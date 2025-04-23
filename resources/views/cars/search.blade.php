@extends('layouts.appCustomer')

@section('content')
    <div class="container">
        <h2>Search Results for: "{{ request('search_term') }}"</h2>

        @if ($cars->isEmpty())
            <p>No cars found matching your search.</p>
        @else
            <div class="row">
                @foreach ($cars as $car)
                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{ asset('users/cars/' . $car->picture) }}" class="card-img-top" alt="{{ $car->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $car->name }}</h5>
                                <p class="card-text">Price: ₱{{ number_format($car->price, 2) }}</p>
                                <a href="{{ route('home.car.show', $car->id) }}">View Car</a>


                        </div>
                    </div>
                @endforeach
            </div>

            {{ $cars->links() }} <!-- Pagination links -->
        @endif
    </div>
@endsection
