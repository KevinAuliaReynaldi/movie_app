<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * AuthController menangani otentikasi sederhana untuk aplikasi.
 * Catatan: Ini menggunakan pengguna hardcoded untuk tujuan demonstrasi.
 */
class AuthController extends Controller
{
    /**
     * Menampilkan form login.
     *
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Menangani permintaan login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // Cek otentikasi sederhana hardcoded
        if ($request->username === 'aldmic' && $request->password === '123abc123') {
            session(['authenticated' => true]);
            return redirect()->route('movies.index')
                ->with('success', __('messages.auth_success'));
        }

        return back()->with('error', __('messages.auth_failed'));
    }

    /**
     * Menangani permintaan logout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        session()->forget('authenticated');
        return redirect()->route('login')
            ->with('success', __('messages.auth_logout'));
    }
}
