<?php

use App\Http\Controllers\Auth\AttendanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\BahsulController;
use App\Http\Controllers\HalaqahController;
use App\Http\Controllers\KajianController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\MangroveController;
use App\Http\Controllers\SampahController;
use App\Http\Controllers\RoanController;
use App\Http\Controllers\RelawanController;
use App\Http\Controllers\BencanaController;
use App\Http\Controllers\DakwahController;
use App\Http\Controllers\FreeUserController;
use App\Http\Controllers\KhutbahController;
use App\Http\Controllers\OpiniController;
use App\Http\Controllers\BeritaController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

Route::get('/', [FreeUserController::class, 'index_free'])->name('index');
Route::get('/berita', [FreeUserController::class, 'beritaKegiatan'])->name('berita');
Route::get('/sedekah-sampah', [FreeUserController::class, 'sedekahSampah'])->name('sampah');
Route::post('/sedekah-sampah/simpan', [FreeUserController::class, 'storeSampah'])->name('sampah.simpan');
Route::get('/infaq-mangrove', [FreeUserController::class, 'infaqMangrove'])->name('mangrove');
Route::post('/infaq-mangrove/simpan', [FreeUserController::class, 'store'])->name('mangrove.simpan');
Route::get('/lapor-bencana', [FreeUserController::class, 'programBencana'])->name('bencana');
Route::post('/lapor-bencana/simpan', [FreeUserController::class, 'storeBencana'])->name('bencana.simpan');
Route::get('/relawan-banjir', [FreeUserController::class, 'programRelawan'])->name('relawan');
Route::post('/relawan-banjir/daftar/{id}', [FreeUserController::class, 'programRelawanDaftar'])->name('relawan.daftar');
Route::get('/relawan-banjir/{id}', [FreeUserController::class, 'programRelawanDetil'])->name('relawan.detil');
Route::get('/roan-bersih-pantai', [FreeUserController::class, 'programRoan'])->name('roan');
Route::get('/roan-bersih-pantai/{id}', [FreeUserController::class, 'programRoanDetil'])->name('roan.detil');
Route::post('/roan-bersih-pantai/daftar/{id}', [FreeUserController::class, 'programRoanDaftar'])->name('roan.daftar');
Route::get('/berita/detil/{id}', [FreeUserController::class, 'beritaKegiatanDetil'])->name('berita.detil');
Route::post('/berita/komentar/store/{id}', [FreeUserController::class, 'storeKomentar'])->name('berita.comment.store');
Route::get('/kajian-pengajian', [FreeUserController::class, 'beritaKajian'])->name('kajian');
Route::get('/kajian-pengajian/detil/{id}', [FreeUserController::class, 'kajianPengajianDetil'])->name('kajian.detil');
Route::get('/opini-umum', [FreeUserController::class, 'opiniWarga'])->name('opini_warga');
Route::get('/opini-umum/detil/{id}', [FreeUserController::class, 'opiniWargaDetil'])->name('opini.detil');
Route::get('/opini-umum/tulis', [FreeUserController::class, 'opiniCreate'])->name('opini.create');
Route::post('/opini-umum/tulis/simpan', [FreeUserController::class, 'opiniStoreFreeUser'])->name('opini.simpan.freeuser');
Route::get('/kajian-halaqah', [FreeUserController::class, 'kegiatanHalaqah'])->name('halaqah');
Route::get('/kajian-pesan-dakwah', [FreeUserController::class, 'kegiatanDakwah'])->name('dakwah');
Route::get('/kajian-bahsul-masail', [FreeUserController::class, 'kajianBahsul'])->name('bahsul');
Route::post('/kajian-bahsul-masail/daftar/{id}', [FreeUserController::class, 'kajianBahsulDaftar'])->name('bahsul.daftar');
Route::get('/kajian-bahsul-masail/detil/{id}', [FreeUserController::class, 'kajianBahsulDetil'])->name('bahsul.detil');
Route::get('/kajian-halaqah/detil/{id}', [FreeUserController::class, 'kajianHalaqahDetil'])->name('halaqah.detil');
Route::post('/kajian-halaqah/daftar/{id}', [FreeUserController::class, 'kajianHalaqahDaftar'])->name('halaqah.daftar');
Route::get('/khutbah-jumat', [FreeUserController::class, 'khutbahJumat'])->name('khutbah');
Route::get('/khutbah-jumat/detil/{id}', [FreeUserController::class, 'khutbahJumatDetil'])->name('khutbah.detil');
Route::get('/pesan-dakwah', [FreeUserController::class, 'pesanDakwah'])->name('pesan_dakwah');
Route::get('/infografis', [FreeUserController::class, 'infografisMWC'])->name('infografis');

