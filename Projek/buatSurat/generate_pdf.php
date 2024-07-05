<?php
require __DIR__ . '/vendor/autoload.php';

use Mpdf\Mpdf;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coverLetterHtml = $_POST['coverLetterHtml'];
    $name = $_POST['name'];
    $city = $_POST['city'];
    $dateToday = $_POST['dateToday'];

    try {
        // Membuat file PDF surat lamaran
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_left' => 20,
            'margin_right' => 20,
            'margin_top' => 20,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
        ]);

        // Menambahkan HTML standar untuk format surat lamaran
        $html = "
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    font-size: 12pt;
                    line-height: 1.6;
                    margin: 0;
                    padding: 0;
                }
                .header {
                    text-align: right;
                    margin-top: 20px;
                    margin-bottom: 20px;
                }
                .content {
                    margin-top: 20px;
                }
                .signature {
                    text-align: right;
                    margin-top: 50px;
                    margin-right: 50px;
                }
                p {
                    margin: 0 0 10px;
                    padding: 0;
                }
                .footer {
                    text-align: center;
                    font-size: 10pt;
                    position: fixed;
                    bottom: 0;
                    width: 100%;
                }
            </style>
        </head>
        <body>
            <div class='header'>
                <p>{$city}, {$dateToday}</p>
            </div>
            <div class='content'>
                " . $coverLetterHtml . "
            </div>
        </body>
        </html>";

        $mpdf->WriteHTML($html);

        $fileName = 'Surat_Lamaran.pdf';
        $mpdf->Output($fileName, 'D');

    } catch (\Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>
