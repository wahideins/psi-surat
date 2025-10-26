<?php

namespace App\Http\Controllers\Akun;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirestoreServices;
use Kreait\Firebase\Auth as FirebaseAuth;
use Illuminate\Support\Facades\Session;

class MasukController extends Controller
{
    protected $auth;
    protected $firestore;

    public function __construct(FirebaseAuth $auth, FirestoreServices $firestore)
    {
        $this->auth = $auth;
        $this->firestore = $firestore; // ✅ Tambahkan ini agar tidak null
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
            // 🔹 Login ke Firebase
            $signInResult = $this->auth->signInWithEmailAndPassword(
                $credentials['email'],
                $credentials['password']
            );

            $firebaseUser = $this->auth->getUser($signInResult->firebaseUserId());

            // 🔹 Ambil biodata user dari Firestore
            $biodata = $this->firestore->getUser($firebaseUser->uid);

            // 🔹 Cek apakah email sudah diverifikasi
            if (!$firebaseUser->emailVerified) {
                return back()->withErrors([
                    'email' => 'Email belum diverifikasi. Silakan cek kotak masuk Anda.'
                ]);
            }

            // 🔹 Simpan data ke session
            Session::put('user', (object) [
                'uid' => $firebaseUser->uid,
                'email' => $firebaseUser->email,
                'name' => $biodata['nama'] ?? '(Tanpa Nama)',
                'role' => $biodata['role'] ?? 'unknown',
            ]);
            Session::save();

            $role = $biodata['role'];

            switch($role){
                case 'warga':
                    return redirect()->route('dashboardWarga')->with('success', 'Berhasil login!');
                    break;
                
                case 'rtrw':
                    return redirect()->route('dashboardRTRW')->with('success', 'Berhasil login!');
                    break;
                    
                case 'kelurahan':
                    return redirect()->route('dashboardKelurahan')->with('success', 'Berhasil login!');
                    break;

                default:
                    return redirect()->route('login')->with('error','Role Pengguna tidak ditemukan silahkan hubungi pihak yang berwajib');

            }

        } 
        catch (\Kreait\Firebase\Exception\Auth\InvalidPassword $e) {
            return back()->withErrors(['password' => 'Password salah.']);
        } 
        catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.']);
        } 
        catch (\Exception $e) {
            return back()->withErrors([
                'general' => 'Login gagal: ' . $e->getMessage()
            ]);
        }
    }

    public function logout()
    {
        Session::forget('user');
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}
