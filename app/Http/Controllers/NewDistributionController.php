<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewDistributionController extends Controller
{
    public function index()
    {
        // Ambil data normalisasi dari ScoreController
        $scoreController = new ScoreController();
        $normalizedData = $scoreController->getNormalizedData();

        // Define the intervals for the ranges
        $ranges = [
            ['min' => 0.00000000, 'max' => 0.07692308],
            ['min' => 0.07692309, 'max' => 0.15384617],
            ['min' => 0.15384618, 'max' => 0.23076927],
            ['min' => 0.23076928, 'max' => 0.30769237],
            ['min' => 0.30769238, 'max' => 0.38461546],
            ['min' => 0.38461547, 'max' => 0.46153856],
            ['min' => 0.46153857, 'max' => 0.53846166],
            ['min' => 0.53846167, 'max' => 0.61538476],
            ['min' => 0.61538477, 'max' => 0.69230785],
            ['min' => 0.69230786, 'max' => 0.76923095],
            ['min' => 0.76923096, 'max' => 0.84615405],
            ['min' => 0.84615406, 'max' => 0.92307714],
            ['min' => 0.92307715, 'max' => 1.00000024],
        ];

        // Initialize an array to store frequencies for each interval
        $distributions = [];

        // Loop through each range to calculate frequencies
        foreach ($ranges as $range) {
            $frequencies = [
                'score_kpu' => 0,
                'score_ppu' => 0,
                'score_kua' => 0,
                'score_mat' => 0,
            ];

            foreach ($normalizedData as $score) {
                // Pembulatan dan penghitungan frekuensi
                $normalizedKpu = round($score['normalized_score_kpu'], 8);
                $normalizedPpu = round($score['normalized_score_ppu'], 8);
                $normalizedKua = round($score['normalized_score_kua'], 8);
                $normalizedMat = round($score['normalized_score_mat'], 8);

                if ($normalizedKpu >= $range['min'] && $normalizedKpu < $range['max']) {
                    $frequencies['score_kpu']++;
                }
                if ($normalizedPpu >= $range['min'] && $normalizedPpu < $range['max']) {
                    $frequencies['score_ppu']++;
                }
                if ($normalizedKua >= $range['min'] && $normalizedKua < $range['max']) {
                    $frequencies['score_kua']++;
                }
                if ($normalizedMat >= $range['min'] && $normalizedMat < $range['max']) {
                    $frequencies['score_mat']++;
                }
            }

            // Store the range and frequencies in the distributions array
            $distributions[] = [
                'range' => "{$range['min']} - {$range['max']}",
                'frequencies' => $frequencies,
            ];
        }

        // Total frekuensi untuk setiap score
        $totalKpu = array_sum(array_column(array_column($distributions, 'frequencies'), 'score_kpu'));
        $totalPpu = array_sum(array_column(array_column($distributions, 'frequencies'), 'score_ppu'));
        $totalKua = array_sum(array_column(array_column($distributions, 'frequencies'), 'score_kua'));
        $totalMat = array_sum(array_column(array_column($distributions, 'frequencies'), 'score_mat'));

        // Hitung frekuensi relatif dalam bentuk absolut dan tampilkan sebagai persen
        $relativeDistributions = [];
        foreach ($distributions as $distribution) {
            $relativeDistributions[] = [
                'range' => $distribution['range'],
                'frequencies' => [
                    'score_kpu' => ($totalKpu > 0) ? round(($distribution['frequencies']['score_kpu'] / $totalKpu) * 100, 2) : 0,
                    'score_ppu' => ($totalPpu > 0) ? round(($distribution['frequencies']['score_ppu'] / $totalPpu) * 100, 2) : 0,
                    'score_kua' => ($totalKua > 0) ? round(($distribution['frequencies']['score_kua'] / $totalKua) * 100, 2) : 0,
                    'score_mat' => ($totalMat > 0) ? round(($distribution['frequencies']['score_mat'] / $totalMat) * 100, 2) : 0,
                ]
            ];
        }

        // Hitung frekuensi kumulatif kurang dari
        $cumulativeLessThan = [];
        $cumulativeKpu = $cumulativePpu = $cumulativeKua = $cumulativeMat = 0;
        foreach ($distributions as $distribution) {
            $cumulativeKpu += $distribution['frequencies']['score_kpu'];
            $cumulativePpu += $distribution['frequencies']['score_ppu'];
            $cumulativeKua += $distribution['frequencies']['score_kua'];
            $cumulativeMat += $distribution['frequencies']['score_mat'];

            $cumulativeLessThan[] = [
                'range' => $distribution['range'],
                'frequencies' => [
                    'cumulative_score_kpu' => round(($cumulativeKpu / $totalKpu) * 100, 2),
                    'cumulative_score_ppu' => round(($cumulativePpu / $totalPpu) * 100, 2),
                    'cumulative_score_kua' => round(($cumulativeKua / $totalKua) * 100, 2),
                    'cumulative_score_mat' => round(($cumulativeMat / $totalMat) * 100, 2),
                ]
            ];
        }

        // Hitung frekuensi kumulatif lebih dari
        $cumulativeGreaterThan = [];
        $cumulativeKpu = $cumulativePpu = $cumulativeKua = $cumulativeMat = 0;
        $reversedDistributions = array_reverse($distributions);
        foreach ($reversedDistributions as $distribution) {
            $cumulativeKpu += $distribution['frequencies']['score_kpu'];
            $cumulativePpu += $distribution['frequencies']['score_ppu'];
            $cumulativeKua += $distribution['frequencies']['score_kua'];
            $cumulativeMat += $distribution['frequencies']['score_mat'];

            $cumulativeGreaterThan[] = [
                'range' => $distribution['range'],
                'frequencies' => [
                    'cumulative_score_kpu' => round(($cumulativeKpu / $totalKpu) * 100, 2),
                    'cumulative_score_ppu' => round(($cumulativePpu / $totalPpu) * 100, 2),
                    'cumulative_score_kua' => round(($cumulativeKua / $totalKua) * 100, 2),
                    'cumulative_score_mat' => round(($cumulativeMat / $totalMat) * 100, 2),
                ]
            ];
        }

        return view('data.relatif', [
            'relative_distributions' => $relativeDistributions,
            'cumulative_less_than' => $cumulativeLessThan,
            'cumulative_greater_than' => array_reverse($cumulativeGreaterThan),
        ]);
    }
}
