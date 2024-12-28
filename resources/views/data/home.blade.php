@extends('layouts.app')

@section('content')
    <style>
        /* Styling umum untuk body */
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
            font-size: 2.5rem; /* Ukuran font judul */
            margin: 20px 0 0; /* Menghapus margin di bawah dan memberi jarak atas */
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
            width: 45%; /* Lebar garis bawah mengikuti lebar teks */
        }

        /* Styling untuk tabel */
        table {
            width: 100%; /* Lebar tabel sesuai konten */
            border-collapse: collapse; /* Menggabungkan border */
            margin: 20px 0; /* Jarak atas dan bawah tabel */
        }

        th, td {
            padding: 12px; /* Padding untuk sel */
            text-align: center; /* Memusatkan teks dalam sel */
            border-bottom: 1px solid #ddd; /* Garis bawah setiap sel */
            color: #555; /* Warna teks sel */
        }

        th {
            background-color: #9b42f5; /* Warna latar belakang header tabel */
            color: white; /* Warna teks header tabel */
        }

        /* Styling untuk H2 agar berwarna ungu dan terpusat */
        h2 {
            color: #9b42f5; /* Warna teks H2 */
        }

        table tr:hover {
        background-color: rgba(155, 66, 245, 0.1); /* Sorotan pada baris saat hover */
        transition: background-color 0.3s ease; /* Transisi halus saat hover */
        }

        /* Menambahkan justify pada paragraf */
        p {
            text-align: justify; /* Menyusun teks menjadi rata kiri dan kanan */
            margin: 20px 0; /* Jarak atas dan bawah paragraf */
        }

        /* Styling untuk kotak informasi */
        .info-container {
            display: flex; /* Menyusun kotak secara horizontal */
            justify-content: space-around; /* Memberi jarak di antara kotak */
            margin-top: 30px; /* Jarak di atas kotak informasi */
        }

        .info-box {
            background-color: #fff; /* Warna latar belakang kotak */
            border: 1px solid #ddd; /* Border kotak */
            border-radius: 5px; /* Sudut kotak melengkung */
            padding: 20px; /* Padding di dalam kotak */
            width: 30%; /* Lebar kotak */
            text-align: center; /* Memusatkan teks dalam kotak */
            transition: transform 0.3s, box-shadow 0.3s; /* Transisi untuk efek interaktif */
        }

        .info-box:hover {
            transform: scale(1.05); /* Memperbesar kotak saat hover */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Menambahkan bayangan saat hover */
        }

        .info-title {
            font-weight: bold; /* Membuat judul lebih tebal */
            color: #9b42f5; /* Warna judul kotak */
            margin-bottom: 10px; /* Jarak di bawah judul */
            font-size: 1.2rem; /* Ukuran font judul */
        }

        .info-content {
            font-size: 1.2rem; /* Ukuran font untuk NPM */
            color: #9b42f5; /* Warna judul kotak */
            margin: 0 auto; /* Memusatkan konten */
            text-align: center; /* Memusatkan teks */
        }
    </style>


    <!-- Kotak Informasi Penyusun Tugas -->
    <div class="title-container">
        <h1>Anggota Kelompok</h1>
        <div class="underline"></div> <!-- Garis bawah untuk judul -->
    </div>

    <div class="info-container">
        <div class="info-box">
            <div class="info-title">Clarissa Razendri Ignasia</div>
            <p class="info-content">23081010016</p>
        </div>

        <div class="info-box">
            <div class="info-title">Safira Rusyda</div>
            <p class="info-content">23081010038</p>
        </div>

        <div class="info-box">
            <div class="info-title">Dinda Maharani</div>
            <p class="info-content">23081010132</p>
        </div>
    </div>

    <div class="title-container">
        <h1>Informasi Terkait Dataset</h1>
        <div class="underline"></div> <!-- Garis bawah untuk judul -->
    </div>

    <p>
        Dataset ini berisi hasil ujian SKOR UTBK Saintek tahun 2019 yang mencakup empat komponen utama:
        <strong>Score KPU (Kemampuan Penalaran Umum)</strong>,
        <strong>Score PPU (Pengetahuan dan Pemahaman Umum)</strong>,
        <strong>Score KUA (Kemampuan untuk Menyelesaikan Soal dengan Kecermatan dan Kecepatan)</strong>,
        dan <strong>Score MAT (Kemampuan Matematika Dasar)</strong>.
        Data ini akan diolah dan akan menampilkan nilai <strong>mean, median, modus, varian, dan standar deviasi.</strong>
        Selain itu ditampilkan juga <strong>normalisasi</strong>, dan penyajian dari masing-masing skor mulai dari <strong>frekuensi kumulatif, relatif, kumulatif > (lebih dari) dan < (kurang dari), frekuensi relatif kumulatif > (lebih dari) dan < (kurang dari).</strong>
    </p>

    <div class="title-container">
        <h1>Preview Distribusi Data</h1>
        <div class="underline"></div> <!-- Garis bawah untuk H1 -->
    </div>

    <h2>Distribusi Relatif</h2>
    <table>
        <thead>
            <tr>
                <th>Rentang</th>
                <th>Score KPU</th>
                <th>Score PPU</th>
                <th>Score KUA</th>
                <th>Score MAT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($relative_data as $data)
                <tr>
                    <td>{{ $data['range'] }}</td>
                    <td>{{ $data['frequencies']['score_kpu'] }}</td>
                    <td>{{ $data['frequencies']['score_ppu'] }}</td>
                    <td>{{ $data['frequencies']['score_kua'] }}</td>
                    <td>{{ $data['frequencies']['score_mat'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Frekuensi Kumulatif Kurang Dari <</h2>
    <table>
        <thead>
            <tr>
                <th>Rentang</th>
                <th>Score KPU</th>
                <th>Score PPU</th>
                <th>Score KUA</th>
                <th>Score MAT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cumulative_less_than as $data)
                <tr>
                    <td>{{ $data['range'] }}</td>
                    <td>{{ $data['frequencies']['cumulative_score_kpu'] }}</td>
                    <td>{{ $data['frequencies']['cumulative_score_ppu'] }}</td>
                    <td>{{ $data['frequencies']['cumulative_score_kua'] }}</td>
                    <td>{{ $data['frequencies']['cumulative_score_mat'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Frekuensi Kumulatif Lebih Dari ></h2>
    <table>
        <thead>
            <tr>
                <th>Rentang</th>
                <th>Score KPU</th>
                <th>Score PPU</th>
                <th>Score KUA</th>
                <th>Score MAT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cumulative_greater_than as $data)
                <tr>
                    <td>{{ $data['range'] }}</td>
                    <td>{{ $data['frequencies']['cumulative_score_kpu'] }}</td>
                    <td>{{ $data['frequencies']['cumulative_score_ppu'] }}</td>
                    <td>{{ $data['frequencies']['cumulative_score_kua'] }}</td>
                    <td>{{ $data['frequencies']['cumulative_score_mat'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
