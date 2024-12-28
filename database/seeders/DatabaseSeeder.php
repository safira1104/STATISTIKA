<?php

namespace Database\Seeders;

use App\Models\Score; // Pastikan menggunakan model yang benar
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Lokasi file CSV
        $csvFile = fopen(base_path("database/data/data.csv"), "r");

        // Lewati header
        $firstLine = true;

        // Hitung berapa data yang sudah dimasukkan
        $count = 0;

        // Baca CSV baris per baris
        while (($data = fgetcsv($csvFile, 0, ",")) !== FALSE) {
            if (!$firstLine && $count < 5000) {
                // Ambil dan ubah nilai yang sesuai dari file CSV
                $scoreKpu = intval($data[0]); // score_kpu
                $scorePpu = intval($data[1]); // score_ppu
                $scoreKua = intval($data[2]); // score_kua
                $scoreMat = intval($data[3]); // score_mat
                $keterangan = $data[4];        // keterangan (asumsi ini adalah string)

                // Masukkan data ke dalam tabel
                Score::create([
                    'score_kpu' => $scoreKpu,
                    'score_ppu' => $scorePpu,
                    'score_kua' => $scoreKua,
                    'score_mat' => $scoreMat,
                    'keterangan' => $keterangan,
                ]);

                $count++;
            }
            $firstLine = false;
        }

        // Tutup file CSV
        fclose($csvFile);
    }
}
