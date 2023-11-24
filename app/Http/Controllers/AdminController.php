<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AdminController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view ('auth.login');
    }


    // public function adminLogin() {
    //     return view ('fronts.adminLogin');
    // }
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $admins = Admin::where('email', $request->input('email'))->first();

        if ($admins) {
            if (Hash::check($request->input('password'), $admins->password)) {
                $request->session()->put('admins', $admins);
                return redirect()->route('adminDashboard');
            } else {
                return ('status \'Identifiants incorrects');
            }
        } else {
            return redirect()->back()->with('sessions', 'identifiants incorrects');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
