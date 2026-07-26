<?php

namespace App\Http\Controllers;

use App\Models\KhutbahModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KhutbahController extends Controller
{
    public function index()
    {
        $khutbahs = KhutbahModel::latest()->get();
        return view('admin.khutbah.index', compact('khutbahs'));
    }

    public function create()
    {
        return view('admin.khutbah.tambah');
    }

    public function store(Request $request)
    {
        $mode = $request->input('mode_input', 'lengkap');

        // 1. Validasi dinamis berdasarkan mode yang dipilih
        if ($mode === 'file') {
            $validated = $request->validate([
                'judul'    => 'required', // Berfungsi sebagai nama file
                'lampiran' => 'required|file|mimes:pdf,doc,docx|max:5120',
            ]);

            // Isi otomatis kolom lain yang tidak ada dengan tanda '-' atau default
            $validated['tema']      = '-';
            $validated['khatib']    = '-';
            $validated['masjid']    = '-';
            $validated['tgl']       = now()->toDateString();
            $validated['ringkasan'] = '-';
            $validated['isi']       = '-';
            $validated['poster']    = null;
        } else {
            // Mode Lengkap
            $validated = $request->validate([
                'judul'     => 'required',
                'tema'      => 'required',
                'khatib'    => 'required',
                'masjid'    => 'required',
                'tgl'       => 'required|date',
                'ringkasan' => 'nullable', // Sesuaikan jika ingin wajib, gunakan 'required'
                'isi'       => 'required',
                'poster'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'lampiran'  => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ]);

            // Pastikan ringkasan tidak kosong jika di database sifatnya wajib (berikan '-')
            if (empty($validated['ringkasan'])) {
                $validated['ringkasan'] = '-';
            }
        }

        // 2. Upload Poster
        if ($request->hasFile('poster')) {
            $filename = time() . '_' . $request->file('poster')->getClientOriginalName();
            $request->file('poster')->storeAs('foto_khutbah', $filename, 'public');
            $validated['poster'] = $filename;
        }

        // 3. Upload Lampiran
        if ($request->hasFile('lampiran')) {
            $filename = time() . '_' . $request->file('lampiran')->getClientOriginalName();
            $request->file('lampiran')->storeAs('file', $filename, 'public');
            $validated['lampiran'] = $filename;
        }

        // 4. Simpan ke Database
        KhutbahModel::create($validated);

        return redirect()->route('admin.khutbah.index')->with('success', 'Khutbah berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $khutbah = KhutbahModel::findOrFail($id);
        return view('admin.khutbah.edit', compact('khutbah'));
    }

    public function update(Request $request, $id)
    {
        $khutbah = KhutbahModel::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required',
            'tema' => 'required',
            'khatib' => 'required',
            'masjid' => 'required',
            'tgl' => 'required|date',
            'ringkasan' => 'required',
            'isi' => 'required',
            'poster' => 'image|mimes:jpeg,png,jpg|max:2048',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:5120'
        ]);

        // Update Poster
        if ($request->hasFile('poster')) {
            if ($khutbah->poster) Storage::delete('public/foto_khutbah/' . $khutbah->poster);
            $filename = time() . '_' . $request->file('poster')->getClientOriginalName();
            $request->file('poster')->storeAs('foto_khutbah', $filename, 'public');
            $validated['poster'] = $filename;
        }

        // Update Lampiran
        if ($request->hasFile('lampiran')) {
            if ($khutbah->lampiran) Storage::delete('public/file/' . $khutbah->lampiran);
            $filename = time() . '_' . $request->file('lampiran')->getClientOriginalName();
            $request->file('lampiran')->storeAs('file', $filename, 'public');
            $validated['lampiran'] = $filename;
        }

        $khutbah->update($validated);

        return redirect()->route('admin.khutbah.index')->with('success', 'Khutbah berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $khutbah = KhutbahModel::findOrFail($id);

        if ($khutbah->poster) Storage::delete('public/foto_khutbah/' . $khutbah->poster);
        if ($khutbah->lampiran) Storage::delete('public/file/' . $khutbah->lampiran);

        $khutbah->delete();

        return redirect()->route('admin.khutbah.index')->with('success', 'Khutbah berhasil dihapus.');
    }
}
