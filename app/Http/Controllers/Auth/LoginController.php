<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/candidatos');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nick' => 'required|string',
            'pass' => 'required|string',
        ]);

        $user = User::where('nick', $credentials['nick'])->first();

        if ($user && Hash::check($credentials['pass'], $user->pass)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->intended('/candidatos');
        }

        return back()->withErrors([
            'nick' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->withInput($request->except('pass'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
