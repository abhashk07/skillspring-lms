@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow text-center">
        <h3 class="text-sm uppercase">Users</h3>
        <p class="text-3xl font-bold mt-2">{{ $users }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow text-center">
        <h3 class="text-sm uppercase">Courses</h3>
        <p class="text-3xl font-bold mt-2">{{ $courses }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded shadow text-center">
        <h3 class="text-sm uppercase">Enrollments</h3>
        <p class="text-3xl font-bold mt-2">{{ $enrollments }}</p>
    </div>

</div>

<!-- 🔹 Manage Enrollments Button -->
<div class="mt-6">
    <a href="/admin/enrollments"
       class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
        Manage Enrollments
    </a>
</div>

<!-- Analytics -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">

    <!-- Recent Enrollments -->
    <div class="bg-white dark:bg-gray-800 p-5 rounded shadow">
        <h3 class="font-semibold mb-3">Recent Enrollments</h3>

        <ul class="text-sm">
            @forelse($recentEnrollments as $enroll)
                <li class="border-b border-gray-200 dark:border-gray-700 py-1">
                    User #{{ $enroll->user_id }} enrolled in Course #{{ $enroll->course_id }}
                </li>
            @empty
                <li>No enrollments yet</li>
            @endforelse
        </ul>
    </div>

    <!-- Popular Courses -->
    <div class="bg-white dark:bg-gray-800 p-5 rounded shadow">
        <h3 class="font-semibold mb-3">Most Enrolled Courses</h3>

        <ul class="text-sm">
            @forelse($popularCourses as $course)
                <li class="border-b border-gray-200 dark:border-gray-700 py-1">
                    {{ $course->title }} ({{ $course->enrollments_count }} enrollments)
                </li>
            @empty
                <li>No data</li>
            @endforelse
        </ul>
    </div>

</div>
@endsection
