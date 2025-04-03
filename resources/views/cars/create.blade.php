@extends('layouts.container')

@section('title')
    Create Cars
@endsection

@section('m-content')
<button id="darkModeToggle" class="btn btn-dark position-fixed top-0 end-0 m-3">🌙</button>

    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1">
            <div class="row">
                <div class="col-md-12">
                    <!-- All Cars -->
                    <div class="card">
                        <h5 class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('cars-index') }}" class="btn btn-info">
                                    <span class="tf-icons fa-solid fa-angles-left"></span> &nbsp; Back
                                </a>
                            </div>
                        </h5>
                        <div class="card-body">
                            <form action="{{ route('cars-store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label class="form-label" for="name">Name of car</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}"
                                            id="name" name="name">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                        
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label class="form-label" for="type">Type of car</label>
                                        <select class="form-control @error('type') is-invalid @enderror" name="type" id="type">
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
                                        @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                        
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label class="form-label" for="price">Price</label>
                                        <input type="text" class="form-control @error('price') is-invalid @enderror"
                                            id="price" name="price" value="{{ old('price') }}" oninput="formatPrice(this)">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                        
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label class="form-label" for="color">Color of car</label>
                                        <select class="form-control @error('color') is-invalid @enderror" name="color" id="color">
                                            <option value="">Select Color</option>
                                            <option value="black">Black</option>
                                            <option value="White">White</option>
                                            <option value="red">Red</option>
                                            <option value="blue">Blue</option>
                                            <option value="green">Green</option>
                                            <option value="yellow">Yellow</option>
                                            <option value="Orange">Orange</option>
                                            <option value="purple">Purple</option>
                                            <option value="ashen">Ashen</option>
                                            <option value="silver">Silver</option>
                                            <option value="gray">Gray</option>
                                        </select>
                                        @error('color')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                        
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label for="description">Description</label>
                                        <ul id="description-container" class="list-group">
                                            <li class="list-group-item">
                                                <textarea name="descriptions[]" class="form-control @error('description') is-invalid @enderror"
                                                    placeholder="Enter description"
                                                    style="max-height:120px; height: 100px; text-align: left; font-family: monospace; white-space: pre-line; padding: 8px;"></textarea>
                                            </li>
                                        </ul>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                        
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label class="form-label" for="number_of_cars">Number of Cars</label>
                                        <input type="number" class="form-control @error('number_of_cars') is-invalid @enderror"
                                            id="number_of_cars" name="number_of_cars">
                                        @error('number_of_cars')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                        
                                    <div class="col-md-12 col-sm-12 mb-3 d-flex justify-content-start align-items-center gap-4">
                                        <div class="col-5">
                                            <img src="{{ asset('users/cars/1.png') }}" alt="user-avatar"
                                                class="d-block rounded img-fluid" id="uploadedAvatar" />
                                        </div>
                                        <div class="button-wrapper">
                                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                <span class="d-none d-sm-block">Upload new photo</span>
                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                                <input type="file" id="upload" name="picture"
                                                    class="account-file-input @error('picture') is-invalid @enderror"
                                                    hidden accept="image/png, image/jpeg" />
                                            </label>
                                            <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                                <i class="bx bx-reset d-block d-sm-none"></i>
                                                <span class="d-none d-sm-block">Reset</span>
                                            </button>
                                            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                            @error('picture')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                        
                                    <div class="col-md-12 col-sm-12 mb-3 text-center">
                                        <button type="submit" class="btn btn-info">
                                            <span class="tf-icons bx bxs-save"></span> &nbsp; Post
                                        </button>
                                    </div>
                                </div>
                            </form>
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
#darkModeToggle {
    position: fixed !important;
    top: 80px !important; /* Increase this value to move it further down */
    right: 20px !important; /* Adjust this if necessary */
    z-index: 1000 !important; /* Ensures it stays above other elements */
    background-color: #333;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: background 0.3s ease;
}

#darkModeToggle:hover {
    background-color: #444;
}


.dark-mode .card {
    background-color: #1e1e1e;
    color: #ffffff;
    border-color: #333;
}

.dark-mode input,
.dark-mode select,
.dark-mode textarea {
    background-color: #333;
    color: #fff;
    border-color: #555;
}

.dark-mode .btn {
    background-color: #444;
    color: #fff;
}

.dark-mode .btn-outline-secondary {
    background-color: transparent;
    color: #fff;
    border-color: #ccc;
}

</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const darkModeToggle = document.getElementById("darkModeToggle");
        const body = document.body;

        // Check user preference from localStorage
        if (localStorage.getItem("darkMode") === "enabled") {
            body.classList.add("dark-mode");
        }

        darkModeToggle.addEventListener("click", function () {
            body.classList.toggle("dark-mode");

            // Save preference in localStorage
            if (body.classList.contains("dark-mode")) {
                localStorage.setItem("darkMode", "enabled");
            } else {
                localStorage.setItem("darkMode", "disabled");
            }
        });
    });

    function formatPrice(input) {
        // Remove any non-numeric characters except decimal and comma
        let value = input.value.replace(/,/g, '').replace(/[^\d.]/g, '');
        
        // Format the number with commas
        if (!isNaN(value) && value !== "") {
            input.value = Number(value).toLocaleString('en-US');
        }
    }
</script>

@section('scripts')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
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
@endsection