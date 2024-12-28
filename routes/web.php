<?php

use App\Http\Controllers\DistributionController;
use App\Http\Controllers\NewDistributionController;
use App\Http\Controllers\DataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\HomeController;
use App\Models\Score;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/Dataasli', [DataController::class, 'data_asli'])->name('data.asli');

// Rute untuk NilaiController
Route::get('/Pengolahandata', [NilaiController::class, 'nilai'])->name('data.nilai');

Route::get('/Normalisasi', [ScoreController::class, 'index'])->name('data.score');

Route::get('/Penyajian/kumulatif', [DistributionController::class, 'index'])->name('data.distribution');

Route::get('/Penyajian/relatif', [NewDistributionController::class, 'index'])->name('data.new');
