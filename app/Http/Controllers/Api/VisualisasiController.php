<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class VisualisasiController extends Controller
{
    public function summary()
    {
        return response()->json(['status' => 'OK']);
    }
}
