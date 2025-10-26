<?php

namespace App\Http\Controllers\Kelurahan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\FirestoreServices;
use Kreait\Firebase\Auth as FirebaseAuth;
use Illuminate\Support\Facades\Session;

class KelolaRTRWController extends Controller
{
    protected $auth;
    protected $firestore;

    public function __construct(FirebaseAuth $auth, FirestoreServices $firestore)
    {
        $this->auth = $auth;
        $this->firestore = $firestore;
    }

    public function index()
    {
        // Ambil semua user dari Firestore
        $warga = $this->firestore->getAllUsers();

        // Kirim ke view Blade
        return view('kelurahan.kelolaRTRW', compact('warga'));
    }

    public function cariWarga(Request $request)
    {
        $nama = $request->input('nama');
        $warga = $this->firestore->getAllUsers();

        // filter berdasarkan nama (jika ada input)
        if ($nama) {
            $warga = array_filter($warga, function ($user) use ($nama) {
                return isset($user['nama']) && stripos($user['nama'], $nama) !== false;
            });
        }

        $warga = array_values($warga);

        return response()->json($warga);
    }

public function simpanRTRW(Request $request)
{
    $data = $request->validate([
        'uid' => 'required',
        'nama' => 'required|string',
        'is_rt' => 'boolean',
        'is_rw' => 'boolean',
        'nomor_rt' => 'nullable|numeric',
        'nomor_rw' => 'nullable|numeric',
        'periode_mulai' => 'required|date',
        'periode_akhir' => 'required|date',
        'force' => 'boolean'
    ]);

    try {
        $messages = [];

        // === RT ===
        if ($data['is_rt'] && $data['nomor_rt']) {
            $cekRT = $this->firestore->cekRTRWExist('rt', $data['nomor_rt'], $data['periode_mulai'], $data['periode_akhir']);

            if ($cekRT['exists'] && empty($data['force'])) {
                return response()->json([
                    'confirm' => true,
                    'type' => 'rt',
                    'message' => 'Sudah ada RT untuk periode ini. Lanjutkan mengganti?',
                    'doc_id' => $cekRT['doc_id']
                ]);
            }

            if ($cekRT['exists'] && !empty($data['force'])) {
                // simpan ke riwayat dengan masa_berakhir lebih awal
                $riwayat = $cekRT['data'];
                $riwayat['masa_berakhir'] = now()->toDateString();
                $riwayat['digantikan_oleh'] = $data['nama'];
                $this->firestore->tambahRiwayatRTRW($riwayat);

                // hapus data lama
                $this->firestore->hapusRTRW('rt', $cekRT['doc_id']);
            }

            // simpan baru
            $this->firestore->simpanRt([
                'uid' => $data['uid'],
                'nama' => $data['nama'],
                'nomor_rt' => $data['nomor_rt'],
                'periode_mulai' => $data['periode_mulai'],
                'periode_akhir' => $data['periode_akhir'],
                'created_at' => now()->toDateTimeString(),
            ]);

            // catat ke riwayat juga
            $this->firestore->tambahRiwayatRTRW([
                'tipe' => 'rt',
                'uid' => $data['uid'],
                'nama' => $data['nama'],
                'nomor' => $data['nomor_rt'],
                'periode_mulai' => $data['periode_mulai'],
                'periode_akhir' => $data['periode_akhir'],
                'masa_berakhir' => null,
                'created_at' => now()->toDateTimeString()
            ]);

            $messages[] = 'Data RT berhasil disimpan.';
        }

        // === RW ===
        if ($data['is_rw'] && $data['nomor_rw']) {
            $cekRW = $this->firestore->cekRTRWExist('rw', $data['nomor_rw'], $data['periode_mulai'], $data['periode_akhir']);

            if ($cekRW['exists'] && empty($data['force'])) {
                return response()->json([
                    'confirm' => true,
                    'type' => 'rw',
                    'message' => 'Sudah ada RW untuk periode ini. Lanjutkan mengganti?',
                    'doc_id' => $cekRW['doc_id']
                ]);
            }

            if ($cekRW['exists'] && !empty($data['force'])) {
                $riwayat = $cekRW['data'];
                $riwayat['masa_berakhir'] = now()->toDateString();
                $riwayat['digantikan_oleh'] = $data['nama'];
                $this->firestore->tambahRiwayatRTRW($riwayat);

                $this->firestore->hapusRTRW('rw', $cekRW['doc_id']);
            }

            $this->firestore->simpanRw([
                'uid' => $data['uid'],
                'nama' => $data['nama'],
                'nomor_rw' => $data['nomor_rw'],
                'periode_mulai' => $data['periode_mulai'],
                'periode_akhir' => $data['periode_akhir'],
                'created_at' => now()->toDateTimeString(),
            ]);

            $this->firestore->tambahRiwayatRTRW([
                'tipe' => 'rw',
                'uid' => $data['uid'],
                'nama' => $data['nama'],
                'nomor' => $data['nomor_rw'],
                'periode_mulai' => $data['periode_mulai'],
                'periode_akhir' => $data['periode_akhir'],
                'masa_berakhir' => null,
                'created_at' => now()->toDateTimeString()
            ]);

            $messages[] = 'Data RW berhasil disimpan.';
        }

        return response()->json(['success' => true, 'message' => implode(' ', $messages)]);

    } catch (\Throwable $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}




}
