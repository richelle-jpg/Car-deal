@section('title', 'Profile')

<style>
    
    /* ======= General Styles ======= */
body {
    background-color: #121212;
    color: #e0b343;
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
}

/* ======= Header Styling ======= */
.profile-header {
    background: #ffffff;
    color: #222;
    padding: 10px 20px; /* Reduced padding */
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    height: 80px; /* Reduced height */
}

/* Logo and Text */
.profile-header img {
    width: 50px; /* Adjusted logo size */
    height: auto;
    margin-right: 10px;
}

.profile-header h5 {
    margin: 0;
    font-size: 1.5rem;
    font-weight: bold;
}

/* CarDeal Text Styling */
.car-deal-text {
    color: #dc3545; /* Red */
    font-weight: bold;
}

/* Navbar Styling */
.bg-navbar-theme {
    background-color: #fff !important;
    border-bottom: 3px solid #e0b343;
    padding: 5px 15px;
    display: flex;
    align-items: center;
    justify-content: flex-start; /* Align logo to the left */
}

/* Navbar Brand (Logo + Text) */
.navbar-nav {
    display: flex;
    align-items: center;
}

/* Logo */
.navbar-nav a {
    display: flex;
    align-items: center;
    text-decoration: none;
}

.navbar-nav img {
    width: 50px; /* Adjust Logo Size */
    margin-right: 10px;
}

/* Logo Text Styling */
.navbar-nav span {
    font-size: 1.8rem;
    font-weight: bold;
}


/* ======= Profile Card Styling ======= */
.profile-card {
    max-width: 700px;
    margin: auto;
    margin-top: 20px;
    border-radius: 12px;
    overflow: hidden;
    background: #1e1e1e;
    box-shadow: 0px 5px 15px rgba(255, 215, 0, 0.2);
}

/* Profile Header */
.profile-header {
    background: #222;
    color: #e0b343;
    padding: 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-radius: 12px 12px 0 0;
    border-bottom: 3px solid #e0b343;
}

/* Profile Info */
.profile-body {
    padding: 20px;
    background: #1e1e1e;
    border-radius: 0 0 12px 12px;
}

.profile-img {
    height: 120px;
    width: 120px;
    border-radius: 50%;
    border: 4px solid #e0b343;
    object-fit: cover;
}

.profile-info {
    margin-left: 20px;
}

.profile-info h4 {
    font-weight: bold;
    color: #e0b343;
}

.profile-info p {
    margin: 5px 0;
    font-size: 14px;
    color: #bbb;
}

/* Profile Details */
.profile-details p {
    font-size: 14px;
    color: #ddd;
    margin-bottom: 5px;
}

.profile-details strong {
    color: #e0b343;
}

/* ======= Dark Mode Toggle Button ======= */
#darkModeToggle {
    background: none;
    border: none;
    color: #e0b343;
    font-size: 1.2rem;
    cursor: pointer;
}

/* ======= Responsive Design ======= */
@media (max-width: 768px) {
    .profile-header {
        flex-direction: column;
        text-align: center;
        height: auto;
        padding: 15px;
    }

    .profile-img {
        height: 100px;
        width: 100px;
    }

    .profile-info {
        text-align: center;
        margin-left: 0;
    }

    .navbar-nav span {
        font-size: 1.5rem;
    }
}
</style>

<!-- Layout Wrapper -->
<div class="layout-wrapper layout-content-navbar layout-without-menu">
    <div class="layout-container">
        <!-- Layout Container -->
        <div class="layout-page">
            <!-- Navbar -->
            <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                    <!-- Logo -->
                    <div class="navbar-nav align-items-center mx-2">
                        <div class="nav-item d-flex align-items-center">
                            <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                                <img src="{{ asset('assets/img/logo.png') }}" alt="CarDeal Logo">
                                <span class="fw-bold fs-4">
                                    <span class="fw-bold fs-4 car-deal-text">CarDeal</span>

                                </span>
                            </a>
                        </div>
                    </div>
                    <!-- /Logo -->
                </div>
            </nav>

            <!-- Content Wrapper -->
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <!-- Profile Card -->
                            <div class="profile-card shadow-lg">
                                <!-- Profile Header -->
                                <div class="profile-header">
                                    <h5><i class="bx bx-user-circle"></i> Profile Details</h5>
                                </div>

                                <!-- Profile Body -->
                                <div class="profile-body">
                                    <div class="d-flex align-items-center">
                                        <!-- Profile Image -->
                                        <div>
                                            @if ($profile->img_path == null)
                                                <img src="{{ asset('users/profile/1.png') }}" alt="User Avatar" class="profile-img">
                                            @else
                                                <img src="{{ asset('users/profile/' . $profile->img_path) }}" alt="User Avatar" class="profile-img">
                                            @endif
                                        </div>
                                        <!-- Profile Info -->
                                        <div class="profile-info">
                                            <h4>{{ $profile->user->name ?? 'N/A' }} {{ $profile->lname ?? '' }}</h4>
                                            <p><i class="bx bx-envelope"></i> {{ $profile->user->email ?? 'N/A' }}</p>
                                            <p><i class="bx bx-phone"></i> {{ $profile->phone ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <hr>

                                    <!-- Profile Details -->
                                    <div class="row profile-details">
                                        <div class="col-md-6">
                                            <p><strong><i class="bx bx-cake"></i> Date of Birth:</strong> {{ $profile->dob ?? 'N/A' }}</p>
                                            <p><strong><i class="bx bx-map"></i> Address:</strong> {{ $profile->address ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong><i class="bx bx-user"></i> Gender:</strong> {{ $profile->gender ?? 'N/A' }}</p>
                                            <p><strong><i class="bx bx-id-card"></i> National ID:</strong> {{ $profile->national_id ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End of Profile Card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
