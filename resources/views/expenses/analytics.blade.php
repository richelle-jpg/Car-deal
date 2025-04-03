@extends('layouts.container')

@section('m-content')

@if(isset($myProfile) && $myProfile->img_path == null)
    <p>No profile image available.</p>
@else
    <img src="{{ asset('storage/' . $myProfile->img_path) }}" alt="Profile Image">
@endif

    <div class="container mt-5">
        <h2>Expenses Analytics</h2>
        <p>This is a test page for expenses analytics.</p>
    </div>
@endsection
