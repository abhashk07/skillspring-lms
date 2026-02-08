<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEnrollment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
{
    $courseId = $request->route('id');

    $enrolled = \App\Models\Enrollment::where([
        'user_id' => auth()->id(),
        'course_id' => $courseId
    ])->exists();

    if (!$enrolled) {
        return redirect('/courses')->with('error', 'Access denied');
    }

    return $next($request);
}

}
