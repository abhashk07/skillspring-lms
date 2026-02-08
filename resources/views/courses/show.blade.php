@extends('layouts.app')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <h2>{{ $course->title }}</h2>
        <p class="text-muted">{{ $course->description }}</p>
        <h4 class="text-success">₹{{ $course->price }}</h4>

        @if($isEnrolled)
            <a href="{{ route('courses.content', $course->id) }}"
               class="btn btn-primary mt-3">
                View Course Content
            </a>
        @else
            <form method="POST" action="{{ url('/enroll/'.$course->id) }}">
                @csrf
                <button class="btn btn-success mt-3">Enroll Now</button>
            </form>
        @endif
    </div>
</div>
@endsection