Route::get('/kirim-bahtsul-masail', function () {
    return view('bahsul_kirim');
})->name('kirim');


Route::get('/roan', [AdminController::class, 'showRoan'])->name('roan.show');
Route::get('/relawan', [AdminController::class, 'showRelawan'])->name('relawan.show');
Route::get('/opini', [AdminController::class, 'showOpini'])->name('opini.show');
Route::get('/khutbah', [AdminController::class, 'showKhutbah'])->name('khutbah.show');
Route::get('/dakwah', [AdminController::class, 'showDakwah'])->name('dakwah.show');
Route::get('/detail-opini', [AdminController::class, 'detailOpini'])->name('opini.detail_opini');

Route::post('/registerPeserta', [RegisterController::class, 'register'])->name('registerPeserta.post');
Route::post('/reset-password', [ForgotPasswordController::class, 'sendResetPassword'])->name('auth.reset_password');


Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login'); // Ganti 'login' menjadi 'login' agar Laravel tidak bingung

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

Route::get('/blog-details', function () {
    return view('blog_details');
})->name('blog_details');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');


// Route Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'checkrole:admin'])->prefix('admin')->group(function () {
    // Semua route admin di sini
});

Route::middleware(['auth', 'checkrole:anggota'])->prefix('anggota')->group(function () {
    // Semua route anggota di sini
});

// Route untuk menampilkan halaman form (GET)
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Route untuk memproses pengiriman password baru (POST)
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetPassword'])->name('password.email');

