<?php
require __DIR__ . '/vendor/autoload.php';

use LucianoTonet\GroqPHP\Groq;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$apiKey = getenv('GROQ_API_KEY');

$coverLetter = ''; // Variável para armazenar a carta de apresentação
$error = ''; // Variável para armazenar mensagens de erro

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $birth_place = $_POST['birth_place'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $email = $_POST['email'];
    $education = $_POST['education'];
    $experience = $_POST['experience'];
    $skills = $_POST['skills'];
    $reason = $_POST['reason'];
    $company = $_POST['company'];
    $position = $_POST['position'];

    $prompt = "Buatkan surat lamaran kerja untuk posisi $position di perusahaan $company dengan nama pelamar $name. 
    Berikut adalah detail lengkapnya: 
    Nama Lengkap: $name
    Tempat, Tanggal Lahir: $birth_place, $dob
    No. HP: $phone
    Alamat: $address
    Domisili: $city
    Email: $email
    Pendidikan: $education
    Pengalaman Kerja: $experience
    Keterampilan: $skills
    Alasan untuk mengambil posisi ini: $reason.";

    try {
        $groq = new Groq($apiKey);

        $chatCompletion = $groq->chat()->completions()->create([
            'model'    => 'mixtral-8x7b-32768',
            'messages' => [
                [
                    'role'    => 'system',
                    'content' => 'Kamu adalah asisten yang membantu pengguna dalam bahasa Indonesia. Buatkan surat lamaran kerja berdasarkan informasi yang diberikan pengguna.'
                ],
                [
                    'role'    => 'user',
                    'content' => $prompt
                ],
            ],
        ]);

        $coverLetter = $chatCompletion['choices'][0]['message']['content'];

        // Hapus bagian yang tidak diinginkan
        $unwantedSection = "Mohon maaf atas ketidakpastian surat dan permohonan, terima kasih.";
        $coverLetter = str_replace($unwantedSection, '', $coverLetter);
    } catch (\Exception $e) {
        $error = 'Error: ' . $e->getMessage();
    }

    $dateToday = date("d F Y");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lihathasilsurat.css">
    <title>Review Surat Lamaran</title>
</head>
<body>
    <h1>Review dan Edit Surat Lamaran</h1>
    <?php if ($error): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php else: ?>
        <form id="coverLetterForm" action="generate_pdf.php" method="post">
            <textarea id="coverLetterTextarea" name="coverLetter" rows="20" cols="80"><?php echo htmlspecialchars(strip_tags($coverLetter)); ?></textarea><br><br>
            <input type="hidden" name="coverLetterHtml" id="coverLetterHtml" value="">
            <input type="submit" value="Download PDF">
        </form>
    <?php endif; ?>
    <a href="bikin.php" class="fixed-button">Kembali ke Surat Lamaran</a>
    <script>
        document.getElementById('coverLetterForm').addEventListener('submit', function() {
            var textareaContent = document.getElementById('coverLetterTextarea').value;
            var coverLetterHtml = textareaContent.replace(/\n/g, '<br>');
            document.getElementById('coverLetterHtml').value = coverLetterHtml;
        });
    </script>
</body>
</html>
