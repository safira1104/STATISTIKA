<?php

namespace App\Imports;

use Illuminate\Http\Request;
use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\ToModel;

class NilaiImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Nilai([
            'MaxTemp' => $row[0],           // Sesuaikan dengan nama kolom di database
            'WindSpeed3pm' => $row[1],
            'Humidity9am' => $row[2],
            'Humidity3pm' => $row[3],
            'RainTomorrow' => $row[4],      // Tambahkan ini jika data RainTomorrow ada di $row
        ]);
    }

    public function headings(): array
    {
        return [
            'MaxTemp',
            'WindSpeed3pm',
            'Humidity9am',
            'Humidity3pm',
            'RainTomorrow'
        ];
    }
}
