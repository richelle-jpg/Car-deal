@extends('layouts.container')

@section('title')
    Edit Cars
@endsection


@section('m-content')
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
                            <form action="{{ route('cars-update', $car->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <input type="hidden" name="id" value="{{ $car->id }}">
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label class="form-label" for="basic-default-name">Name of car</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror "
                                            value="{{ $car->name }}" id="name" name="name" placeholder="Name of car">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label class="form-label" for="basic-default-type">type of car</label>
                                        <input type="text" class="form-control @error('type') is-invalid @enderror "
                                            value="{{ $car->type }}" id="type" name="type" placeholder="type of car">
                                        @error('type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label class="form-label" for="basic-default-price">price of car</label>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror "
                                            id="price" name="price" placeholder="price of car" value="{{ $car->price }}">
                                        @error('price')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label class="form-label" for="basic-default-name">color of car</label>
                                        <select class="form-control @error('color') is-invalid @enderror" name="color"
                                            id="color">
                                            <option @if ($car->color == 'black') selected @endif value="black">Black
                                            </option>
                                            <option @if ($car->color == 'White') selected @endif value="White">White
                                            </option>
                                            <option @if ($car->color == 'red') selected @endif value="red">Red
                                            </option>
                                            <option @if ($car->color == 'blue') selected @endif value="blue">Blue
                                            </option>
                                            <option @if ($car->color == 'green') selected @endif value="green">Green
                                            </option>
                                            <option @if ($car->color == 'yellow') selected @endif value="yellow">Yellow
                                            </option>
                                            <option @if ($car->color == 'Orange') selected @endif value="Orange">Orange
                                            </option>
                                            <option @if ($car->color == 'purple') selected @endif value="purple">Purple
                                            </option>
                                            <option @if ($car->color == 'ashen') selected @endif value="ashen">Ashen
                                            </option>
                                            <option @if ($car->color == 'silver') selected @endif value="silver">Silver
                                            </option>
                                        </select>
                                        @error('color')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label for="floatingTextarea2">Description of car</label>
                                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                            placeholder="Description of car" style="max-height:120px ;height: 100px">{{ $car->description }}
                                        </textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 col-sm-12 mb-3">
                                        <label class="form-label" for="basic-default-number_of_cars">Number of
                                            cars</label>
                                        <input type="number" value="{{ $car->number_of_cars }}"
                                            class="form-control @error('number_of_cars') is-invalid @enderror "
                                            id="number_of_cars" name="number_of_cars" placeholder="Number">
                                        @error('number_of_cars')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div
                                        class="col-md-12 col-sm-12 mb-3 d-flex justify-content-start align-items-center gap-4">
                                        <div class="col-5">
                                            <img src="{{ asset('users/cars/' . $car->picture) }}" alt="user-avatar"
                                                class="d-block rounded img-fluid" id="uploadedAvatar" />
                                        </div>
                                        <div class="button-wrapper">
                                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                <span class="d-none d-sm-block">Upload new photo</span>
                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                                <input type="file" value="{{ asset('users/cars/' . $car->picture) }}"
                                                    id="upload" name="picture"
                                                    class="account-file-input @error('picture') is-invalid @enderror"
                                                    hidden accept="image/png, image/jpeg" />
                                            </label>
                                            <button type="button"
                                                class="btn btn-outline-secondary account-image-reset mb-4">
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
                                            <span class="tf-icons bx bxs-save"></span> &nbsp; Update
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- All Users -->
                </div>
            </div>
        </div>
        <!-- / Content -->
    </div>
    <!-- Content wrapper -->
@endsection


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
