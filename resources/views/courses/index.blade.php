@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Available Courses</h1>

{{-- Filters --}}
<form method="GET" action="{{ route('courses.index') }}" class="mb-6">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-3">

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search courses..."
            class="px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-700"
        />

        <select
            name="sort"
            class="px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-700">
            <option value="">Sort By</option>
            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                Price: Low to High
            </option>
            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                Price: High to Low
            </option>
        </select>

        <select
            name="price"
            class="px-3 py-2 border rounded dark:bg-gray-800 dark:border-gray-700">
            <option value="">All Courses</option>
            <option value="free" {{ request('price') == 'free' ? 'selected' : '' }}>
                Free
            </option>
            <option value="paid" {{ request('price') == 'paid' ? 'selected' : '' }}>
                Paid
            </option>
        </select>

        <button
            type="submit"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Apply
        </button>

        <a href="{{ route('courses.index') }}"
           class="px-4 py-2 bg-gray-500 text-white text-center rounded hover:bg-gray-600">
            Reset
        </a>

    </div>
</form>

{{-- Courses --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

@forelse($courses as $course)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-5">

        <h2 class="text-lg font-semibold mb-2">
            <a href="{{ route('courses.show', $course->id) }}" class="hover:underline">
                {{ $course->title }}
            </a>
        </h2>

        <p class="text-sm text-gray-600 dark:text-gray-300 mb-3">
            {{ $course->description }}
        </p>

        <div class="flex justify-between items-center">
            <span class="font-bold text-green-600 dark:text-green-400">
                ₹{{ $course->price }}
            </span>

            {{-- ADMIN --}}
            @if(auth()->user()->role === 'admin')
                <div class="flex gap-2">
                    <a href="{{ route('courses.show', $course->id) }}"
                       class="px-3 py-1 text-sm bg-gray-600 text-white rounded">
                        View
                    </a>

                    <a href="/admin/courses/{{ $course->id }}/edit"
                       class="px-3 py-1 text-sm bg-yellow-500 text-white rounded">
                        Edit
                    </a>

                    <form method="POST" action="/admin/courses/{{ $course->id }}">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 text-sm bg-red-600 text-white rounded">
                            Delete
                        </button>
                    </form>
                </div>

            {{-- USER --}}
            @else
                @php
                    $enrollment = $course->users->first();
                @endphp

                @if($enrollment)
                    @if($enrollment->pivot->status === 'approved')
                        <span class="text-green-600 font-semibold">Enrolled ✔</span>
                    @elseif($enrollment->pivot->status === 'pending')
                        <span class="text-yellow-600 font-semibold">Pending</span>
                    @else
                        <span class="text-red-600 font-semibold">Rejected</span>
                    @endif
                @else
                    <form method="POST" action="{{ url('/enroll/'.$course->id) }}">
                        @csrf
                        <button class="px-3 py-1 bg-blue-600 text-white rounded">
                            Request Enrollment
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
@empty
    <p>No courses available.</p>
@endforelse

</div>

{{-- Pagination --}}
<div class="mt-8">
    {{ $courses->withQueryString()->links() }}
</div>

@endsection
