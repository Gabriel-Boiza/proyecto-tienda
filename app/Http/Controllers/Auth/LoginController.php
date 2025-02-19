<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{

    $credentials = $request->only('email', 'password');


    if (Auth::attempt($credentials)) {

        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'Las credenciales no coinciden con nuestros registros.',
    ]);
}


    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
