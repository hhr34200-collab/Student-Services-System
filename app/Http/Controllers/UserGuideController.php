<?php

namespace App\Http\Controllers;

class UserGuideController extends Controller
{
    public function index()
    {
        return view('dashboard-student.user-guide');
    }
}