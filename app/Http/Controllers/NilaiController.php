<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use Maatwebsite\Excel\Facades\Excel;


class NilaiController extends Controller
{
    public function nilai()
{
    // Ambil semua data dari model
    $data = Score::all();

    // Variabel untuk menyimpan jumlah nilai dan frekuensi
    $totalScores = [
        'kpu' => 0,
        'ppu' => 0,
        'kua' => 0,
        'mat' => 0,
    ];

    $count = $data->count();  // Jumlah elemen
    $scoreArrays = [          // Array untuk menyimpan nilai per variabel
        'kpu' => [],
        'ppu' => [],
        'kua' => [],
        'mat' => [],
    ];

    $frequencies = [          // Array untuk menghitung frekuensi setiap nilai
        'kpu' => [],
        'ppu' => [],
        'kua' => [],
        'mat' => [],
    ];

    // Loop untuk menghitung total nilai, dan menyiapkan array nilai serta frekuensi
    foreach ($data as $item) {
        // Menyimpan jumlah total nilai untuk mean
        $totalScores['kpu'] += $item->score_kpu;
        $totalScores['ppu'] += $item->score_ppu;
        $totalScores['kua'] += $item->score_kua;
        $totalScores['mat'] += $item->score_mat;

        // Menyimpan nilai ke dalam array untuk median
        $scoreArrays['kpu'][] = $item->score_kpu;
        $scoreArrays['ppu'][] = $item->score_ppu;
        $scoreArrays['kua'][] = $item->score_kua;
        $scoreArrays['mat'][] = $item->score_mat;

        // Menyimpan frekuensi nilai untuk modus
        $frequencies['kpu'][$item->score_kpu] = ($frequencies['kpu'][$item->score_kpu] ?? 0) + 1;
        $frequencies['ppu'][$item->score_ppu] = ($frequencies['ppu'][$item->score_ppu] ?? 0) + 1;
        $frequencies['kua'][$item->score_kua] = ($frequencies['kua'][$item->score_kua] ?? 0) + 1;
        $frequencies['mat'][$item->score_mat] = ($frequencies['mat'][$item->score_mat] ?? 0) + 1;
    }

    // Hitung mean secara manual
    $mean = [
        'kpu' => $totalScores['kpu'] / $count,
        'ppu' => $totalScores['ppu'] / $count,
        'kua' => $totalScores['kua'] / $count,
        'mat' => $totalScores['mat'] / $count,
    ];

    // Hitung median secara manual
    foreach ($scoreArrays as $key => $values) {
        sort($values);  // Urutkan nilai
        $middle = floor($count / 2);

        if ($count % 2 == 0) {
            $median[$key] = ($values[$middle - 1] + $values[$middle]) / 2;  // Jika jumlah genap
        } else {
            $median[$key] = $values[$middle];  // Jika jumlah ganjil
        }
    }

    // Hitung modus secara manual
    $mode = [];
    foreach ($frequencies as $key => $freqs) {
        arsort($freqs);  // Urutkan berdasarkan frekuensi
        $mode[$key] = array_key_first($freqs);  // Ambil nilai dengan frekuensi tertinggi
    }

      // Hitung varians dan deviasi standar
      $variance = [];
      $standardDeviation = [];
      foreach ($scoreArrays as $key => $values) {
          // Hitung varians
          $varianceSum = 0;
          foreach ($values as $value) {
              $varianceSum += pow($value - $mean[$key], 2);  // (x - mean)^2
          }
          $variance[$key] = $varianceSum / $count;  // Varians = jumlah kuadrat selisih / n

          // Hitung deviasi standar
          $standardDeviation[$key] = sqrt($variance[$key]);  // Akar kuadrat dari varians
      }

    // Simpan semua hasil dalam 1 array response
    $statistics = [
        'mean' => $mean,
        'median' => $median,
        'mode' => $mode,
        'variance' => $variance,
        'standard_deviation' => $standardDeviation,
    ];


    return view('data.nilai', ['statistics' => $statistics]);

}

}
