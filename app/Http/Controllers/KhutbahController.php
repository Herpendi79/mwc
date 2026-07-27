<?php

namespace App\Http\Controllers;

use App\Models\KhutbahModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KhutbahController extends Controller
{
    public function index(Request $request)
    {
        $query = KhutbahModel::latest();

        // Filter live search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                    ->orWhere('khatib', 'like', '%' . $search . '%')
                    ->orWhere('masjid', 'like', '%' . $search . '%')
                    ->orWhere('ringkasan', 'like', '%' . $search . '%')
                    ->orWhere('tgl', 'like', '%' . $search . '%');
            });
        }

        $khutbahs = $query->paginate(10)->withQueryString();

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
        $mode = $request->input('mode_input', 'lengkap');

        // 1. Validasi dinamis berdasarkan mode
        if ($mode === 'file') {
            $validated = $request->validate([
                'judul'    => 'required',
                'lampiran' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ]);

            // Berikan nilai default ke kolom teks jika beralih ke mode file
            $validated['tema']      = '-';
            $validated['khatib']    = '-';
            $validated['masjid']    = '-';
            $validated['tgl']       = now()->toDateString();
            $validated['ringkasan'] = '-';
            $validated['isi']       = '-';
            $validated['poster']    = null;
        } else {
            $validated = $request->validate([
                'judul'     => 'required',
                'tema'      => 'required',
                'khatib'    => 'required',
                'masjid'    => 'required',
                'tgl'       => 'required|date',
                'ringkasan' => 'nullable',
                'isi'       => 'required',
                'poster'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'lampiran'  => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            ]);

            if (empty($validated['ringkasan'])) {
                $validated['ringkasan'] = '-';
            }
        }

        // 2. Update Poster (Hapus fisik lama jika ada file baru)
        if ($request->hasFile('poster')) {
            if ($khutbah->poster && Storage::disk('public')->exists('foto_khutbah/' . $khutbah->poster)) {
                Storage::disk('public')->delete('foto_khutbah/' . $khutbah->poster);
            }
            $filename = time() . '_' . $request->file('poster')->getClientOriginalName();
            $request->file('poster')->storeAs('foto_khutbah', $filename, 'public');
            $validated['poster'] = $filename;
        }

        // 3. Update Lampiran (Hapus fisik lama jika ada file baru)
        if ($request->hasFile('lampiran')) {
            if ($khutbah->lampiran && Storage::disk('public')->exists('file/' . $khutbah->lampiran)) {
                Storage::disk('public')->delete('file/' . $khutbah->lampiran);
            }
            $filename = time() . '_' . $request->file('lampiran')->getClientOriginalName();
            $request->file('lampiran')->storeAs('file', $filename, 'public');
            $validated['lampiran'] = $filename;
        }

        // 4. Simpan Perubahan ke Database
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
