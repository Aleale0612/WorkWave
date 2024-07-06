<?php
include "koneksi.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch data for transactions chart
$transactionsQuery = "
    SELECT 
        MONTH(t.transaction_time) AS month, 
        SUM(t.gross_amount) AS total_amount, 
        p.nama_paket AS package_name 
    FROM 
        transactions t 
    JOIN 
        paketloker p ON t.package_id = p.package_id 
    WHERE 
        t.transaction_status = 'success' 
    GROUP BY 
        MONTH(t.transaction_time), p.nama_paket
";
$transactionsResult = $koneksi->query($transactionsQuery);
$transactionsData = [];
$transactionsLabels = [];
$transactionsAmounts = [
    'gold' => [],
    'silver' => [],
    'bronze' => []
];

while ($row = $transactionsResult->fetch_assoc()) {
    $month = $row['month'];
    $packageName = strtolower($row['package_name']); // Convert to lowercase to match keys

    if (!in_array($month, $transactionsLabels)) {
        $transactionsLabels[] = $month;
    }

    // Initialize amount if not set
    if (!isset($transactionsAmounts[$packageName][$month])) {
        $transactionsAmounts[$packageName][$month] = 0;
    }

    $transactionsAmounts[$packageName][$month] += $row['total_amount'];
}

// Ensure that each month has a value for each package
foreach ($transactionsLabels as $month) {
    foreach ($transactionsAmounts as $package => $amounts) {
        if (!isset($transactionsAmounts[$package][$month])) {
            $transactionsAmounts[$package][$month] = 0;
        }
    }
}

// Prepare data for JSON response
$transactionsData = [];
foreach ($transactionsLabels as $month) {
    $transactionsData[] = [
        'month' => $month,
        'gold' => $transactionsAmounts['gold'][$month],
        'silver' => $transactionsAmounts['silver'][$month],
        'bronze' => $transactionsAmounts['bronze'][$month]
    ];
}

// Fetch data for perusahaan chart with status 'diterima'
$perusahaanQuery = "SELECT MONTH(created_at) AS month, COUNT(*) AS count FROM users WHERE status = 'diterima' GROUP BY MONTH(created_at)";
$perusahaanResult = $koneksi->query($perusahaanQuery);
$perusahaanData = [];
$perusahaanLabels = [];
while ($row = $perusahaanResult->fetch_assoc()) {
    $perusahaanLabels[] = $row['month'];
    $perusahaanData[] = $row['count'];
}

header('Content-Type: application/json');
echo json_encode([
    'transactions' => [
        'labels' => $transactionsLabels,
        'data' => $transactionsData,
    ],
    'perusahaan' => [
        'labels' => $perusahaanLabels,
        'data' => $perusahaanData,
    ],
]);
?>
