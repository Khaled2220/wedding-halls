<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class WorkerController extends Controller
{
    /**
     * Worker Dashboard
     */
    public function dashboard(): View
    {
        return view('worker.dashboard');
    }
}