<!-- resources/views/admin/dashboard.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome to the Admin Dashboard</h1>
        
        <!-- Display some admin-only content -->
        <div class="card">
            <div class="card-header">Admin Panel</div>
            <div class="card-body">
                <p>Only accessible by admins.</p>
            </div>
        </div>
    </div>
@endsection
