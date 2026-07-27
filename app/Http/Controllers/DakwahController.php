<?php

namespace App\Http\Controllers;

use App\Models\DakwahModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DakwahController extends Controller
{
    public function index(Request $request)
    {
        $query = DakwahModel::latest();

        // Filter live search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('mubaligh', 'like', '%' . $search . '%')
                    ->orWhere('tgl', 'like', '%' . $search . '%')
                    ->orWhere('isi', 'like', '%' . $search . '%');
            });
        }

        $dakwahs = $query->paginate(10)->withQueryString();

        return view('admin.dakwah.index', compact('dakwahs'));
    }

    public function create()
    {
        return view('admin.dakwah.tambah');
    }

    public function store(Request $request)
    {
        // 1. Validasi hanya untuk inputan yang dikirim dari form
        $validated = $request->validate([
            'mubaligh' => 'required',
            'tgl'      => 'required|date',
            'isi'      => 'required',
        ]);

        // 2. Berikan nilai otomatis "-" atau default untuk kolom form lain yang tidak ada
        $validated['judul']    = '-';
        $validated['kategori'] = '-';
        $validated['status']   = 'publish'; // Atau sesuaikan default status yang diinginkan ('publish' / 'draft')
        $validated['poster']   = '-';
        $validated['link_yt']  = null;

        // 3. Simpan ke database
        DakwahModel::create($validated);

        return redirect()->route('admin.dakwah.index')->with('success', 'Data pesan dakwah berhasil ditambah!');
    }

    public function edit($id)
    {
        $dakwah = DakwahModel::findOrFail($id);
        return view('admin.dakwah.edit', compact('dakwah'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'mubaligh' => 'required',
            'isi'      => 'required',
            'tgl'      => 'required|date',
            'status'   => 'nullable|in:draft,publish,arsip',
            'poster'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_yt'  => 'nullable|url'
        ]);

        $dakwah = DakwahModel::findOrFail($id);

        // Berikan nilai default otomatis untuk kolom yang tidak ada di form edit
        $validated['judul']    = '-';
        $validated['kategori'] = '-';

        if ($request->hasFile('poster')) {
            // Hapus poster lama
            if ($dakwah->poster && $dakwah->poster !== '-') {
                Storage::disk('public')->delete('foto_dakwah/' . $dakwah->poster);
            }
            // Upload baru
            $path = $request->file('poster')->store('foto_dakwah', 'public');
            $validated['poster'] = basename($path);
        }

        $dakwah->update($validated);
        return redirect()->route('admin.dakwah.index')->with('success', 'Data dakwah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $dakwah = DakwahModel::findOrFail($id);

        // Hapus file fisik
        if ($dakwah->poster) {
            Storage::disk('public')->delete('foto_dakwah/' . $dakwah->poster);
        }

        $dakwah->delete();
        return redirect()->route('admin.dakwah.index')->with('success', 'Data dakwah berhasil dihapus!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:publish,arsip,draft'
        ]);

        $dakwah = \App\Models\DakwahModel::findOrFail($id);
        $dakwah->status = $request->status;
        $dakwah->save();

        return redirect()->back()->with('success', 'Status dakwah berhasil diubah menjadi ' . $request->status);
    }
}
