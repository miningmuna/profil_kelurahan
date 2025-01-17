<?php

namespace App\Http\Controllers;

use App\Models\Lkk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class UserController extends Controller
{
    //
    public function loginView()
    {
        return view('login');
    }
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'fail' => 'username or password is wrong!',
        ])->onlyInput('email');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function show()
    {
        return view('user.index', [
            'users' => User::where('id', '!=', auth()->id())->get(),

        ]);
    }
    public function addView()
    {
        return view('user.add', ['lkks' => Lkk::all()]);
    }
    public function add(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'lkk' => ['required'],
            'password' => ['required'],
        ]);
        // dd($request->lkk);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'lkk_id' => $request->lkk,
            'password' => Hash::make($request->password),
        ]);
    }
    public function updateView($id)
    {
        return view('user.update', ['user' => User::findOrFail($id), 'lkks' => Lkk::all()]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'lkk' => ['required']
        ]);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->lkk_id = $request->lkk;
        $user->save();
    }
    public function delete($id)
    {
        User::findOrFail($id)->delete();
    }
}
