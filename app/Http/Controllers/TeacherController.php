<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class TeacherController extends Controller
{
    public function dashboard()
    {
        $courses = auth()->user()->teacherCourses ?? collect();
        return view('teacher.dashboard', compact('courses'));
    }
}
