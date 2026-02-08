<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Notifications\EnrollmentStatusNotification;
use App\Models\User;


class EnrollmentController extends Controller
{
    public function store($id)
{
    $existing = Enrollment::where('user_id', auth()->id())
        ->where('course_id', $id)
        ->first();

    if ($existing) {
        return back()->with('error', 'You have already requested this course.');
    }

    Enrollment::create([
        'user_id' => auth()->id(),
        'course_id' => $id,
        'status' => 'pending',
    ]);

    return back()->with('success', 'Enrollment request sent. Awaiting approval.');
}


    public function myCourses()
{
    $courses = auth()->user()
        ->courses()
        ->withPivot('status')
        ->get();

    return view('courses.my-courses', compact('courses'));
}


    public function index()
{
    $enrollments = Enrollment::with('course', 'user')
        ->where('status', 'pending')
        ->get();

    return view('admin.enrollments', compact('enrollments'));
}


public function approve($id)
{
    $enrollment = Enrollment::findOrFail($id);

    if ($enrollment->status === 'approved') {
        return back()->with('error', 'Already approved.');
    }

    $enrollment->update(['status' => 'approved']);

    return back()->with('success', 'Enrollment approved successfully.');
}

public function reject($id)
{
    $enrollment = Enrollment::findOrFail($id);

    if ($enrollment->status === 'rejected') {
        return back()->with('error', 'Already rejected.');
    }

    $enrollment->update(['status' => 'rejected']);

    return back()->with('success', 'Enrollment rejected successfully.');
}

}
