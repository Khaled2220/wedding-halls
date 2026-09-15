<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Hall Manager
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'hall_manager') {
            return redirect()->route(
                'hall-manager.halls.index'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Customer
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'customer') {
            return redirect()->route(
                'customer.halls.index'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Worker
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'worker') {
            return redirect()->route(
                'worker.dashboard'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Default
        |--------------------------------------------------------------------------
        */

        return redirect('/');
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}