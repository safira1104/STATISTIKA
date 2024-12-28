<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Mengambil data dari NewDistributionController untuk ditampilkan sebagai preview
        $distributionController = new NewDistributionController();

        // Mengambil data distribusi relatif, kumulatif kurang dari, dan kumulatif lebih dari
        $relativeData = $distributionController->index()->getData()['relative_distributions'];
        $cumulativeLessThan = $distributionController->index()->getData()['cumulative_less_than'];
        $cumulativeGreaterThan = $distributionController->index()->getData()['cumulative_greater_than'];

        // Mengirim data ke halaman home untuk di-preview
        return view('data.home', [
            'relative_data' => $relativeData,
            'cumulative_less_than' => $cumulativeLessThan,
            'cumulative_greater_than' => $cumulativeGreaterThan,
        ]);
    }
}
