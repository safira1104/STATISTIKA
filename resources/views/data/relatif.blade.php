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
        text align: center;
        vertical-align: middle;
        }

        tr:nth-child(even) {
            background-color: #f7fafc; /* Warna baris genap untuk keterbacaan */
        }

        .table tr:hover {
        background-color: rgba(155, 66, 245, 0.1); /* Sorotan pada baris saat hover */
        transition: background-color 0.3s ease; /* Transisi halus saat hover */
        }

        th:nth-child(1) {
        width: 25%; /* Lebar kolom pertama (Range) */
        }

        th:nth-child(2) {
        width: 25%; /* Lebar kolom kedua (Distribusi Frekuensi Relatif) */
        }

        th:nth-child(3), th:nth-child(4) {
        width: 25%; /* Lebar kolom ketiga dan keempat (Kumulatif) */
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
        <h2>Frekuensi Relatif Score {{ strtoupper($scoreType) }}</h2>

        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Range</th>
                        <th>Distribusi Frekuensi Relatif</th>
                        <th>Distribusi Frekuensi Relatif Kumulatif <</th>
                        <th>Distribusi Frekuensi Relatif Kumulatif ></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($relative_distributions as $index => $distribution)
                        <tr>
                            <td>{{ $distribution['range'] }}</td>
                            <td>{{ $distribution['frequencies']['score_' . $scoreType] ?? 'N/A' }}</td>
                            <td>{{ $cumulative_less_than[$index]['frequencies']['cumulative_score_' . $scoreType] ?? 'N/A' }}</td>
                            <td>{{ $cumulative_greater_than[$index]['frequencies']['cumulative_score_' . $scoreType] ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Grafik Histogram untuk Score -->
            <canvas id="{{ $scoreType }}Chart"></canvas>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('{{ $scoreType }}Chart').getContext('2d');

                // Data untuk distribusi
                const relativeFrequencies = @json(array_map(function($dist) use ($scoreType) {
                    return $dist['frequencies']['score_' . $scoreType] ?? null;
                }, $relative_distributions));

                const cumulativeLessThan = @json(array_map(function($cum) use ($scoreType) {
                    return $cum['frequencies']['cumulative_score_' . $scoreType] ?? null;
                }, $cumulative_less_than));

                const cumulativeGreaterThan = @json(array_map(function($cum) use ($scoreType) {
                    return $cum['frequencies']['cumulative_score_' . $scoreType] ?? null;
                }, $cumulative_greater_than));

                const ranges = @json(array_column($relative_distributions, 'range'));

                // Buat chart histogram
                const chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ranges,
                        datasets: [
                            {
                                label: 'Distribusi Frekuensi Relatif (%)',
                                data: relativeFrequencies,
                                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Kumulatif < (%)',
                                data: cumulativeLessThan,
                                backgroundColor: 'rgba(153, 102, 255, 0.5)',
                                borderColor: 'rgba(153, 102, 255, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Kumulatif > (%)',
                                data: cumulativeGreaterThan,
                                backgroundColor: 'rgba(255, 159, 64, 0.5)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Range'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Frekuensi Relatif (%)'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endforeach
@endsection
