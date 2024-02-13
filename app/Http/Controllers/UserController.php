<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function user()
    {
        // dd(session());
        if (session('user')) {
        } else {
            return route('user');
        }
    }

    public function signIn(Request $userData)
    {
        $validate = $userData->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:32|regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{6,32}$/',
        ]);

        if (Auth::attempt($userData->only('email', 'password'))) {
            return redirect('user');
        }

        return back()->withInput()->withErrors([
            'null' => 'Неверные данные'
        ]);
    }
    public function signUp(Request $userData)
    {
        $validate = $userData->validate([
            'login' => 'required|regex:/^[A-Za-z0-9_]{3,16}$/|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|max:32|confirmed|regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).{6,32}$/',
            'pdata' => 'required'
        ]);

        $user = User::create([
            'login' => $userData->login,
            'email' => $userData->email,
            'role' => 3,
            'password' => $userData->password,
            'banned' => 0
        ]);

        Auth::login($user);

        return redirect(route('user'));
    }

    public function logOut(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function changeBalance(Request $request)
    {
        // dd($request);
        $request->validate([
            'money' => 'required|numeric|min:1',
        ]);
    
        $user = Auth::user();
        $user->update([
            'balance' => $user->balance + $request->money,
        ]);
    
        return redirect()->route('user')->with('success', 'Баланс успешно обновлен.');
    }

}
