-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 02 Jul 2024 pada 21.58
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Kuadran`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `Username` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`Username`, `Password`, `Email`, `Nama`) VALUES
('admin1', 'adminsatu', 'adminsatu@kuadran.com', 'Rakha'),
('admin2', 'admindua', 'admindua@kuadran.com', 'Ferrel'),
('admin3', 'admintiga', 'admintiga@kuadran.com', 'Dinda'),
('gusti', 'adminempat', 'adminganteng@kuadran.com', 'Gustigg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `nama_acara` varchar(255) NOT NULL,
  `deskripsi_acara` text NOT NULL,
  `tanggal_acara` date NOT NULL,
  `waktu_acara` time NOT NULL,
  `tempat_acara` varchar(255) NOT NULL,
  `kategori_acara` varchar(255) NOT NULL,
  `biaya_pendaftaran` decimal(10,2) NOT NULL,
  `kontak_penyelenggara` varchar(255) NOT NULL,
  `url_pendaftaran` varchar(255) NOT NULL,
  `Instruksi_tambahan` varchar(255) NOT NULL,
  `foto_poster` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `event`
--

INSERT INTO `event` (`id`, `nama_acara`, `deskripsi_acara`, `tanggal_acara`, `waktu_acara`, `tempat_acara`, `kategori_acara`, `biaya_pendaftaran`, `kontak_penyelenggara`, `url_pendaftaran`, `Instruksi_tambahan`, `foto_poster`) VALUES
(12, 'Job Fair Offline UAJY', 'Job fair yang diselenggarakan oleh Universitas Atma Jaya Yogyakarta', '2024-05-14', '09:00:00', 'Universitas Atma Jaya Yogyakarta', 'Job Fair', 0.00, 'Admin', 'https://www.karirfair.com/jf-1099', 'Info selanjutnya hubungi admin.', 'uploads/JOBFAIR.png'),
(14, 'JOBFAIR CAREER EXPO 2024', 'Job fair besar yang diadakan oleh JOBFAIRCOID Yogyakarta.', '2024-06-18', '08:30:00', 'JOBFAIRCOID Yogyakarta', 'Job Fair', 0.00, 'Admin Penyelenggara', 'https://jadwalevent.web.id/jobfair-career-expo-2024-di-sleman-city-hall', 'Info lebih lanjut klik link ', 'uploads/jobfair1.png'),
(15, 'Job Fair Virtual', 'Job fair yang diadakan secara virtual oleh Dinas Sosial Kerja Dan Transmigrasi Kota Yogyakarta.', '2024-07-22', '10:00:00', 'Via Link Zoom', 'Workshop', 0.00, 'Admin Penyelenggara', 'https://www.karirfair.com/jf-1033', 'Hubungi Admin.', 'uploads/jobfair2.png'),
(16, 'Konferensi Bisnis 2024', 'Konferensi bisnis dengan topik tentang strategi pemasaran digital.', '2024-08-10', '11:30:00', 'Hotel Grand Hyatt Bali', 'Konferensi Bisnis', 150000.00, '08765432109', 'http://konferensibisnis2024.com', 'Mohon mengisi formulir pendaftaran dengan benar di website pendaftaran.', 'uploads/konferensi_bisnis_2024.jpg'),
(17, 'Lomba Desain Grafis 2024', 'Lomba desain grafis bagi pelajar dan mahasiswa', '2024-07-30', '13:00:00', 'Universitas Teknologi Yogyakarta', 'Lomba Desain', 50000.00, '08987654321', 'http://lombadesaingrafis2024.com', 'Pastikan file karya telah siap diupload di link yang tertera.', 'uploads/lomba_desain_2024.jpeg'),
(18, 'INTEGRATED CAREER DAYS UII 2024', 'Hai sobat karier!\r\nUniversitas Islam Indonesia (UII) @uiiyogyakarta akan mengadakan acara Integrated Career Days loh! @uiicareer', '2024-06-08', '08:00:00', 'Auditorium Kahar Muzakir, Universitas Islam Indonesia Yogyakarta', 'Job Fair', 0.00, 's.id/ICDUII2024', 's.id/ICDUII2024', 'Pastinya kalian akan dapat banyak insight dan pengalaman baru setelah mengikuti rangkaian acara ini! Jadi, jangan lewatkan ya!', 'uploads/uiievent.jpeg');


-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_pekerjaan`
--

