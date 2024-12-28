<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DistributionController extends Controller
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

         // Calculate cumulative frequencies less than
         $totalKpu = $totalPpu = $totalKua = $totalMat = 0;
         $cumulativeLessThan = [];
         $count = count($distributions);

         for ($i = 0; $i < $count; $i++) {
             $totalKpu += $distributions[$i]['frequencies']['score_kpu'];
             $totalPpu += $distributions[$i]['frequencies']['score_ppu'];
             $totalKua += $distributions[$i]['frequencies']['score_kua'];
             $totalMat += $distributions[$i]['frequencies']['score_mat'];

             $cumulativeLessThan[$i] = [
                 'range' => $distributions[$i]['range'],
                 'frequencies' => [
                     'normalized_score_kpu' => $totalKpu,
                     'normalized_score_ppu' => $totalPpu,
                     'normalized_score_kua' => $totalKua,
                     'normalized_score_mat' => $totalMat,
                 ],
             ];
         }

         // Calculate cumulative frequencies greater than
         $totalKpu = $totalPpu = $totalKua = $totalMat = 0;
         $cumulativeGreaterThan = [];

         for ($i = $count - 1; $i >= 0; $i--) {
             $totalKpu += $distributions[$i]['frequencies']['score_kpu'];
             $totalPpu += $distributions[$i]['frequencies']['score_ppu'];
             $totalKua += $distributions[$i]['frequencies']['score_kua'];
             $totalMat += $distributions[$i]['frequencies']['score_mat'];

             $cumulativeGreaterThan[$i] = [
                 'range' => $distributions[$i]['range'],
                 'frequencies' => [
                     'normalized_score_kpu' => $totalKpu,
                     'normalized_score_ppu' => $totalPpu,
                     'normalized_score_kua' => $totalKua,
                     'normalized_score_mat' => $totalMat,
                 ],
             ];
         }

         // Reverse cumulativeGreaterThan to maintain the order
         $cumulativeGreaterThan = array_reverse($cumulativeGreaterThan);

         return view('data.kumulatif', [
            'distributions' => $distributions,
            'cumulativeLessThan' => $cumulativeLessThan,
            'cumulativeGreaterThan' => $cumulativeGreaterThan,
        ]);
    }
}
