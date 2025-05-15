<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $courses = \App\Models\Course::latest()->take(6)->get();
        return view('dashboard', compact('courses'));
    }
}
