<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login admin (URL tersembunyi: /admin/login).
     */
    public function showLogin(): View|RedirectResponse
    {
        if (session('role') === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    /**
     * Proses login admin.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required'],
        ]);

        if ($request->input('password') !== 'admin123') {
            return back()->withErrors(['password' => 'Password admin salah.'])->withInput();
        }

        session(['role' => 'admin']);

        return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, Admin!');
    }

    /**
     * Logout dan kembali ke public dashboard.
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('role');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
