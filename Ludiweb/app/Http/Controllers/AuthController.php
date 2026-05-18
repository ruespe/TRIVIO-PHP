<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct(protected ApiService $api) {}

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $response = $this->api->login($request->only('email', 'password'));

        if ($response->successful()) {
            $data = $response->json();
            Session::put('api_token', $data['token']);
            Session::put('api_user', $data['user']);
            return redirect()->route('home')
                ->with('success', 'Sessió iniciada correctament');
        }

        return back()->withErrors(['email' => $response->json('message', 'Credencials incorrectes')]);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        $response = $this->api->register($request->only(
            'name', 'email', 'password', 'password_confirmation'
        ));

        if ($response->successful()) {
            $data = $response->json();
            Session::put('api_token', $data['token']);
            Session::put('api_user', $data['user']);
            return redirect()->route('home')
                ->with('success', 'Compte creat i sessió iniciada');
        }

        return back()->withErrors($response->json('errors', []))->withInput();
    }

    public function logout(Request $request)
    {
        $this->api->logout();
        Session::forget(['api_token', 'api_user']);
        return redirect()->route('home')
            ->with('success', 'Sessió tancada correctament');
    }
}
