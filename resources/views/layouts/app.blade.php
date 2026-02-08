<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Course Platform</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

<nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 p-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <!-- Logo -->
        <a href="{{ route('courses.index') }}" class="flex items-center gap-2 text-xl font-bold text-gray-800 dark:text-white">
    <span class="text-green-600 text-2xl">🌱</span>
    <span>SkillSpring</span>
</a>

        <!-- Links -->
        <div class="flex gap-4 items-center">

            @auth
                @if(auth()->user()->role === 'admin')
                    <!-- ADMIN LINKS -->
                    <a href="/admin/dashboard" class="hover:underline">
                        Dashboard
                    </a>

                    <a href="/courses" class="hover:underline">
                        Courses
                    </a>

                    <a href="/admin/courses/create" class="hover:underline">
                        Add Course
                    </a>

                    <a href="/admin/enrollments" class="hover:underline">
                        Enrollments
                    </a>
                @else
                    <!-- USER LINKS -->
                    <a href="/courses" class="hover:underline">
                        Courses
                    </a>

                    <a href="/my-courses" class="hover:underline">
                        My Courses
                    </a>
                @endif

                <!-- Logout (COMMON) -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="hover:underline">
                        Logout
                    </button>
                </form>
            @endauth

        </div>
    </div>
</nav>



<main class="max-w-7xl mx-auto p-6">
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-100">
            {{ session('error') }}
        </div>
    @endif
    @if(session('success'))
    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
        {{ session('error') }}
    </div>
@endif

    @yield('content')
</main>

</body>
</html>
