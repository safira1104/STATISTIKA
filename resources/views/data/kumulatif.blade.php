@extends('layouts.app')

@section('content')
    <style>
        /* General body styling */
        body {
            font-family: 'Poppins', sans-serif; /* Font yang digunakan */
            background-color: #f7f8fa; /* Warna latar belakang */
            color: #333; /* Warna teks */
            padding: 20px; /* Padding di sekitar konten */
        }

        /* Memusatkan teks judul */
        .title-container {
            text-align: center; /* Memusatkan konten */
            margin-bottom: 30px; /* Jarak di bawah judul */
        }

        h1 {
            color: #9b42f5; /* Warna judul */
            font-size: 2.5rem; /* Ukuran font */
            display: inline-block; /* Mengatur agar panjang garis sesuai dengan tulisan */
            border-bottom: 2px solid #9b42f5; /* Garis bawah pada judul */
            padding-bottom: 10px; /* Jarak antara teks dan garis bawah */
            font-weight: bold; /* Membuat judul lebih tebal */
            text-transform: uppercase; /* Mengubah semua huruf menjadi kapital */
        }

        /* Gaya untuk subjudul */
        h2 {
            color: #9b42f5; /* Warna subjudul */
            font-size: 1.8rem; /* Ukuran font untuk subjudul */
            margin-top: 20px; /* Jarak di atas subjudul */
            margin-bottom: 15px; /* Jarak di bawah subjudul */
            text-align: center; /* Menyelaraskan subjudul ke tengah */
            font-weight: bold; /* Menambahkan ketebalan pada subjudul */
            text-transform: uppercase; /* Mengubah semua huruf menjadi kapital */
        }

        /* Container untuk tabel dan grafik */
        .table-container {
            margin-bottom: 40px; /* Jarak antara setiap section tabel dan grafik */
            display: flex;
            flex-direction: column;
            align-items: center; /* Memusatkan tabel */
        }

        /* Gaya untuk tabel */
        table {
            width: 100%; /* Lebar tabel */
            border-collapse: collapse; /* Menggabungkan batas */
            margin: 20px 0; /* Jarak di atas dan di bawah tabel */
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2), -5px -5px 15px rgba(255, 255, 255, 0.7); /* Bayangan 3D */
            background-color: #ffffff; /* Warna latar belakang tabel */
            border-radius: 15px; /* Sudut membulat untuk tabel */
            overflow: hidden; /* Memastikan radius membulat terlihat */
            text-align: center; /* Memusatkan teks dalam tabel */
        }

        /* Header dan cell */
        th, td {
            padding: 10px; /* Padding dalam sel */
            text-align: center; /* Menyelarakan teks dalam sel */
            border-bottom: 1px solid #ddd; /* Garis bawah setiap sel */
            transition: background-color 0.3s ease; /* Transisi halus untuk hover */
            color: #555; /* Warna teks untuk sel */
        }

        /* Gaya untuk header */
        th {
            background-color:  #9b42f5 !important; /* Warna latar belakang header menjadi ungu */
            color: #FFFFFF; /* Warna teks header */
            font-weight: bold; /* Teks header yang tebal */
            text-transform: uppercase; /* Mengubah teks header menjadi huruf besar */
            letter-spacing: 1px; /* Spasi antar huruf header */
            padding: 15px; /* Menambah padding untuk header */
            vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #f7fafc; /* Warna baris genap untuk keterbacaan */
        }

        .table tr:hover {
        background-color: rgba(155, 66, 245, 0.1); /* Sorotan pada baris saat hover */
        transition: background-color 0.3s ease; /* Transisi halus saat hover */
        }

        /* Gaya untuk chart */
        canvas {
            width: 100%; /* Lebar grafik agar mengikuti lebar tabel */
            max-width: 800px; /* Atur lebar maksimum untuk grafik */
            height: 400px; /* Tinggi tetap untuk grafik */
            border: 1px solid #e2e8f0; /* Border halus untuk grafik */
            border-radius: 15px; /* Sudut membulat pada canvas */
            background-color: #ffffff; /* Warna latar belakang canvas */
            padding: 10px; /* Padding untuk jarak grafik dari tepi */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Bayangan pada grafik */
            margin-top: 20px; /* Jarak di atas grafik */
        }
    </style>

    <div class="title-container">
        <h1>Distribusi Frekuensi</h1>
    </div>

    @php
        $scoreTypes = ['kpu', 'ppu', 'kua', 'mat'];
    @endphp

    @foreach($scoreTypes as $scoreType)
        <h2>Frekuensi Kumulatif Score {{ strtoupper($scoreType) }}</h2>

        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Range</th>
                        <th>Distribusi Frekuensi</th>
                        <th>Distribusi Frekuensi Kumulatif <</th>
                        <th>Distribusi Frekuensi Kumulatif ></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($distributions as $distribution)
                        <tr>
                            <td>{{ $distribution['range'] }}</td>
                            <td>{{ $distribution['frequencies']['score_' . $scoreType] }}</td>
                            <td>
                                @foreach($cumulativeLessThan as $cumulative)
                                    @if($cumulative['range'] === $distribution['range'])
                                        {{ $cumulative['frequencies']['normalized_score_' . $scoreType] }}
                                    @endif
                                @endforeach
                            </td>
                            <td>
                                @foreach($cumulativeGreaterThan as $cumulative)
                                    @if($cumulative['range'] === $distribution['range'])
                                        {{ $cumulative['frequencies']['normalized_score_' . $scoreType] }}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <canvas id="{{ $scoreType }}Chart"></canvas>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('{{ $scoreType }}Chart').getContext('2d');

                // Data untuk distribusi
                const relativeFrequencies = @json(array_map(function($dist) use ($scoreType) {
                    return $dist['frequencies']['score_' . $scoreType] ?? null;
                }, $distributions));

                const cumulativeLessThan = @json(array_map(function($cum) use ($scoreType) {
                    return $cum['frequencies']['normalized_score_' . $scoreType] ?? null;
                }, $cumulativeLessThan));

                const cumulativeGreaterThan = @json(array_map(function($cum) use ($scoreType) {
                    return $cum['frequencies']['normalized_score_' . $scoreType] ?? null;
                }, $cumulativeGreaterThan));

                const ranges = @json(array_map(function($d) {
                    return $d['range'];
                }, $distributions));

                // Buat chart histogram
                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ranges,
                        datasets: [{
                            label: 'Frekuensi {{ strtoupper($scoreType) }}',
                            data: relativeFrequencies,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Frekuensi Kumulatif < {{ strtoupper($scoreType) }}',
                            data: cumulativeLessThan,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }, {
                            label: 'Frekuensi Kumulatif > {{ strtoupper($scoreType) }}',
                            data: cumulativeGreaterThan,
                            backgroundColor: 'rgba(255, 159, 64, 0.2)',
                            borderColor: 'rgba(255, 159, 64, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            });
        </script>
    @endforeach
@endsection
