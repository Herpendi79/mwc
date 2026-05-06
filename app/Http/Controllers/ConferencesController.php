<?php

namespace App\Http\Controllers;

use App\Models\Conferences;
use Illuminate\Http\Request;

class ConferencesController extends Controller
{
    /**
     * Menampilkan daftar konferensi (untuk Admin)
     */
    public function index()
    {
        $conferences = Conferences::all();
        return view('admin.conferences.index', compact('conferences'));
    }

    /**
     * Menyimpan data konferensi baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_conf' => 'required|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
            'deadline_subm' => 'required|date|before:tgl_mulai',
            'link_zoom' => 'nullable|url',
        ]);

        Conferences::create($validated);

        return redirect()->back()->with('success', 'Conference scheduled successfully!');
    }

    /**
     * Mengupdate data konferensi
     */
    public function update(Request $request, $id)
    {
        $conferences = Conferences::findOrFail($id);

        $validated = $request->validate([
            'nama_conf' => 'required|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date',
            'deadline_subm' => 'required|date',
            'link_zoom' => 'nullable|url',
        ]);

        $conferences->update($validated);

        return redirect()->back()->with('success', 'Conference details updated!');
    }
}
