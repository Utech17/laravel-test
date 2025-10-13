<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Muestra la vista del dashboard.
     */
    public function index()
    {
        return view('dashboard'); // Esto buscará resources/views/dashboard.blade.php
    }
}