<?php

namespace App\Http\Controllers;

use App\Services\FirestoreServices;

class TesFirestore extends Controller
{
    protected $firestore;

    public function __construct(FirestoreServices $firestore)
    {
        $this->firestore = $firestore;
    }

    public function index()
    {
        // ambil koleksi misalnya 'users'
        $users = $this->firestore->getCollection('users');

        // kirim ke blade
        return view('coba_firebase', compact('users'));
    }
}
