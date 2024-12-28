<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;

class ScoreController extends Controller
{
    public function index()
    {
        // Ambil semua data dari model Score
        $data = Score::all();

        // Normalisasi data
        $normalizedData = $this->normalizeData($data);

        // Tampilkan data yang sudah dinormalisasi
        return view('data.score', ['normalizedData' => $normalizedData]);
    }

    // Menambahkan fungsi ini
    public function getNormalizedData()
    {
        // Ambil semua data dari model Score
        $data = Score::all();

        // Normalisasi data
        return $this->normalizeData($data);
    }

    private function normalizeData($data)
{
    // Menentukan nilai min dan max untuk setiap kolom
    $minMax = [];
    foreach ($data as $row) {
        foreach ($row->getAttributes() as $key => $value) {
            // Konversi nilai ke float
            $value = floatval($value);

            if (!isset($minMax[$key])) {
                $minMax[$key] = ['min' => $value, 'max' => $value];
            } else {
                if ($value < $minMax[$key]['min']) {
                    $minMax[$key]['min'] = $value;
                }
                if ($value > $minMax[$key]['max']) {
                    $minMax[$key]['max'] = $value;
                }
            }
        }
    }

    // Melakukan normalisasi
    $normalized = [];
    foreach ($data as $row) {
        $normalizedRow = [];
        foreach ($row->getAttributes() as $key => $value) {
            // Konversi nilai ke float
            $value = floatval($value);

            if (isset($minMax[$key]['min']) && isset($minMax[$key]['max']) && $minMax[$key]['max'] != $minMax[$key]['min']) {
                $normalizedValue = ($value - $minMax[$key]['min']) / ($minMax[$key]['max'] - $minMax[$key]['min']);
            } else {
                $normalizedValue = 0; // Atur ke 0 jika max dan min sama
            }
            $normalizedRow['normalized_' . $key] = $normalizedValue; // Menambahkan prefix 'normalized_'
        }
        $normalized[] = $normalizedRow;
    }

    return $normalized;


}

}
