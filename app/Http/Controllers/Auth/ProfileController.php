<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Peserta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('participants.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'country'  => 'required|string|max:100',
            'whatsapp' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update Tabel users_iciphe
            $user->name = $request->name;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            // 2. Update Tabel peserta
            Peserta::where('user_id', $user->id)->update([
                'nama'     => $request->name,
                'negara'   => $request->country,
                'no_wa'    => $request->whatsapp,
            ]);

            DB::commit();
            return back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}