// Gunakan prefix untuk mengelompokkan semua URL admin
Route::middleware(['auth'])->prefix('admin')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    //profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile.index');
    Route::get('/profile-setting', [AdminController::class, 'setting'])->name('admin.profile.setting');
    Route::post('/profile/rekening', [AdminController::class, 'updateRekening'])->name('admin.profile.updateRekening');
    Route::put('/profile/update-update-akses', [AdminController::class, 'updateAkses'])->name('admin.profile.updateAkses');
    Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::get('/kta', [AdminController::class, 'kta'])->name('admin.profile.kta');
    Route::get('/download-kta', [AdminController::class, 'downloadKta'])->name('admin.download_Kta');
    Route::post('/template-kta', [AdminController::class, 'updateTemplate'])->name('admin.update_template');

    //anggota
    Route::get('/anggota', [AdminController::class, 'anggota'])->name('admin.anggota.index');
    Route::put('/anggota/verifikasi/{id}', [AdminController::class, 'verifikasi'])->name('admin.anggota.verifikasi');
    Route::get('/anggota/tambah', [AdminController::class, 'create'])->name('admin.anggota.tambah');
    Route::post('/anggota/simpan', [AdminController::class, 'store'])->name('admin.anggota.simpan');

    //bahsul
    Route::get('/bahsul-masail', [BahsulController::class, 'index'])->name('admin.bahsul.index');
    Route::get('/bahsul-masail/tambah', [BahsulController::class, 'create'])->name('admin.bahsul.tambah');
    Route::post('/bahsul-masail/simpan', [BahsulController::class, 'store'])->name('admin.bahsul.simpan');
    Route::get('/bahsul-masail/edit/{id}', [BahsulController::class, 'edit'])->name('admin.bahsul.edit');
    Route::put('/bahsul-masail/update/{id}', [BahsulController::class, 'update'])->name('admin.bahsul.update');
    Route::delete('/bahsul-masail/hapus/{id}', [BahsulController::class, 'destroy'])->name('admin.bahsul.hapus');
    Route::patch('/bahsul-masail/status/{id}', [BahsulController::class, 'updateStatus'])->name('admin.bahsul.status');
    Route::post('/bahsul-masail/simpan-kategori', [BahsulController::class, 'storeKategori'])->name('admin.bahsul.storeKategori');

    //halaqah
    Route::get('/halaqah', [HalaqahController::class, 'index'])->name('admin.halaqah.index');
    Route::patch('/halaqah/{id}/status', [HalaqahController::class, 'updateStatus'])->name('admin.halaqah.updateStatus');
    Route::get('/halaqah/edit/{id}', [HalaqahController::class, 'edit'])->name('admin.halaqah.edit');
    Route::put('/halaqah/update/{id}', [HalaqahController::class, 'update'])->name('admin.halaqah.update');
    Route::delete('/halaqah/hapus/{id}', [HalaqahController::class, 'destroy'])->name('admin.halaqah.hapus');
    Route::get('/halaqah/tambah', [HalaqahController::class, 'create'])->name('admin.halaqah.tambah');
    Route::post('/halaqah/simpan', [HalaqahController::class, 'store'])->name('admin.halaqah.simpan');

    //pengajian
    Route::get('/pengajian', [KajianController::class, 'index'])->name('admin.kajian.index');
    Route::patch('/pengajian/{id}/status', [KajianController::class, 'updateStatus'])->name('admin.kajian.updateStatus');
    Route::get('/pengajian/tambah', [KajianController::class, 'create'])->name('admin.kajian.tambah');
    Route::post('/pengajian/simpan', [KajianController::class, 'store'])->name('admin.kajian.simpan');
    Route::get('/pengajian/edit/{id}', [KajianController::class, 'edit'])->name('admin.kajian.edit');
    Route::put('/pengajian/update/{id}', [KajianController::class, 'update'])->name('admin.kajian.update');
    Route::delete('/pengajian/hapus/{id}', [KajianController::class, 'destroy'])->name('admin.kajian.hapus');

    //mangrove
    Route::get('/mangrove', [MangroveController::class, 'index'])->name('admin.mangrove.index');
    Route::post('/mangrove/update-harga', [MangroveController::class, 'updateHarga'])->name('admin.mangrove.update-harga');
    Route::get('/mangrove/tambah', [MangroveController::class, 'create'])->name('admin.mangrove.tambah');
    Route::post('/mangrove/simpan', [MangroveController::class, 'store'])->name('admin.mangrove.simpan');
    Route::get('/mangrove/edit/{id}', [MangroveController::class, 'edit'])->name('admin.mangrove.edit');
    Route::put('/mangrove/update/{id}', [MangroveController::class, 'update'])->name('admin.mangrove.update');
    Route::delete('/mangrove/hapus/{id}', [MangroveController::class, 'destroy'])->name('admin.mangrove.hapus');
    Route::get('/download-sertifikat/{id}', [MangroveController::class, 'downloadSertifikat'])->name('admin.mangrove.download_Sertfikat');
    Route::post('/mangrove/update-sertifikat', [MangroveController::class, 'updateSertifikat'])->name('admin.mangrove.update_sertifikat_template');

    //sampah
    Route::get('/sedekah-sampah', [SampahController::class, 'index'])->name('admin.sampah.index');
    Route::get('/sedekah-sampah/create', [SampahController::class, 'create'])->name('admin.sampah.tambah');
    Route::post('/sedekah-sampah/store', [SampahController::class, 'store'])->name('admin.sampah.store');
    Route::get('/sedekah-sampah/edit/{id_sm}', [SampahController::class, 'edit'])->name('admin.sampah.edit');
    Route::put('/sedekah-sampah/update/{id_sm}', [SampahController::class, 'update'])->name('admin.sampah.update');
    Route::delete('/sedekah-sampah/hapus/{id_sm}', [SampahController::class, 'destroy'])->name('admin.sampah.hapus');

    // Route untuk Roan (Kerja Bakti)
    Route::get('/roan', [RoanController::class, 'index'])->name('admin.roan.index');
    Route::get('/roan/create', [RoanController::class, 'create'])->name('admin.roan.tambah');
    Route::post('/roan/store', [RoanController::class, 'store'])->name('admin.roan.store');
    Route::get('/roan/edit/{id_ro}', [RoanController::class, 'edit'])->name('admin.roan.edit');
    Route::put('/roan/update/{id_ro}', [RoanController::class, 'update'])->name('admin.roan.update');
    Route::delete('/roan/hapus/{id_ro}', [RoanController::class, 'destroy'])->name('admin.roan.hapus');

    // Relawan
    Route::get('/relawan', [RelawanController::class, 'index'])->name('admin.relawan.index');
    Route::get('/relawan/tambah', [RelawanController::class, 'create'])->name('admin.relawan.tambah');
    Route::post('/relawan/store', [RelawanController::class, 'store'])->name('admin.relawan.store');
    Route::get('/relawan/edit/{id}', [RelawanController::class, 'edit'])->name('admin.relawan.edit');
    Route::put('/relawan/update/{id}', [RelawanController::class, 'update'])->name('admin.relawan.update');
    Route::delete('/relawan/hapus/{id}', [RelawanController::class, 'destroy'])->name('admin.relawan.hapus');

    // Bencana
    Route::get('/lapor-bencana', [BencanaController::class, 'index'])->name('admin.bencana.index');
    Route::get('/lapor-bencana/tambah', [BencanaController::class, 'create'])->name('admin.bencana.tambah');
    Route::post('/lapor-bencana/store', [BencanaController::class, 'store'])->name('admin.bencana.store');
    Route::get('/lapor-bencana/edit/{id}', [BencanaController::class, 'edit'])->name('admin.bencana.edit');
    Route::put('/lapor-bencana/update/{id}', [BencanaController::class, 'update'])->name('admin.bencana.update');
    Route::delete('/lapor-bencana/hapus/{id}', [BencanaController::class, 'destroy'])->name('admin.bencana.hapus');
    Route::post('/lapor-bencana/verifikasi/{id}', [BencanaController::class, 'verifikasi'])->name('admin.bencana.verifikasi');

    // Pesan Dakwah
    Route::get('/pesan-dakwah', [DakwahController::class, 'index'])->name('admin.dakwah.index');
    Route::get('/pesan-dakwah/tambah', [DakwahController::class, 'create'])->name('admin.dakwah.tambah');
    Route::post('/pesan-dakwah/store', [DakwahController::class, 'store'])->name('admin.dakwah.store');
    Route::get('/pesan-dakwah/edit/{id}', [DakwahController::class, 'edit'])->name('admin.dakwah.edit');
    Route::put('/pesan-dakwah/update/{id}', [DakwahController::class, 'update'])->name('admin.dakwah.update');
    Route::delete('/pesan-dakwah/hapus/{id}', [DakwahController::class, 'destroy'])->name('admin.dakwah.hapus');
    Route::patch('/pesan-dakwah/update-status/{id}', [DakwahController::class, 'updateStatus'])->name('admin.dakwah.updateStatus');

    // Khutbah Jumat
    Route::get('/khutbah-jumat', [KhutbahController::class, 'index'])->name('admin.khutbah.index');
    Route::get('/khutbah-jumat/tambah', [KhutbahController::class, 'create'])->name('admin.khutbah.tambah');
    Route::post('/khutbah-jumat/store', [KhutbahController::class, 'store'])->name('admin.khutbah.store');
    Route::get('/khutbah-jumat/edit/{id}', [KhutbahController::class, 'edit'])->name('admin.khutbah.edit');
    Route::put('/khutbah-jumat/update/{id}', [KhutbahController::class, 'update'])->name('admin.khutbah.update');
    Route::delete('/khutbah-jumat/hapus/{id}', [KhutbahController::class, 'destroy'])->name('admin.khutbah.hapus');
    Route::patch('/khutbah-jumat/update-status/{id}', [KhutbahController::class, 'updateStatus'])->name('admin.khutbah.updateStatus');

    // Opini
    Route::get('/opini', [OpiniController::class, 'index'])->name('admin.opini.index');
    Route::get('/opini/tambah', [OpiniController::class, 'create'])->name('admin.opini.tambah');
    Route::post('/opini/store', [OpiniController::class, 'store'])->name('admin.opini.store');
    Route::get('/opini/edit/{id}', [OpiniController::class, 'edit'])->name('admin.opini.edit');
    Route::put('/opini/update/{id}', [OpiniController::class, 'update'])->name('admin.opini.update');
    Route::delete('/opini/hapus/{id}', [OpiniController::class, 'destroy'])->name('admin.opini.hapus');
    Route::patch('/opini/update-status/{id}', [OpiniController::class, 'updateStatus'])->name('admin.opini.updateStatus');
    Route::post('/opini/simpan-kategori', [OpiniController::class, 'storeKategori'])->name('admin.opini.storeKategori');

    // berita
    Route::get('/berita', [BeritaController::class, 'index'])->name('admin.berita.index');
    Route::get('/berita/tambah', [BeritaController::class, 'create'])->name('admin.berita.tambah');
    Route::get('/berita/detil/{id}', [BeritaController::class, 'beritaKegiatanDetil'])
        ->name('admin.berita.detil')
        ->middleware('auth');
    Route::post('/berita/komentar/reply/{id}', [BeritaController::class, 'replyKomentar'])->name('admin.berita.comment.reply');
    Route::post('/berita/store', [BeritaController::class, 'store'])->name('admin.berita.store');
    Route::get('/berita/edit/{id}', [BeritaController::class, 'edit'])->name('admin.berita.edit');
    Route::put('/berita/update/{id}', [BeritaController::class, 'update'])->name('admin.berita.update');
    Route::delete('/berita/hapus/{id}', [BeritaController::class, 'destroy'])->name('admin.berita.hapus');
    Route::patch('/berita/update-status/{id}', [BeritaController::class, 'updateStatus'])->name('admin.berita.updateStatus');
    Route::post('/berita/simpan-kategori', [BeritaController::class, 'storeKategori'])->name('admin.berita.storeKategori');
});

