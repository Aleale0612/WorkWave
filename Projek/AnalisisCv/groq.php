<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hasil Analisis CV dan Surat Lamaran</title>
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 20px;
        background: linear-gradient(to right, #74ebd5, #acb6e5);
        color: #333;
        text-align: center;
    }
    .analysis-result {
        background-color: #ffffff;
        border: 1px solid #ddd;
        padding: 30px;
        margin: auto;
        margin-top: 40px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        text-align: left;
    }
    h1 {
        color: #34495e;
        font-size: 28px;
        margin-bottom: 20px;
        text-align: center;
    }
    p {
        color: #555;
        font-size: 16px;
        line-height: 1.8;
    }
    .error {
        color: #c0392b;
        font-weight: bold;
    }
    input[type="submit"] {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    input[type="submit"]:hover {
        background-color: #2980b9;
    }
</style>


</head>
<body>
<?php
require __DIR__ . '/vendor/autoload.php';

use Smalot\PdfParser\Parser;
use LucianoTonet\GroqPHP\Groq;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$apiKey = getenv('GROQ_API_KEY');

function pdfToText($filePath) {
    $parser = new Parser();
    $pdf = $parser->parseFile($filePath);
    return $pdf->getText();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cvFile = $_FILES['cv']['tmp_name'];
    $coverLetterFile = $_FILES['cover_letter']['tmp_name'];

    $cvText = pdfToText($cvFile);
    $coverLetterText = pdfToText($coverLetterFile);

    try {
        $groq = new Groq($apiKey);

        $sysPrompt = "Analisis CV dan surat lamaran yang disediakan. Soroti kekuatan dan kelemahan yang terdapat pada lamaran. 
        Manfaatkan konteks yang disediakan untuk informasi yang akurat dan spesifik dan pertimbangan menurut kamu tentang dia jika ingin masuk kedalam perusahaan ini.
        berikan juga persentase % dia dari 100% kemampuannya DALAM BAHASA INDONESIA";
        $userPrompt = "CV: $cvText\nCover Letter: $coverLetterText";

        $chatCompletion = $groq->chat()->completions()->create([
            'model'    => 'mixtral-8x7b-32768',
            'messages' => [
                [
                    'role'    => 'system',
                    'content' => $sysPrompt
                ],
                [
                    'role'    => 'user',
                    'content' => $userPrompt
                ],
            ],
        ]);
        $answer = nl2br($chatCompletion['choices'][0]['message']['content']);
        echo "<div class='analysis-result'><h1>Hasil Analisis</h1><p>" . $answer . "</p></div>";
    } catch (\Exception $e) {
        echo "<div class='analysis-result error'><h1>Error</h1><p>" . $e->getMessage() . "</p></div>";
    }
} else {
    include 'form.html';
}
?>
</body>
</html>