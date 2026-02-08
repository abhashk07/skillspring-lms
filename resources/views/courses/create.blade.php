@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">

    <h1 class="text-2xl font-bold mb-6">Add New Course</h1>

    <form method="POST" action="/admin/courses">
        @csrf

        <div class="mb-4">
            <label class="block text-sm mb-1">Title</label>
            <input type="text" name="title"
                   class="w-full border rounded p-2 dark:bg-gray-700"
                   required>
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Description</label>
            <textarea name="description"
                      class="w-full border rounded p-2 dark:bg-gray-700"
                      rows="4"
                      required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Price (₹)</label>
            <input type="number" name="price"
                   class="w-full border rounded p-2 dark:bg-gray-700"
                   required>
        </div>

        <button class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Save Course
        </button>
    </form>

</div>
@endsection
