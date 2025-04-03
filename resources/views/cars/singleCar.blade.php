@extends('layouts.appCustomer')

@section('title')
    Car Details
@endsection

@section('m-content')   
    <div class="row">
        <div class="col-md-12 col-xl-10 m-auto">  {{-- Increased width --}}
            <div class="card shadow-lg mb-5 rounded elegant-border">
                <img class="card-img-top" src="{{ asset('users/cars/' . $car->picture) }}" alt="Car image">
                <div class="card-body">
                    <h3 class="text-light">Name</h3>
                    <h6 class="text-secondary">{{ $car->name }}</h6>
                    
                    <h3 class="text-light">Type and Color</h3>
                    <h6 class="text-secondary text-capitalize">{{ $car->type }} | {{ $car->color }}</h6>
                    
                    <h3 class="text-light">Description</h3>
                    <ul class="text-light description" id="description">
                        @foreach(explode("\n", $car->description) as $index => $descItem)
                            <li class="{{ $index > 2 ? 'more-content d-none' : '' }}">{{ trim($descItem) }}</li>
                        @endforeach
                    </ul>
                    <button id="readMoreBtn" class="btn btn-link p-0">Read More</button>

                    <h3 class="text-light">Price</h3>
                    <h6 class="text-secondary">₱{{ $car->price }}</h6>

                    {{-- ⭐ Star Rating Display --}}
                    <h3 class="text-light">Rating</h3>
                    <div id="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa-star {{ $i <= $averageRating ? 'fa-solid text-warning' : 'fa-regular text-secondary' }}"></i>
                        @endfor
                        <span>({{ number_format($averageRating, 1) }} / 5)</span>
                    </div>

                    {{-- ⭐ Submit Rating --}}
                    <p class="mt-2"><strong>Rate this car:</strong></p>
                    <div id="rate-car">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa-regular fa-star text-secondary rate-star" data-value="{{ $i }}"></i>
                        @endfor
                    </div>

                    <button type="button" id="{{ $car->id }}" class="btnBuy btn d-block btn-primary fs-3 mt-3">
                        <i class="fa-solid fa-cart-plus"></i>
                        <span>Buy</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if (session('success'))
        <script>
            toastr.success('{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            toastr.error('{{ session('error') }}');
        </script>
    @endif

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const readMoreBtn = document.getElementById("readMoreBtn");
            const hiddenContent = document.querySelectorAll(".more-content");

            readMoreBtn.addEventListener("click", function () {
                hiddenContent.forEach(item => item.classList.toggle("d-none"));
                readMoreBtn.textContent = readMoreBtn.textContent === "Read More" ? "Read Less" : "Read More";
            });
        });

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Buy Button
            $(document).on('click', '.btnBuy', function(e) {
                e.preventDefault();
                var id = this.id;
                $.ajax({
                    type: "POST",
                    url: `/customer/order/store/${id}`,
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            title: 'Are you sure of the purchase?',
                            text: "You won't be able to revert this!",
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, Buy it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: response.success,
                                    showConfirmButton: true,
                                })
                            }
                        })
                    }
                });
            });

            // Star Rating System
            $(document).on('click', '.rate-star', function() {
                let carId = {{ $car->id }};
                let rating = $(this).data('value');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You can only rate this car once!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Submit Rating!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('rate-car') }}",
                            data: { car_id: carId, rating: rating },
                            success: function(response) {
                                toastr.success(response.message);

                                // Update the star rating instantly
                                $('#star-rating').empty();
                                for (let i = 1; i <= 5; i++) {
                                    $('#star-rating').append(
                                        `<i class="fa-star ${i <= rating ? 'fa-solid text-warning' : 'fa-regular text-secondary'}"></i>`
                                    );
                                }
                            },
                            error: function(xhr) {
                                if (xhr.status === 400) {
                                    toastr.warning(xhr.responseJSON.message);
                                } else if (xhr.status === 403) {
                                    toastr.error("You must be logged in to rate this car!");
                                } else {
                                    toastr.error("Failed to submit rating!");
                                }
                            }
                        });
                    }
                });
            });

        });
    </script>

    <style>
        /* 🌑 Dark Theme for Car Details Page */
        body {
            background-color: #121212; /* Dark background */
            color: #ffffff; /* White text */
            
        }

        .m-auto {
    max-width: 2000px; /* Increase width */
    width: 150%; /* Use 100% width to prevent overflow */
    margin-left: auto;
    margin-right: auto;
    display: flex;
    justify-content: center; /* Centers the card inside */
    align-items: center; /* Aligns vertically if needed */
}
        /* Car Card Styling */
        .card {
            background-color: #1e1e1e; /* Darker card background */
            color: #ffffff; /* White text */
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.2); /* Enhanced glow */
            border: 2px solid #ff9800; /* Elegant border */
            padding: 15px;
            width: 200%; /* Allows it to expand properly */
    max-width: 1700px; /* Adjust max width for readability */
    margin: 0 auto; /* Ensures the card stays in the center */

        }

        /* Increase image size */
        .card-img-top {
            max-height: 450px; /* Bigger car image */
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Improve button design */
        .btn-primary {
            background-color: #ff9800; /* Orange button */
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #e68900;
        }

        /* Star Rating Icons */
        .fa-star {
            font-size: 26px;
        }

        .text-warning {
            color: #ffcc00 !important; /* Bright gold stars */
        }

        .text-secondary {
            color: #b0b0b0 !important;
        }

        /* Read More button */
        .btn-link {
            color: #ff9800;
        }

        .btn-link:hover {
            color: #e68900;
        }
    </style>
@endsection
