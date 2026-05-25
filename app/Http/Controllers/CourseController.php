<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function index(): View
    {
        $courses = Course::query()
            ->where('is_active', true)
            ->orderBy('price')
            ->get();

        return view('courses.index', compact('courses'));
    }

    public function show(Course $course): View
    {
        abort_unless($course->is_active, 404);

        return view('courses.show', compact('course'));
    }
}
