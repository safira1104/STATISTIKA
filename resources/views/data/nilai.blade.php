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

        /* Styling untuk kontainer kotak statistik */
        .stat-container {
            display: flex; /* Menggunakan flexbox untuk susunan */
            justify-content: center; /* Memusatkan konten */
            flex-wrap: wrap; /* Agar bisa berpindah baris jika tidak muat */
            margin-bottom: 20px; /* Jarak di bawah kontainer */
        }

        /* Styling untuk kotak statistik */
        .stat-box {
            background: linear-gradient(145deg, #ffffff, #e6e6e6); /* Gradien putih ke abu-abu */
            border: 1px solid #9b42f5; /* Border ungu */
            border-radius: 15px; /* Sudut melengkung */
            padding: 20px; /* Padding di dalam kotak */
            width: 300px; /* Lebar kotak diperbesar */
            height: auto; /* Mengatur tinggi kotak secara otomatis */
            margin: 15px; /* Margin di sekitar kotak */
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.2), -5px -5px 15px rgba(255, 255, 255, 0.7); /* Bayangan 3D */
            transition: transform 0.3s, box-shadow 0.3s; /* Transisi halus */
            overflow: hidden; /* Menyembunyikan teks yang keluar dari kotak */
            text-align: center; /* Memusatkan teks di dalam kotak */
        }

        .stat-box h3 {
            color: #9b42f5; /* Warna judul dalam kotak */
            font-size: 1.5rem; /* Ukuran font untuk judul */
            margin-bottom: 10px; /* Jarak di bawah judul */
            font-weight: bold; /* Membuat judul lebih tebal */
            text-transform: uppercase; /* Mengubah semua huruf menjadi kapital */
        }

        .stat-box:hover {
            transform: translateY(-5px) scale(1.05); /* Sedikit naik dan membesar saat hover */
            box-shadow: 10px 10px 25px rgba(0, 0, 0, 0.3), -10px -10px 25px rgba(255, 255, 255, 0.8); /* Bayangan lebih dalam saat hover */
        }

        /* Styling untuk tabel di dalam kotak */
        table {
            width: 100%; /* Lebar tabel sesuai kotak */
            border-collapse: collapse; /* Menggabungkan border */
            margin: 10px 0; /* Jarak atas dan bawah tabel */
        }

        td {
            padding: 8px; /* Padding untuk sel */
            text-align: center; /* Memusatkan teks dalam sel */
            border-bottom: 1px solid #ddd; /* Garis bawah setiap sel */
            color: #555; /* Warna teks sel */
        }
    </style>

    <div class="title-container">
        <h1>Statistik Data Nilai</h1>
        <div class="underline"></div> <!-- Garis bawah untuk judul -->
    </div>

    <div class="stat-container">
        <div class="stat-box">
            <h3>Mean</h3>
            <table>
                <tbody>
                    <tr>
                        <td>Score KPU: {{ $statistics['mean']['kpu'] }}</td>
                    </tr>
                    <tr>
                        <td>Score PPU: {{ $statistics['mean']['ppu'] }}</td>
                    </tr>
                    <tr>
                        <td>Score KUA: {{ $statistics['mean']['kua'] }}</td>
                    </tr>
                    <tr>
                        <td>Score MAT: {{ $statistics['mean']['mat'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="stat-box">
            <h3>Median</h3>
            <table>
                <tbody>
                    <tr>
                        <td>Score KPU: {{ $statistics['median']['kpu'] }}</td>
                    </tr>
                    <tr>
                        <td>Score PPU: {{ $statistics['median']['ppu'] }}</td>
                    </tr>
                    <tr>
                        <td>Score KUA: {{ $statistics['median']['kua'] }}</td>
                    </tr>
                    <tr>
                        <td>Score MAT: {{ $statistics['median']['mat'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="stat-box">
            <h3>Modus</h3>
            <table>
                <tbody>
                    <tr>
                        <td>Score KPU: {{ $statistics['mode']['kpu'] }}</td>
                    </tr>
                    <tr>
                        <td>Score PPU: {{ $statistics['mode']['ppu'] }}</td>
                    </tr>
                    <tr>
                        <td>Score KUA: {{ $statistics['mode']['kua'] }}</td>
                    </tr>
                    <tr>
                        <td>Score MAT: {{ $statistics['mode']['mat'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="stat-box">
            <h3>Varian</h3>
            <table>
                <tbody>
                    <tr>
                        <td>Score KPU: {{ $statistics['variance']['kpu'] }}</td>
                    </tr>
                    <tr>
                        <td>Score PPU: {{ $statistics['variance']['ppu'] }}</td>
                    </tr>
                    <tr>
                        <td>Score KUA: {{ $statistics['variance']['kua'] }}</td>
                    </tr>
                    <tr>
                        <td>Score MAT: {{ $statistics['variance']['mat'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="stat-box">
            <h3>Standar Deviasi</h3>
            <table>
                <tbody>
                    <tr>
                        <td>Score KPU: {{ $statistics['standard_deviation']['kpu'] }}</td>
                    </tr>
                    <tr>
                        <td>Score PPU: {{ $statistics['standard_deviation']['ppu'] }}</td>
                    </tr>
                    <tr>
                        <td>Score KUA: {{ $statistics['standard_deviation']['kua'] }}</td>
                    </tr>
                    <tr>
                        <td>Score MAT: {{ $statistics['standard_deviation']['mat'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
