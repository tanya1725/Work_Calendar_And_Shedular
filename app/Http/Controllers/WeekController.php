<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;


class WeekController extends Controller
{
    public function index()
    {
        return inertia::render("WeekDaysTable");
    }
    
}

