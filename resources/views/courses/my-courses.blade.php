@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">My Courses</h1>

@if($courses->isEmpty())
    <div class="p-4 bg-yellow-100 dark:bg-yellow-800 rounded">
        You have not enrolled in any courses yet.
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($courses as $course)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">
                <h2 class="text-lg font-semibold mb-2">
                    {{ $course->title }}
                </h2>

                <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
                    {{ $course->description }}
                </p>

                @if($course->pivot->status === 'approved')
    <a href="{{ route('courses.content', $course->id) }}"
       class="px-3 py-1 bg-blue-600 text-white rounded">
        Go to Course
    </a>
@elseif($course->pivot->status === 'pending')
    <span class="text-yellow-600 font-semibold">
        Pending Approval
    </span>
@else
    <span class="text-red-600 font-semibold">
        Enrollment Rejected
    </span>
@endif

            </div>
        @endforeach
    </div>
@endif
@endsection
