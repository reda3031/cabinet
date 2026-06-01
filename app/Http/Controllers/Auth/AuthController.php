<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        return view('auth.registration');
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                ->withSuccess('Vous êtes connecté avec succès');
        }

        return redirect('login')->withErrors(['email' => 'Identifiants invalides']);
    }

    public function postRegistration(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phone'    => 'nullable|string',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'patient',
            'phone'    => $request->phone,
        ]);

        Auth::attempt($request->only('email', 'password'));

        return redirect('dashboard')->withSuccess('Compte créé avec succès');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }
        return redirect('login')->withErrors(['email' => 'Accès refusé']);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('login');
    }
}