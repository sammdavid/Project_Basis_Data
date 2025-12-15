<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VisualisasiController;

Route::get('/visualisasi/summary', [VisualisasiController::class, 'summary']);
Route::get('/visualisasi/trend-bulanan', [VisualisasiController::class, 'trendBulanan']);
Route::get('/visualisasi/kategori', [VisualisasiController::class, 'kategori']);
Route::get('/visualisasi/status', [VisualisasiController::class, 'status']);
Route::get('/visualisasi/response-time', [VisualisasiController::class, 'responseTime']);