CREATE TABLE `kategori_pekerjaan` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `gaji_min` decimal(10,2) NOT NULL,
  `gaji_max` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_pekerjaan`
--

INSERT INTO `kategori_pekerjaan` (`id`, `nama_kategori`, `gaji_min`, `gaji_max`) VALUES
(1, 'Software Engineer', 50000.00, 120000.00),
(2, 'Accountant', 45000.00, 90000.00),
(3, 'Teacher', 40000.00, 60000.00),
(4, 'Nurse', 45000.00, 80000.00),
(5, 'Marketing Manager', 60000.00, 120000.00),
(6, 'Graphic Designer', 40000.00, 70000.00),
(7, 'Chef', 35000.00, 60000.00),
(8, 'Electrician', 40000.00, 60000.00),
(9, 'Lawyer', 60000.00, 150000.00),
(10, 'Data Analyst', 50000.00, 90000.00),
(11, 'HR Manager', 55000.00, 100000.00),
(12, 'Customer Service Representative', 35000.00, 55000.00),
(13, 'Project Manager', 65000.00, 130000.00),
(14, 'Pharmacist', 90000.00, 130000.00),
(15, 'Architect', 60000.00, 120000.00),
(16, 'Financial Analyst', 55000.00, 110000.00),
(17, 'Web Developer', 50000.00, 100000.00),
(18, 'Sales Representative', 40000.00, 80000.00),
(19, 'Mechanical Engineer', 60000.00, 110000.00),
(20, 'Social Media Manager', 45000.00, 90000.00),
(21, 'Operations Manager', 70000.00, 150000.00),
(22, 'Medical Assistant', 30000.00, 50000.00),
(23, 'Network Administrator', 55000.00, 100000.00),
(24, 'Artist', 25000.00, 60000.00),
(25, 'Physical Therapist', 65000.00, 110000.00),
(26, 'IT Support Specialist', 40000.00, 70000.00),
(27, 'Chef de Cuisine', 40000.00, 80000.00),
(28, 'Executive Assistant', 45000.00, 80000.00),
(29, 'Account Manager', 50000.00, 100000.00),
(30, 'Civil Engineer', 60000.00, 120000.00),
(31, 'Content Writer', 35000.00, 60000.00),
(32, 'Veterinarian', 70000.00, 120000.00),
(33, 'Interior Designer', 45000.00, 90000.00),
(34, 'Actuary', 80000.00, 150000.00),
(35, 'Radiologic Technologist', 45000.00, 80000.00),
(36, 'Software Developer', 55000.00, 110000.00),
(37, 'Advertising Manager', 60000.00, 130000.00),
(38, 'Financial Advisor', 60000.00, 150000.00),
(39, 'E-commerce Specialist', 45000.00, 90000.00),
(40, 'Librarian', 30000.00, 50000.00),
(41, 'Aerospace Engineer', 70000.00, 140000.00),
(42, 'Event Planner', 40000.00, 70000.00),
(43, 'Dental Hygienist', 50000.00, 80000.00),
(44, 'Video Editor', 35000.00, 60000.00),
(45, 'Human Resources Generalist', 50000.00, 90000.00),
(46, 'Product Manager', 80000.00, 150000.00),
(47, 'Electrical Engineer', 60000.00, 120000.00),
(48, 'Marketing Coordinator', 40000.00, 70000.00),
(49, 'Fitness Trainer', 30000.00, 60000.00),
(50, 'Insurance Agent', 35000.00, 70000.00),
(51, 'Curriculum Developer', 45000.00, 80000.00),
(52, 'Legal Assistant', 35000.00, 60000.00),
(53, 'Software Tester', 45000.00, 85000.00),
(54, 'Nurse Practitioner', 80000.00, 130000.00),
(55, 'UI/UX Designer', 55000.00, 110000.00),
(56, 'Real Estate Agent', 50000.00, 100000.00),
(57, 'Operations Coordinator', 40000.00, 65000.00),
(58, 'Biomedical Engineer', 60000.00, 110000.00),
(59, 'Social Worker', 40000.00, 70000.00),
(60, 'Systems Analyst', 55000.00, 100000.00),
(61, 'Fashion Designer', 35000.00, 70000.00),
(62, 'Copywriter', 40000.00, 80000.00),
(63, 'Mechanical Designer', 55000.00, 100000.00),
(64, 'Investment Analyst', 60000.00, 120000.00),
(65, 'Pharmacy Technician', 30000.00, 50000.00),
(66, 'Network Engineer', 60000.00, 110000.00),
(67, 'Game Developer', 55000.00, 120000.00),
(68, 'Account Executive', 50000.00, 100000.00),
(69, 'Business Analyst', 60000.00, 110000.00),
(70, 'Dental Assistant', 25000.00, 45000.00),
(71, 'Creative Director', 80000.00, 150000.00),
(72, 'Chemist', 45000.00, 80000.00),
(73, 'Occupational Therapist', 60000.00, 100000.00),
(74, 'Legal Counsel', 70000.00, 150000.00),
(75, 'IT Consultant', 65000.00, 120000.00),
(76, 'Project Coordinator', 40000.00, 70000.00),
(77, 'Physical Therapist Assistant', 45000.00, 80000.00),
(78, 'Environmental Engineer', 55000.00, 100000.00),
(79, 'Customer Success Manager', 60000.00, 120000.00),
(80, 'Musician', 20000.00, 80000.00),
(81, 'SEO Specialist', 45000.00, 90000.00),
(82, 'Logistics Coordinator', 35000.00, 60000.00),
(83, 'Medical Technologist', 45000.00, 75000.00),
(84, 'Animator', 45000.00, 90000.00),
(85, 'Financial Controller', 80000.00, 150000.00),
(86, 'IT Project Manager', 70000.00, 130000.00),
(87, 'Veterinary Technician', 30000.00, 50000.00),
(88, 'Product Designer', 1000000.00, 99000000.00),
(89, 'Academic Advisor', 40000.00, 65000.00),
(90, 'Supply Chain Manager', 60000.00, 120000.00),
(91, 'Multimedia Artist', 35000.00, 60000.00),
(92, 'Investment Banker', 80000.00, 200000.00),
(93, 'Office Manager', 45000.00, 80000.00),
(94, 'Content Strategist', 50000.00, 100000.00),
(95, 'Security Analyst', 65000.00, 120000.00),
(96, 'Public Relations Specialist', 40000.00, 75000.00),
(97, 'Landscape Architect', 55000.00, 100000.00),
(98, 'Respiratory Therapist', 50000.00, 90000.00),
(99, 'Risk Manager', 70000.00, 130000.00),
(100, 'Technical Writer', 45000.00, 85000.00),
(101, 'Notary Public', 20000.00, 750000.00),
(102, 'Staff', 650000.00, 1010000.00),
(103, 'Lecturer', 750000.00, 120000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `loker`
--

CREATE TABLE `loker` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kategori_pekerjaan_id` int(11) NOT NULL,
  `posisi` varchar(255) NOT NULL,
  `tingkat_pendidikan` varchar(255) NOT NULL,
  `gender` enum('Laki-laki','Perempuan','Semua') NOT NULL,
  `status_kerja` enum('Full-time','Part-time','Kontrak') NOT NULL,
  `besaran_gaji` decimal(10,2) NOT NULL,
  `lokasi_bekerja` varchar(255) NOT NULL,
  `syarat_pekerjaan` text NOT NULL,
  `tanggal_dipost` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `loker`
