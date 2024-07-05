<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/koneksi.php'; // Include file koneksi database
use LucianoTonet\GroqPHP\Groq;

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$apiKey = getenv('GROQ_API_KEY');

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$question = $input['question'] ?? '';

if (!$question) {
    echo json_encode(['error' => 'Pertanyaan tidak boleh kosong']);
    exit;
}

// Cari jawaban di database
$query = $koneksi->prepare("SELECT posisi, lokasi_bekerja, syarat_pekerjaan FROM loker WHERE posisi LIKE ? OR lokasi_bekerja LIKE ? OR syarat_pekerjaan LIKE ?");
$searchTerm = '%' . $question . '%';
$query->bind_param('sss', $searchTerm, $searchTerm, $searchTerm);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $response = [];
    while ($row = $result->fetch_assoc()) {
        $response[] = [
            'posisi' => $row['posisi'],
            'lokasi_bekerja' => $row['lokasi_bekerja'],
            'syarat_pekerjaan' => $row['syarat_pekerjaan'],
        ];
    }
    echo json_encode(['answer' => $response]);
} else {
    // Jika tidak ada jawaban di database, panggil Groq API
    try {
        $groq = new Groq($apiKey);

        $chatCompletion = $groq->chat()->completions()->create([
            'model'    => 'mixtral-8x7b-32768', // Sesuaikan dengan model yang Anda gunakan
            'messages' => [
                [
                    'role'    => 'system',
                    'content' => 'Kamu adalah asisten yang membantu pengguna dalam bahasa Indonesia. Hanya menjawab seputaran pekerjaan saja, tapi membalas sapaan
                    jika pertanyaan user melenceng dari topik, cukup balas dengan Mohon Maaf Saya Tidak Dapat Menjawab.'
                ],
                [
                    'role'    => 'user',
                    'content' => $question
                ],
            ],
        ]);

        $answer = $chatCompletion['choices'][0]['message']['content'];
        echo json_encode(['answer' => $answer]);
    } catch (\Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
