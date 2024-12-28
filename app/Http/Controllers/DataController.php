<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class DataController extends Controller
{
    public function data_asli()
    {
        // Ambil semua data dari model Score
        $scores = Score::all();

        // Kembalikan view dengan data
        return view('data.data_asli', ['scores' => $scores]);
    }
}
