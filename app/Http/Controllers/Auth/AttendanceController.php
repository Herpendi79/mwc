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

class AttendanceController extends Controller
{
    /**
     * Menampilkan daftar konferensi (untuk Admin)
     */
    // Di AttendanceController.php

    public function search(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $email = $request->email;   

        // Cari di User
        $user = UserAdaksi::where('email', $email)->first();
        // Cari di UserIcpiphe (asumsi modelnya)
        $userIcpiphe = User::where('email', $email)->first();

        $data = null;
        $type = null;
        $id = null;

        // 1. Cari User Adaksi dan data pesertanya sekaligus
        $userAdaksi = UserAdaksi::where('email', $email)->first();
        if ($userAdaksi) {
            $data = PesertaConferencesAdaksi::with(['user.anggota', 'kategori'])
                ->where('id_user', $userAdaksi->id_user)
                ->first();
            $type = 'adaksi';
            $id = $userAdaksi->id_user;
        }

        // 2. Jika tidak ketemu di Adaksi, cari di ICPIPHE
        if (!$data) {
            $userIcpiphe = User::where('email', $email)->first();
            if ($userIcpiphe) {
                $data = PesertaConferences::with(['user', 'kategori'])
                    ->where('user_id', $userIcpiphe->id)
                    ->first();
                $type = 'icpiphe';
                $id = $userIcpiphe->id;
            }
        }

        // 3. Keamanan: Jika data tetap null, kembalikan dengan error
        if (!$data) {
            return back()->with('error', 'The email provided is not registered as a participant.');
        }

        return view('attendance', compact('data', 'type', 'email', 'id'));
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
