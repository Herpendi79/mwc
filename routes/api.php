<?php

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PesertaController;
use Illuminate\Support\Facades\Route;


Route::post('/midtrans-callback', function (\Illuminate\Http\Request $request) {
    Log::info('Raw midtrans callback', $request->all());
    return response()->json(['ok']);
});


Route::post('/midtrans-callback', [PesertaController::class, 'callback']);



