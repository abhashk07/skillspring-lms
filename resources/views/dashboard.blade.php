@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard</h2>
    <p>Welcome {{ auth()->user()->name }}</p>

    <a href="/courses" class="btn btn-primary">View Courses</a>
</div>
@endsection