--

INSERT INTO `loker` (`id`, `user_id`, `kategori_pekerjaan_id`, `posisi`, `tingkat_pendidikan`, `gender`, `status_kerja`, `besaran_gaji`, `lokasi_bekerja`, `syarat_pekerjaan`, `tanggal_dipost`) VALUES
(96, 15, 1, 'FullStack Developer', 'SMA', 'Laki-laki', 'Full-time', 25000000.00, 'Singapore', 'A list of qualifications and skills required for the job. This can include educational background, work experience, technical skills, and any other relevant requirements.', '2024-06-29 18:04:31'),
(97, 15, 101, 'Staff Notaris', 'S1 HUKUM', 'Perempuan', 'Part-time', 50000000.00, 'Kantor Notaris dan PPAT Windri Astuti Wismi Suprihatin, SH\r\nJl. Langenastran Kidul No. 43 A, Panembahan, Kraton, Yogyakarta.', '\r\n\r\n- Wanita\r\n- Pendidikan minimal SMA/K diutamakan jurusan Administrasi Perkantoran\r\n- Usia maksimal 30 tahun\r\n- Dapat mengopeerasikan Komputer (Ms. Word/Excel/sejenisnya)\r\n- Berpengalaman atau Freshgraduate\r\n- Mempunyai kendaraan sendiri (Punya SIM C)\r\n- Jujur, disiplin, teliti dan mampu bekerja individu dan tim', '2024-06-29 19:24:03'),
(98, 17, 86, 'Information Technology Programmer', 'SMK/S1', 'Laki-laki', 'Full-time', 10000000.00, 'PT Telkom Indonesia (Persero) Tbk', '• Pria / Wanita Min 21 Tahun ke atas\r\n• Pendidikan Minimal SMK & D3.S1 Semua Jurusan\r\n• Ipk Minimal 2,75\r\n• Berpenampilan Menarik\r\n• Komunikatif\r\n• Mampu Mengoperasikan Komputer\r\n• Berwawasan Luas\r\n• Berkepribadian Baik\r\n• Siap Ditempatkan Diseluruh Caban Terdekat', '2024-06-29 20:19:31'),
(99, 17, 10, 'Data Analyst', ' S1, S2, Diploma, SMA', 'Semua', 'Full-time', 15000000.00, 'Yogyakarta', 'Menguasai bahasa pemrograman Java', '2024-06-29 21:24:04'),
(100, 17, 46, 'Product Management', 'S2', 'Semua', 'Kontrak', 1000000.00, 'Sleman, Yogyakarta.', 'Pengalaman minimal 2 tahun di bidang terkait', '2024-06-29 21:26:29'),
(101, 17, 2, 'Administration & Secretarial', 'SMK & D3.S1. Semua Jurusan', 'Semua', 'Full-time', 5000000.00, 'PT Telkom Indonesia (Persero) Tbk, Yogyakarta.', '• Ipk Minimal 2,75\r\n• Berpenampilan Menarik\r\n• Komunikatif\r\n• Mampu Mengoperasikan Komputer\r\n• Berwawasan Luas\r\n• Berkepribadian Baik\r\n• Siap Ditempatkan Diseluruh Caban Terdekat', '2024-06-30 22:52:37'),
(102, 17, 76, 'Software Documentation Engineer', 'SMA', 'Semua', 'Kontrak', 7500000.00, 'Yogyakarta', '• Ipk Minimal 2,75\r\n• Berpenampilan Menarik\r\n• Komunikatif\r\n• Mampu Mengoperasikan Komputer\r\n• Berwawasan Luas\r\n• Berkepribadian Baik\r\n• Siap Ditempatkan Diseluruh Cabang Terdekat', '2024-06-30 22:55:12'),
(103, 17, 10, 'Data Analyst Telkom', ' S1, S2, Diploma, SMA', 'Laki-laki', 'Kontrak', 1750000.00, 'Telkom Yogyakarta', 'IPK Minimal : 2.75', '2024-07-01 13:02:31'),
(104, 16, 36, 'Back-End Developer', 'SMK/S1', 'Laki-laki', 'Part-time', 25000000.00, 'Telkom Sleman, Yogyakarta.', 'IPK : 2.75', '2024-07-01 13:13:14'),
(105, 16, 10, 'Data Business Analyst', 'S1 Sains Data', 'Laki-laki', 'Part-time', 75000000.00, 'Yogyakarta, Gamping.', 'Pintar', '2024-07-01 19:30:35'),
(106, 16, 102, 'Area Operations Staff ', 'SMA', 'Semua', 'Full-time', 2750000.00, 'Tangerang', 'Keterampilan interpersonal yang kuat untuk melayani dan membangun hubungan dengan berbagai pemangku kepentingan\r\nKeterampilan komunikasi tertulis & verbal yang sangat baik berfokus pada peningkatan kolaborasi, pemahaman, dan pertukaran informasi di seluruh pemangku kepentingan\r\nPerhatian yang tajam terhadap detail untuk meningkatkan produktivitas dan mengurangi kemungkinan kesalahan\r\nPerencanaan dan kemampuan organisasi yang sangat baik untuk memastikan tim area berada pada jalur yang tepat untuk mencapai tujuannya\r\nPemahaman tentang/keakraban dengan wilayah Tangerang', '2024-07-02 17:28:51'),
(107, 16, 10, 'Marketing Analyst', 'S1 Sains Data', 'Perempuan', 'Full-time', 7500000.00, 'Yogyakarta, Kantor Gojek', 'Pengalaman mempersiapkan dan mengembangkan laporan kampanye atau berbagai laporan bisnis yang kompleks\r\nPengalaman mengembangkan segmentasi pengguna dan melaksanakan dorongan pengguna dan kampanye CRM atau Pemasaran Digital\r\n', '2024-07-02 17:30:29'),
(108, 15, 103, 'Dosen Sistem Informasi', 'S3/ M.S.i', 'Laki-laki', 'Full-time', 125000.00, 'Universitas Islam Indonesia', '1.    Lulusan S2 atau S3 pada prodi yang terakreditasi minimal B.\r\n2.    S1, S2 linier.\r\n3.    IPK minimal 3,25.\r\n4.    Usia calon dosen S2 maksimal 35 tahun; S3 maksimal 45 tahun.\r\n5.    Berkelakuan baik yang dibuktikan dengan Surat Keterangan Catatan Kepolisian (SKCK).\r\n6.    Sehat jasmani, rohani dan bebas narkoba (dibuktikan dengan surat keterangan dari dokter).\r\n7.    Tidak memiliki NIDN / menyerahkan surat lulus butuh jika memiliki NIDN.\r\n8.    Tidak berkedudukan sebagai calon pegawai/pegawai tetap/pegawai kontrak di instansi lain (dibuktikan dengan surat pernyataan/lolos butuh).', '2024-07-02 18:28:33'),
(109, 16, 1, 'Software Engineer (Backend)', 'S1 Sains Data, S1 Informatika', 'Semua', 'Part-time', 25000000.00, 'Perusahaan GOJEK Indonesia Yogyakarta', '• Setidaknya 2 tahun pengalaman pengembangan perangkat lunak yang relevan melalui tugas magang dan/atau proyek perguruan tinggi\r\n• Keterampilan yang baik dalam desain, pengembangan, pengujian dan penerapan aplikasi pada aplikasi skala besar Golang atau Erlang atau Ruby atau Java\r\n• Memiliki pemahaman mendalam tentang setidaknya satu bahasa pemrograman dan kerangka kerja\r\n• Mahir dalam OOP, SQL, Struktur Data dan Algoritma\r\n• Pengalaman pemodelan data dalam database Relasional\r\n• Kemampuan untuk menjangkau, meninjau, dan menyempurnakan cerita pengguna untuk kelengkapan teknis dan mengurangi risiko ketergantungan', '2024-07-02 18:38:26'),
(110, 16, 5, 'Digital Performance Marketing Specialist Gojek', 'S1 Manajemen', 'Perempuan', 'Full-time', 20000000.00, 'Perusahaan GOJEK Indonesia Yogyakarta', '• 3+ tahun pengalaman pemasaran digital\r\n• Kemahiran dalam alat dan platform pemasaran digital\r\n• Keterampilan analitis, komunikasi, dan pemecahan masalah yang kuat\r\n• Gelar sarjana di bidang Pemasaran, Komunikasi, atau bidang terkait\r\n• Fasih berbahasa Inggris, (dengan kemampuan berbahasa Vietnam sebagai nilai tambah).\r\n• Daftarkan diri kamu melalui: Gojek Careers: Digital Performance Marketing Specialist Gojek', '2024-07-02 18:40:11'),
(111, 16, 88, 'Product Management', ' S1, S2, Diploma, SMA', 'Perempuan', 'Part-time', 12500000.00, 'Yogyakarta Designer GOJEK', 'Kreatif dalam mendesain.', '2024-07-02 18:53:17'),
(112, 16, 17, 'Information Technology Programmer', 'SMA/SMK', 'Laki-laki', 'Part-time', 15000000.00, 'Yogyakarta, Sleman, Candirejo.', 'Pintar mendesain web menggunakan berbagai tools.', '2024-07-02 18:54:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `paketloker`
--

CREATE TABLE `paketloker` (
  `package_id` int(11) NOT NULL,
  `nama_paket` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `price` decimal(10,2) NOT NULL,
  `limit_publish` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `paketloker`
--

INSERT INTO `paketloker` (`package_id`, `nama_paket`, `created_at`, `updated_at`, `price`, `limit_publish`) VALUES
(1, 'Gold', '2024-06-28 18:29:18', '2024-06-30 21:21:52', 400000.00, 5),
(2, 'Silver', '2024-06-28 18:29:18', '2024-06-30 21:22:08', 175000.00, 2),
(3, 'Bronze', '2024-06-28 18:29:18', '2024-06-30 21:22:21', 50000.00, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `transaction_status` varchar(50) NOT NULL,
  `gross_amount` decimal(10,2) NOT NULL,
  `payment_type` varchar(50) DEFAULT NULL,
  `transaction_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) NOT NULL,
  `industri` varchar(255) NOT NULL,
  `deskripsi_perusahaan` varchar(10000) NOT NULL,
  `media_sosial` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `alamat_perusahaan` text DEFAULT NULL,
  `logo_perusahaan` varchar(255) DEFAULT '',
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` enum('menunggu','ditolak','diterima') DEFAULT 'menunggu',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `package_purchased` tinyint(1) DEFAULT 0,
  `limit_publish_users` int(255) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama_perusahaan`, `industri`, `deskripsi_perusahaan`, `media_sosial`, `website`, `alamat_perusahaan`, `logo_perusahaan`, `username`, `password`, `status`, `created_at`, `updated_at`, `package_purchased`, `limit_publish_users`) VALUES
(15, 'PT. Teknologi Inovatif Indonesia', 'Teknologi Informasi', 'PT. Teknologi Inovatif Indonesia adalah perusahaan yang bergerak di bidang pengembangan perangkat lunak dan solusi teknologi informasi. Kami berfokus pada inovasi dan kualitas untuk memberikan solusi terbaik kepada pelanggan kami.\r\n', 'Facebook: PT. Teknologi Inovatif Indonesia Instagram: @tekinovindo LinkedIn: PT. Teknologi Inovatif Indonesia', 'www.tekinovindo.co.id', 'Jl. Pahlawan No. 123, Sleman, DI Yogyakarta, 10130', 'uploads/Teknovindo2.png', 'teknovindo2', '$2y$10$GYLu4fA3Mn2d0ONwTDSs0eFIIpHI5Kyz.2ybvJYQHTxZEAaLcbIrS', 'diterima', '2024-07-02 19:31:07', '2024-07-02 19:37:53', 0, 0),
(16, 'Gojek Indonesia', 'Teknologi dan Jasa Antar', 'Gojek adalah perusahaan teknologi asal Indonesia yang menyediakan berbagai layanan mulai dari transportasi, pengiriman makanan, pembayaran digital, hingga layanan keuangan dan logistik. Gojek didirikan pada tahun 2010 dan telah berkembang menjadi salah satu startup terbesar di Asia Tenggara.\r\n', 'Instagram: @gojekindonesia Twitter: @gojekindonesia Facebook: Gojek', 'www.gojek.com', 'Jl. Kemang Timur No. 21, RT.14/RW.8, Bangka, Kec. Mampang Prpt., Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12730, Indonesia', 'uploads/gojekindo2.png', 'gojek_user2', '$2y$10$1oerj0SQO7NuhKlUEG4/x.Q6mu8RtRr/dVhGmaoCuU54RiBnaPXKu', 'diterima', '2024-07-02 19:45:41', '2024-07-02 19:49:42', 0, 0),
(17, 'PT Telkom Indonesia', 'Telekomunikasi', 'PT Telkom Indonesia adalah perusahaan telekomunikasi terbesar di Indonesia yang menyediakan layanan telekomunikasi dan jaringan.', 'https://facebook.com/telkomindonesia', 'https://www.telkom.co.id', 'Jl. Japati No. 1, Bandung', 'uploads/telkomsel2.png', 'telkom2', '$2y$10$auQN2gtjO204UBMY8GGAv.Xhf8XvdkodSl9KT7pC92/CEBxm7fJ3G', 'diterima', '2024-07-02 19:53:23', '2024-07-02 19:56:55', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_pekerjaan`
--
ALTER TABLE `kategori_pekerjaan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `loker`
--
ALTER TABLE `loker`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_user_loker` (`user_id`),
  ADD KEY `FK_kategori_pekerjaan_loker` (`kategori_pekerjaan_id`);

--
-- Indeks untuk tabel `paketloker`
--
ALTER TABLE `paketloker`
  ADD PRIMARY KEY (`package_id`);

--
-- Indeks untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`),
  ADD KEY `fk_package` (`package_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `kategori_pekerjaan`
--
ALTER TABLE `kategori_pekerjaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT untuk tabel `loker`
--
ALTER TABLE `loker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT untuk tabel `paketloker`
--
ALTER TABLE `paketloker`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `loker`
--
ALTER TABLE `loker`
  ADD CONSTRAINT `FK_nama_kategori_loker` FOREIGN KEY (`kategori_pekerjaan_id`) REFERENCES `kategori_pekerjaan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_user_loker` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_package` FOREIGN KEY (`package_id`) REFERENCES `paketloker` (`package_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