Route::middleware(['auth'])->prefix('anggota')->group(
    function () {

        Route::get('/', [AnggotaController::class, 'index'])->name('anggota.index');

        Route::get('/profile', [AnggotaController::class, 'profile'])->name('anggota.profile.index');
        Route::get('/profile-setting', [AnggotaController::class, 'setting'])->name('anggota.profile.setting');
        Route::put('/profile/update-update-akses', [AnggotaController::class, 'updateAkses'])->name('anggota.profile.updateAkses');
        Route::put('/profile/update', [AnggotaController::class, 'updateProfile'])->name('anggota.profile.update');
        Route::get('/kta', [AnggotaController::class, 'kta'])->name('anggota.profile.kta');
        Route::get('/download-kta', [AnggotaController::class, 'downloadKta'])->name('anggota.download_Kta');

        //bahsul
        Route::get('/bahsul-masail', [BahsulController::class, 'index_anggota'])->name('anggota.bahsul.index');
        Route::get('/bahsul-masail/tambah', [BahsulController::class, 'create_anggota'])->name('anggota.bahsul.tambah');
        Route::post('/bahsul-masail/simpanUsulan', [BahsulController::class, 'store_anggota'])->name('anggota.bahsul.simpan');
        Route::post('/bahsul-masail/simpan', [BahsulController::class, 'store_free_user'])->name('anggota.bahsul.simpan.freeuser');
        Route::get('/bahsul-masail/edit/{id}', [BahsulController::class, 'edit_anggota'])->name('anggota.bahsul.edit');
        Route::put('/bahsul-masail/update/{id}', [BahsulController::class, 'update_anggota'])->name('anggota.bahsul.update');
        Route::delete('/bahsul-masail/hapus/{id}', [BahsulController::class, 'destroy_anggota'])->name('anggota.bahsul.hapus');
        Route::get('/bahsul-masail/daftar/{id}', [BahsulController::class, 'daftar'])->name('anggota.bahsul.daftar');

        //halaqah
        Route::get('/halaqah', [HalaqahController::class, 'index_anggota'])->name('anggota.halaqah.index');
        Route::get('/halaqah/daftar/{id}', [HalaqahController::class, 'daftar'])->name('anggota.halaqah.daftar');

        //pengajian
        Route::get('/pengajian', [KajianController::class, 'index_anggota'])->name('anggota.kajian.index');

        //mangrove
        Route::get('/mangrove', [MangroveController::class, 'index_anggota'])->name('anggota.mangrove.index');
        Route::get('/mangrove/tambah', [MangroveController::class, 'create_anggota'])->name('anggota.mangrove.tambah');
        Route::post('/mangrove/simpan', [MangroveController::class, 'storeInfaq'])->name('anggota.mangrove.simpan');
        Route::get('/download-sertifikat/{id}', [MangroveController::class, 'downloadSertifikat'])->name('anggota.mangrove.download_Sertfikat');

        //sampah
        Route::get('/sedekah-sampah', [SampahController::class, 'index_anggota'])->name('anggota.sampah.index');
        Route::get('/sedekah-sampah/create', [SampahController::class, 'create_anggota'])->name('anggota.sampah.tambah');
        Route::post('/sedekah-sampah/store', [SampahController::class, 'storeSampah'])->name('anggota.sampah.store');

        // Route untuk Roan (Kerja Bakti)
        Route::get('/roan', [RoanController::class, 'index_anggota'])->name('anggota.roan.index');
        Route::get('/roan/daftar/{id}', [RoanController::class, 'daftar'])->name('anggota.roan.daftar');

        // Relawan
        Route::get('/relawan', [RelawanController::class, 'index_anggota'])->name('anggota.relawan.index');
        Route::get('/relawan/daftar/{id}', [RelawanController::class, 'daftar'])->name('anggota.relawan.daftar');

        // Bencana
        Route::get('/lapor-bencana', [BencanaController::class, 'index_anggota'])->name('anggota.bencana.index');
        Route::get('/lapor-bencana/tambah', [BencanaController::class, 'create_bencana'])->name('anggota.bencana.tambah');
        Route::post('/lapor-bencana/store', [BencanaController::class, 'storeBencana'])->name('anggota.bencana.store');

        Route::get('/lapor-bencana/edit/{id}', [BencanaController::class, 'edit'])->name('anggota.bencana.edit');
        Route::put('/lapor-bencana/update/{id}', [BencanaController::class, 'update'])->name('anggota.bencana.update');
        Route::delete('/lapor-bencana/hapus/{id}', [BencanaController::class, 'destroy'])->name('anggota.bencana.hapus');

        // Opini
        Route::get('/opini', [OpiniController::class, 'index_anggota'])->name('anggota.opini.index');
        Route::get('/opini/tambah', [OpiniController::class, 'create_anggota'])->name('anggota.opini.tambah');
        Route::post('/opini/store', [OpiniController::class, 'store_anggota'])->name('anggota.opini.store');
        Route::get('/opini/edit/{id}', [OpiniController::class, 'edit_anggota'])->name('anggota.opini.edit');
        Route::put('/opini/update/{id}', [OpiniController::class, 'update_anggota'])->name('anggota.opini.update');
        Route::delete('/opini/hapus/{id}', [OpiniController::class, 'destroy_anggota'])->name('anggota.opini.hapus');
        Route::patch('/opini/update-status/{id}', [OpiniController::class, 'updateStatus'])->name('anggota.opini.updateStatus');
    }
);

// Route untuk Social Login
Route::get('/auth-google-redirect', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth-google-callback', [GoogleController::class, 'handleGoogleCallback']);
