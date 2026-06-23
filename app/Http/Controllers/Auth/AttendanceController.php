<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PesertaConferences;
use App\Models\Scope;
use App\Models\UserAdaksi;
use App\Models\PesertaConferencesAdaksi;
use App\Services\EmailApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Jobs\SendSubmissionEmail;
use Illuminate\Http\JsonResponse;

class AttendanceController extends Controller
{
    /**
     * Menampilkan daftar konferensi (untuk Admin)
     */
    // Di AttendanceController.php

    
    public function search(Request $request)
    {
        $request->validate(['email_or_wa' => 'required']);
        $input = $request->email_or_wa;

        $data = null;
        $type = null;
        $id = null;

        // 1. Cari di Adaksi
        // Menggunakan relasi jika perlu, atau langsung pada tabel users
        $userAdaksi = UserAdaksi::where('email', $input)
            ->orWhere('no_hp', $input)
            ->first();

        if ($userAdaksi) {
            $data = PesertaConferencesAdaksi::with(['user.anggota', 'kategori'])
                ->where('id_user', $userAdaksi->id_user)
                ->first();
            if ($data) {
                $type = 'adaksi';
                $id = $userAdaksi->id_user;
            }
        }

        // 2. Jika tidak ketemu di Adaksi, cari di ICPIPHE
        if (!$data) {
            // Kita cari melalui relasi User -> Peserta
            // Kita mencari user yang memiliki email tersebut ATAU peserta yang memiliki no_wa tersebut
            $userIcpiphe = User::where('email', $input)
                ->orWhereHas('peserta', function ($query) use ($input) {
                    $query->where('no_wa', $input);
                })
                ->first();

            if ($userIcpiphe) {
                $data = PesertaConferences::with(['user', 'kategori'])
                    ->where('user_id', $userIcpiphe->id)
                    ->first();
                if ($data) {
                    $type = 'icpiphe';
                    $id = $userIcpiphe->id;
                }
            }
        }

        if (!$data) {
            return back()->with('error', 'The data provided is not registered as a participant.');
        }

        return view('attendance', compact('data', 'type', 'input', 'id'))->with('email', $input);
    }
        

    public function autocomplete(Request $request): JsonResponse
    {
        $query = $request->get('q');
        if (strlen($query) < 3) return response()->json([]); // Cegah pencarian terlalu dini

        // Cari dari ADAKSI (Email & No HP)
        $adaksi = UserAdaksi::where('email', 'LIKE', "%{$query}%")
            ->orWhere('no_hp', 'LIKE', "%{$query}%")
            ->limit(5)->get(['email', 'no_hp']);

        // Cari dari ICPIPHE (Email & No WA dari relasi Peserta)
        $icpiphe = User::where('email', 'LIKE', "%{$query}%")
            ->orWhereHas('peserta', function ($q) use ($query) {
                $q->where('no_wa', 'LIKE', "%{$query}%");
            })
            ->limit(5)->get(['email']);

        $results = $adaksi->pluck('email')->merge($icpiphe->pluck('email'))->unique();

        return response()->json($results);
    }

    public function confirm(Request $request)
    {
        // Format string: "Hadir (11-06-2026 16:20:43)"
        $waktuHadir = 'Hadir (' . now()->format('d-m-Y H:i:s') . ')';

        if ($request->type == 'adaksi') {
            PesertaConferencesAdaksi::where('id_user', $request->id)
                ->update(['kehadiran' => $waktuHadir]);
        } else {
            PesertaConferences::where('user_id', $request->id)
                ->update(['kehadiran' => $waktuHadir]);
        }

        return redirect()->route('attendance')->with('success', 'Attendance Has Been Recorded. Thank you!');
        
    }
}
