<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require '../../../autoload.php'; // Include Composer's autoload

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-2ybf1Dlh3fptsONo3qo7LBpl';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false;
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;

// Ensure the response is always JSON
header('Content-Type: application/json');

$packageId = (int)$_POST['package_id']; // Ensure the package_id is an integer
$user_id = $_SESSION['user_id']; // Ensure the user_id is stored in session

function getPackagePrice($packageId) {
    include 'koneksi.php';
    $query = "SELECT price FROM paketloker WHERE package_id = ?";
    $stmt = $koneksi->prepare($query);
    if (!$stmt) {
        error_log("Prepare failed: (" . $koneksi->errno . ") " . $koneksi->error);
        return false;
    }
    $stmt->bind_param('i', $packageId);
    $stmt->execute();
    $stmt->bind_result($price);
    if ($stmt->fetch()) {
        error_log("getPackagePrice: packageId = $packageId, price = $price");
        $stmt->close();
        return $price;
    } else {
        error_log("getPackagePrice: No result for packageId = $packageId");
        $stmt->close();
        return false;
    }
}

function getPackageName($packageId) {
    include 'koneksi.php';
    $query = "SELECT nama_paket FROM paketloker WHERE package_id = ?";
    $stmt = $koneksi->prepare($query);
    if (!$stmt) {
        error_log("Prepare failed: (" . $koneksi->errno . ") " . $koneksi->error);
        return false;
    }
    $stmt->bind_param('i', $packageId);
    $stmt->execute();
    $stmt->bind_result($name);
    if ($stmt->fetch()) {
        error_log("getPackageName: packageId = $packageId, name = $name");
        $stmt->close();
        return $name;
    } else {
        error_log("getPackageName: No result for packageId = $packageId");
        $stmt->close();
        return false;
    }
}

try {
    $price = getPackagePrice($packageId);
    $name = getPackageName($packageId);

    // Tambahkan logging untuk debugging
    error_log("Package ID: $packageId, Price: $price, Name: $name");

    if (!$price || $price <= 0) {
        throw new Exception('Invalid package price');
    }

    $transactionDetails = [
        'order_id' => uniqid(),
        'gross_amount' => $price
    ];

    $itemDetails = [
        [
            'id' => $packageId,
            'price' => $price,
            'quantity' => 1,
            'name' => $name
        ]
    ];

    $customerDetails = [
        'user_id' => $user_id,
    ];

    $transaction = [
        'transaction_details' => $transactionDetails,
        'item_details' => $itemDetails,
        'customer_details' => $customerDetails,
    ];

    $snapToken = \Midtrans\Snap::getSnapToken($transaction);
    ob_end_clean(); // Clear the output buffer
    echo json_encode(['snapToken' => $snapToken]);
} catch (Exception $e) {
    ob_end_clean(); // Clear the output buffer
    echo json_encode(['error' => $e->getMessage()]);
    exit();
}
