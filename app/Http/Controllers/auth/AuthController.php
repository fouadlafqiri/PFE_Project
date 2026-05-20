<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        $user = User::where('email', $credentials['email'])->first();

        if ($user && !$this->isHashedPassword($user->password)) {
            if ($credentials['password'] === $user->password) {
                $user->password = Hash::make($credentials['password']);
                $user->save();
            } else {
                return back()->withErrors([
                    'email' => 'Les identifiants sont incorrects.',
                ]);
            }
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'livreur') {
                return redirect()->route('admin.orders.index');
            }

            return redirect()->route('home');
        }

        return back()->withErrors([
            'email' => 'Les identifiants sont incorrects.',
        ]);
    }

    private function isHashedPassword(string $password): bool
    {
        return Str::startsWith($password, ['\$2y\$', '\$2a\$', '\$2b\$', '$argon2i$', '$argon2id$']);
    }

    public function showRegister()
    {
        return view('auth.sign-up');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'nullable|string|max:20',
            'photo'    => 'nullable|image|max:2048',
            'password' => 'required|min:8|confirmed',
        ]);

        $userData = [
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ];

        if ($request->hasFile('photo')) {
            $photo      = $request->file('photo');
            $photoName  = time() . '_' . preg_replace('/[^A-Za-z0-9\-_\.]/', '_', $photo->getClientOriginalName());
            $uploadPath = public_path('uploads/profile_photos');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $photo->move($uploadPath, $photoName);
            $userData['photo'] = asset('uploads/profile_photos/' . $photoName);
        }

        $user = User::create($userData);

        Auth::login($user);

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
