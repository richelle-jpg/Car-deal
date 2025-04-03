@extends('layouts.container')

@section('title')
    All Cars
@endsection

@section('m-content')
    <!-- Content wrapper -->
    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1">
            <div class="row">
                <div class="col-md-12">
                    <!-- All Cars -->
                    <div class="card car-card shadow-lg">
                        <h5 class="card-header bg-dark text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>🚘 Available Cars</span>
                                <a href="{{ route('cars-create') }}" class="btn btn-warning fw-bold">
                                    Add New Car &nbsp; <span class="tf-icons fa-solid fa-plus"></span>
                                </a>
                            </div>
                        </h5>
                        <div class="table-responsive text-nowrap">
                            <table class="table table-dark table-hover" id="CarTable">
                                <thead class="bg-warning text-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Picture</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                @if (count($cars) > 0)
                                    <tbody>
                                        @php $count = 1; @endphp
                                        @foreach ($cars as $car)
                                        <tr class="table-row">
                                            <td>{{ $count++ }}</td>
                                            <td class="fw-bold text-light">{{ $car->name }}</td>
                                            <td class="text-success fw-bold">₱{{ number_format($car->price) }}</td> 
                                            <td class="text-light">{{ $car->number_of_cars }}</td>
                                                <td class="col-2">
                                                    <img class="img-thumbnail car-image" 
                                                        src="{{ asset('users/cars/' . $car->picture) }}" />
                                                </td>
                                                <td>
                                                    <a href="{{ route('cars-edit', ['id' => $car->id]) }}"
                                                        class="btn btnEditCar btn-sm btn-icon btn-outline-info">
                                                        <span class="tf-icons bx bx-edit"></span>
                                                    </a>
                                                    <a href="" id="{{ $car->id }}"
                                                        class="btn btnDeleteCar btn-sm btn-icon btn-outline-danger">
                                                        <span class="tf-icons fa-solid fa-trash"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @endif
                            </table>
                        </div>
                        <div class="card-footer bg-dark text-white">
                            {{ $cars->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
    </div>
    <!-- Content wrapper -->
@endsection

@section('styles')
    <style>
        body {
            background-color: #121212;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
        }

        .car-card {
            background: linear-gradient(135deg, #1c1c1c, #2d2d2d);
            border-radius: 15px;
            transition: all 0.3s ease-in-out;
            padding: 20px;
        }

        .car-card:hover {
            transform: scale(1.03);
            box-shadow: 0px 10px 20px rgba(255, 215, 0, 0.5);
        }

        .table-row:hover {
            background-color: rgba(255, 215, 0, 0.2) !important;
        }

        .car-image {
            width: 100px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease-in-out;
        }

        .car-image:hover {
            transform: scale(1.2);
        }
    </style>
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
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.btnDeleteCar', function(e) {
                e.preventDefault();
                var id = this.id;
                
                $.ajax({
                    type: "GET",
                    url: `/admin/cars/destroy/${id}`,
                    dataType: "JSON",
                    success: function(response) {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This action cannot be undone!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                Swal.fire(
                                    'Deleted!',
                                    response.success,
                                    'success'
                                );
                                $("#CarTable").load(location.href + " #CarTable");
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
