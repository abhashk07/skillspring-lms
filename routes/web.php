<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;

Route::get('/', function () {
    return redirect('/courses');
});

Route::get('/dashboard', function () {
    return redirect('/courses');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // ======================
    // USER ROUTES
    // ======================

    Route::get('/courses', [CourseController::class, 'index'])
        ->name('courses.index');

    Route::post('/enroll/{id}', [EnrollmentController::class, 'store']);

    Route::get('/my-courses', [EnrollmentController::class, 'myCourses']);

    Route::get('/courses/{course}', [CourseController::class, 'show'])
        ->name('courses.show');

    Route::get('/course/{id}/content', [CourseController::class, 'content'])
        ->name('courses.content');

    Route::post('/lesson/{id}/complete', function ($id) {
        auth()->user()->lessons()->syncWithoutDetaching([
            $id => ['completed' => true]
        ]);
        return back();
    });

    // ======================
    // ADMIN ROUTES
    // ======================
    Route::middleware(['admin'])->group(function () {

        // ADMIN DASHBOARD
        Route::get('/admin/dashboard', function () {

            $users = User::count();
            $courses = Course::count();
            $enrollments = Enrollment::count();

            $recentEnrollments = Enrollment::latest()->take(5)->get();

            $popularCourses = Course::withCount('enrollments')
                ->orderBy('enrollments_count', 'desc')
                ->take(5)
                ->get();

            return view('admin.dashboard', compact(
                'users',
                'courses',
                'enrollments',
                'recentEnrollments',
                'popularCourses'
            ));
        });

        // ENROLLMENT MANAGEMENT
        Route::get('/admin/enrollments', [EnrollmentController::class, 'index']);
        Route::post('/admin/enrollments/{id}/approve', [EnrollmentController::class, 'approve']);
        Route::post('/admin/enrollments/{id}/reject', [EnrollmentController::class, 'reject']);

        // COURSE MANAGEMENT
        Route::get('/admin/courses/create', [CourseController::class, 'create']);
        Route::post('/admin/courses', [CourseController::class, 'store']);
        Route::get('/admin/courses/{course}/edit', [CourseController::class, 'edit']);
        Route::put('/admin/courses/{course}', [CourseController::class, 'update']);
        Route::delete('/admin/courses/{course}', [CourseController::class, 'destroy']);
    });
});

// 🔥 REQUIRED FOR LARAVEL BREEZE AUTH
require __DIR__.'/auth.php';
