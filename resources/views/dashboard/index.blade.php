@extends('layouts.app')
@section('content_title', 'Dashboard')
@section('content')
    <div class="card">
        <div class="caard-body">
            <h3>Welcome to the Dashboard</h3>
            <p>This is your dashboard where you can manage your application.</p>
            <p>Use the sidebar to navigate through different sections.</p>
            <p>Current User: <strong>{{ auth()->user()->name }}</strong></p>
        </div>
    </div>
@endsection
