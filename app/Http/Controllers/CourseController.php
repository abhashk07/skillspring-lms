<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;


class CourseController extends Controller
{
    // Show all courses
 public function index(Request $request)
{
    $query = Course::query();

    // 🔍 Search
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    // 💰 Price Filter
    if ($request->price === 'free') {
        $query->where('price', 0);
    }

    if ($request->price === 'paid') {
        $query->where('price', '>', 0);
    }

    // ↕ Sorting
    if ($request->sort === 'price_low') {
        $query->orderBy('price', 'asc');
    } elseif ($request->sort === 'price_high') {
        $query->orderBy('price', 'desc');
    } else {
        // Default: Latest
        $query->latest();
    }

    $courses = $query->paginate(6)->withQueryString();

    return view('courses.index', compact('courses'));
}


    // Show create course form (ADMIN)
    public function create()
    {
        return view('courses.create');
    }

    // Store new course (ADMIN)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully');
    }

    // Show course detail
    public function show(Course $course)
    {
        $isEnrolled = $course->enrollments()
            ->where('user_id', auth()->id())
            ->exists();

        return view('courses.show', compact('course', 'isEnrolled'));
    }

    // 🔒 Locked course content
    public function content($id)
{
    // Load course WITH lessons
    $course = Course::with('lessons')->findOrFail($id);

    // Check enrollment approval
    $enrollment = $course->enrollments()
        ->where('user_id', auth()->id())
        ->where('status', 'approved')
        ->first();

    if (!$enrollment) {
        return redirect('/my-courses')
            ->with('error', 'Your enrollment is not approved yet.');
    }

    return view('courses.content', compact('course'));
}



    // Edit course (ADMIN)
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    // Update course (ADMIN)
    public function update(Request $request, Course $course)
    {
        $course->update($request->all());

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully');
    }

    // Delete course (ADMIN)
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully');
    }
}
