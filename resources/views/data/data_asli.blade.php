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
            text-align: center; /* Memusatkan teks judul */
            margin-bottom: 20px; /* Jarak di bawah judul */
        }

        h1 {
            color: #9b42f5; /* Warna judul */
            font-size: 2.5rem; /* Ukuran font judul */
            margin: 0; /* Menghapus margin */
            font-weight: bold; /* Membuat judul lebih tebal */
            text-transform: uppercase; /* Mengubah semua huruf menjadi kapital */
            display: inline-block; /* Mengubah elemen h1 menjadi inline-block */
            position: relative; /* Membuat posisi relatif untuk h1 */
        }

        .underline {
            display: block; /* Garis bawah sebagai blok */
            height: 2px; /* Ketebalan garis bawah */
            background-color: #9b42f5; /* Warna garis bawah */
            margin: 5px auto; /* Memusatkan garis bawah dan memberi jarak di atas/bawah */
            width: 32%; /* Lebar garis bawah mengikuti lebar teks */
        }

        /* Styling untuk tabel */
        .table {
            width: 100%; /* Mengatur lebar tabel */
            border-collapse: collapse; /* Menghilangkan jarak antara border sel */
            margin-bottom: 20px; /* Jarak di bawah tabel */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Bayangan halus pada tabel */
            border-radius: 8px; /* Sudut membulat untuk tabel */
            overflow: hidden; /* Memastikan radius membulat terlihat */
        }

        .table-bordered {
            border: 1px solid #e0e0e0; /* Border untuk tabel */
        }

        .table th, .table td {
            padding: 12px; /* Padding di dalam sel */
            text-align: center; /* Memusatkan teks dalam sel */
            border: 1px solid #e0e0e0; /* Border untuk setiap sel */
        }

        .table th {
            background-color: #9b42f5; /* Warna latar belakang header */
            color: white; /* Warna teks header */
            font-weight: bold; /* Membuat teks header lebih tebal */
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2; /* Warna latar belakang untuk baris genap */
        }

        .table tr:hover {
            background-color: rgba(155, 66, 245, 0.1); /* Sorotan pada baris saat hover */
            transition: background-color 0.3s ease; /* Transisi halus saat hover */
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 768px) {
            .table {
                display: block; /* Mengubah tabel menjadi block untuk responsif */
                overflow-x: auto; /* Menambahkan scroll horizontal jika diperlukan */
                white-space: nowrap; /* Menghindari pemenggalan teks */
            }

            h1 {
                font-size: 2rem; /* Ukuran font judul untuk layar kecil */
            }

            .table th, .table td {
                padding: 8px; /* Mengurangi padding untuk layar kecil */
                font-size: 0.9rem; /* Ukuran font lebih kecil untuk layar kecil */
            }
        }
    </style>

    <div class="title-container">
        <h1>Tabel Data Score</h1>
        <div class="underline"></div> <!-- Garis bawah untuk judul -->
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Score KPU</th>
                <th>Score PPU</th>
                <th>Score KUA</th>
                <th>Score Mat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($scores as $score)
                <tr>
                    <td>{{ $score->id }}</td>
                    <td>{{ $score->score_kpu }}</td>
                    <td>{{ $score->score_ppu }}</td>
                    <td>{{ $score->score_kua }}</td>
                    <td>{{ $score->score_mat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
