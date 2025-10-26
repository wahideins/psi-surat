<?php

namespace App\Http\Controllers\Kelurahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirestoreServices;
use Kreait\Firebase\Auth as FirebaseAuth;
use Illuminate\Support\Facades\Session;

class DashboardKelurahan extends Controller
{
    protected $auth;
    protected $firestore;

    public function __construct(FirebaseAuth $auth, FirestoreServices $firestore)
    {
        $this->auth = $auth;
        $this->firestore = $firestore;
    }

    public function tampilkanHalaman()
    {
        $session = Session::get('user');

        if (!$session || empty($session->uid)) {
            return redirect()->route('login')->withErrors('Sesi pengguna tidak ditemukan.');
        }

        $uid = $session->uid;
        $biodata = $this->firestore->getUser($uid);

        return view('kelurahan.dashboardKelurahan', compact('biodata'));

    }
}
