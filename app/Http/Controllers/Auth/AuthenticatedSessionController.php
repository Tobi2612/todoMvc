<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $client = new Client();

        $url = "https://todo-api-kahh.onrender.com/api/v1/auth/login";
        $response = $client->request('POST', $url, [
            'json' => [
                "email" => $request->email,
                "password" => $request->password
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            return abort(404);
        }

        $data = json_decode($response->getBody());

        $request->authenticate();

        $request->session()->regenerate();

        Session::put('todo_token', $data->token);


        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
