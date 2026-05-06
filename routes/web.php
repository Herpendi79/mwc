<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('index');
});

Route::get('/schedule', function () {
    return view('schedule');
})->name('schedule');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/opening-speech', function () {
    return view('opening-speech');
})->name('opening-speech');

Route::get('/speaker', function () {
    return view('speaker');
})->name('speaker');

Route::post('/contact-submit', function () {
    return back()->with('success', 'Thank you for your inquiry!');
})->name('contact.submit');

Route::get('/important-dates', function () {
    return view('important-dates');
})->name('important-dates');

Route::get('/submission-information', function () {
    return view('submission-information');
})->name('submission-information');

Route::get('/virtual-conference-instruction', function () {
    return view('virtual-conference-instruction');
})->name('virtual-conference-instruction');

Route::get('/registration-fee', function () {
    return view('registration-fee');
})->name('registration-fee');

Route::get('/commitee', function () {
    return view('commitee');
})->name('commitee');

Route::get('/schedule', function () {
    return view('schedule');
})->name('schedule');

Route::get('/venue', function () {
    return view('venue');
})->name('venue');

Route::get('/poster', function () {
    return view('poster');
})->name('poster');

Route::get('/virtual-background', function () {
    return view('virtual-background');
})->name('virtual-background');

Route::get('/best-presenter', function () {
    return view('best-presenter');
})->name('best-presenter');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login'); // Ganti 'login' menjadi 'login' agar Laravel tidak bingung

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

// Route Registrasi
// Berikan nama pada route
Route::post('/registerPeserta', [RegisterController::class, 'register'])->name('registerPeserta.post');

// Halaman pemberitahuan setelah daftar
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Eksekusi ketika link di email diklik
Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    // Setelah sukses klik link, status di tabel peserta harus diupdate (opsional tapi disarankan)
    \App\Models\Peserta::where('user_id', $request->user()->id)->update(['status' => 'valid']);

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Route untuk menangani pengiriman ulang (Sekarang diarahkan ke Controller)
Route::post('/email/verification-notification', [RegisterController::class, 'resend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// Route untuk eksekusi verifikasi saat link diklik
Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();

    // Update status di tabel peserta menjadi valid
    \App\Models\Peserta::where('user_id', $request->user()->id)->update(['status' => 'valid']);

    return redirect('/login')->with('success', 'Email verified successfully!');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Route Login
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// Route untuk menampilkan halaman form (GET)
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Route untuk memproses pengiriman password baru (POST)
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetPassword'])->name('password.email');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route Dashboard yang sudah ada
    Route::get('/participants', [PesertaController::class, 'index'])->name('participants.index');

    // Route Profile Settings
    Route::get('/participants/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/participants/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/participants/submit/{id_conf}', [PesertaController::class, 'submitForm'])->name('participants.submit');
    // Memproses Data
    Route::post('/participants/submit/store', [PesertaController::class, 'storeSubmission'])->name('participants.submit.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/participants', [PesertaController::class, 'index'])->name('participants.index');
    // Rute halaman daftar konferensi
    Route::get('/participants/conferences', [PesertaController::class, 'conferences'])->name('participants.conferences');
});

Route::middleware(['auth'])->group(function () {
    // Menampilkan halaman upload revisi
    Route::get('/participants/revision-abstract/{id_pc}', [PesertaController::class, 'editRevision'])->name('participants.revision.edit');

    // Memproses file revisi
    Route::post('/participants/revision-abstract/{id_pc}', [PesertaController::class, 'updateRevision'])->name('participants.revision.update');
});

Route::middleware(['auth'])->group(function () {
    // Rute untuk memproses upload Full Article
    Route::post('/participants/upload-article/{id_pc}', [PesertaController::class, 'uploadArticle'])->name('participants.article.upload');
});

// Route untuk Social Login
Route::get('/auth-google-redirect', [GoogleController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth-google-callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('submit/payment/{snapToken}', function ($snapToken) {
    // Load data dengan relasi peserta
    $anggota = \App\Models\PesertaConferences::with(['kategori.conference', 'peserta'])
        ->where('snap', $snapToken)
        ->firstOrFail();

    // PERBAIKAN LOGIKA KEAMANAN:
    // Kita ambil ID Peserta dari user yang sedang login
    $currentPesertaId = Auth::user()->peserta->id ?? null;

    // Bandingkan ID Peserta yang login dengan ID Peserta pemilik invoice
    if ($currentPesertaId !== $anggota->id) {
        Log::warning("Akses ditolak: User " . Auth::id() . " mencoba mengakses invoice Peserta " . $anggota->id);
        abort(403, 'Unauthorized action. This invoice does not belong to you.');
    }

    return view('participants.payment', [
        'snapToken'      => $snapToken,
        'status_payment' => $anggota->payment,
        'biaya'          => $anggota->kategori->fee ?? 0,
        'nama'           => $anggota->peserta?->nama ?? 'Participant',
        'conference'     => $anggota->kategori->conference,
    ]);
})->middleware(['auth'])->name('payment');
