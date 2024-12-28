<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;
    // Tentukan nama tabel jika berbeda dari default (yang menggunakan bentuk jamak)
    protected $table = 'scores';

    // Tentukan kolom yang bisa diisi
    protected $fillable = ['score_kpu', 'score_ppu', 'score_kua', 'score_mat', 'keterangan'];

     // Definisikan relasi dengan NormalizedScore
     public function normalizedScore()
     {
         return $this->hasOne(NormalizedScore::class);
     }
}
