@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">{{ $course->title }}</h1>

@php
    $completed = auth()->user()
        ->lessons()
        ->whereIn('lesson_id', $course->lessons->pluck('id'))
        ->wherePivot('completed', true)
        ->count();

    $total = $course->lessons->count();
    $progress = $total ? round(($completed / $total) * 100) : 0;
@endphp

<p class="mb-4 font-semibold">
    Progress: {{ $progress }}%
</p>

@foreach($course->lessons as $lesson)
    @php
        $done = auth()->user()
            ->lessons()
            ->where('lesson_id', $lesson->id)
            ->wherePivot('completed', true)
            ->exists();
    @endphp

    <div class="bg-white dark:bg-gray-800 p-4 rounded shadow mb-3">
        <h3 class="font-semibold">{{ $lesson->title }}</h3>
        <p class="text-sm mb-2">{{ $lesson->content }}</p>

        @if(!$done)
            <form method="POST" action="/lesson/{{ $lesson->id }}/complete">
                @csrf
                <button class="px-3 py-1 bg-green-600 text-white rounded">
                    Mark as Completed
                </button>
            </form>
        @else
            <span class="text-green-600 font-semibold">Completed ✔</span>
        @endif
    </div>
@endforeach
@endsection
