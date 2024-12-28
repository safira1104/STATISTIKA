<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STATISTIKA KOMPUTASI F081</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Custom Navbar Styling */
        .navbar {
            background: linear-gradient(90deg, #ff6ec7, #9b42f5); /* Gradient from pink to purple */
            padding: 10px 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow effect */
            position: sticky; /* Sticky to the top */
            top: 0;
            z-index: 1000;
        }

        .navbar-toggler-icon {
            filter: invert(1); /* Make toggle icon white */
        }

        .navbar-brand,
        .nav-link {
            color: white !important;
            font-weight: bold;
            text-transform: uppercase;
        }

        .nav-link {
            transition: background 0.3s, color 0.3s; /* Smooth hover effect */
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        .dropdown-menu {
            background-color: #ff6ec7; /* Dropdown background color */
            border: none;
        }

        .dropdown-menu a {
            color: white !important;
        }

        .dropdown-menu a:hover {
            background-color: #e642f5; /* Hover effect for dropdown links */
        }

        /* Styling for the horizontal line */
        .navbar-line {
            border: none;
            height: 2px; /* Tinggi garis */
            background-color: white; /* Warna garis */
            margin-top: 0; /* Menghilangkan margin atas */
            margin-bottom: 10px; /* Jarak bawah garis */
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('data.asli') }}">Data Proses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('data.nilai') }}">Pengolahan Data</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('data.score') }}">Normalisasi</a>
                    </li>
                    <!-- Dropdown for Penyajian -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Penyajian Data
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{route('data.distribution')}}">Kumulatif</a></li>
                            <li><a class="dropdown-item" href="{{route('data.new')}}">Relatif</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <hr class="navbar-line"> <!-- Garis putih di bawah navbar -->

    <!-- Main Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
