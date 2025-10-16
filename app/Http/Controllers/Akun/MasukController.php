<?php


namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth as FirebaseAuth;
use Illuminate\Support\Facades\Session;

class MasukController extends Controller
{
    protected $auth;

    public function __construct(FirebaseAuth $auth)
    {
        $this->auth = $auth;
    }

    public function tampilkanForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        try {
            $signInResult = $this->auth->signInWithEmailAndPassword($credentials['email'], $credentials['password']);
            $firebaseUser = $this->auth->getUser($signInResult->firebaseUserId());

            // Cek apakah email sudah diverifikasi
            if (!$firebaseUser->emailVerified) {
                return back()->withErrors(['email' => 'Email belum diverifikasi. Silakan cek kotak masuk Anda.']);
            }

            // Simpan session user
            Session::put('user', [
                'uid' => $firebaseUser->uid,
                'email' => $firebaseUser->email,
                'name' => $firebaseUser->displayName ?? '',
            ]);

            return redirect()->route('dashboard');
        } catch (\Kreait\Firebase\Exception\Auth\InvalidPassword $e) {
            return back()->withErrors(['password' => 'Password salah.']);
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.']);
        } catch (\Exception $e) {
            return back()->withErrors(['general' => 'Login gagal: ' . $e->getMessage()]);
        }
    }

    public function logout()
    {
        Session::forget('user');
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
