@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Enrollment Requests</h1>

@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        {{ session('error') }}
    </div>
@endif

<table class="w-full border border-gray-300 dark:border-gray-700">
    <thead class="bg-gray-200 dark:bg-gray-700">
        <tr>
            <th class="p-2 text-left">User</th>
            <th class="p-2 text-left">Course</th>
            <th class="p-2 text-left">Status / Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($enrollments as $enroll)
            <tr class="border-t dark:border-gray-700">

                <td class="p-2">
                    {{ $enroll->user->name }}
                </td>

                <td class="p-2">
                    {{ $enroll->course->title }}
                </td>

                <td class="p-2">
                    @if($enroll->status === 'pending')
                        <form method="POST"
                              action="/admin/enrollments/{{ $enroll->id }}/approve"
                              class="inline">
                            @csrf
                            <button class="px-2 py-1 bg-green-600 text-white rounded">
                                Approve
                            </button>
                        </form>

                        <form method="POST"
                              action="/admin/enrollments/{{ $enroll->id }}/reject"
                              class="inline">
                            @csrf
                            <button class="px-2 py-1 bg-red-600 text-white rounded">
                                Reject
                            </button>
                        </form>

                    @elseif($enroll->status === 'approved')
                        <span class="text-green-600 font-semibold">
                            Approved
                        </span>

                    @else
                        <span class="text-red-600 font-semibold">
                            Rejected
                        </span>
                    @endif
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="3" class="p-4 text-center text-gray-500">
                    No enrollment requests found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
