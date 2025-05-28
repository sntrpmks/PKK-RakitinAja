-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 28 Bulan Mei 2025 pada 16.01
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rakitinaja`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bundle`
--

CREATE TABLE `bundle` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bundle`
--

INSERT INTO `bundle` (`id`, `nama`, `deskripsi`, `harga`, `gambar`, `created_at`) VALUES
(3, 'RAKITAN PC BUDGET PELAJAR', 'PC ini dirakit dengan fokus pada penggunaan sehari-hari dan kemampuan gaming ringan hingga menengah dengan anggaran terbatas. Ditenagai oleh prosesor Intel Core i5-3470, sebuah CPU generasi ketiga yang masih mumpuni untuk tugas-tugas komputasi standar. Untuk mendukung kinerja, PC ini dilengkapi dengan total 8GB RAM Kingston DDR3 (2 keping x 4GB), yang cukup untuk multitasking dan aplikasi umum.\r\n\r\nPenyimpanan data mengandalkan kombinasi kecepatan dan kapasitas, yaitu SSD V-GeN SATA 256GB untuk sistem operasi Windows 10 Pro dan aplikasi agar berjalan responsif, serta Hardisk Western Digital Blue 500GB untuk penyimpanan data yang lebih besar.\r\n\r\nUntuk kebutuhan grafis dan gaming, terpasang kartu grafis Gigabyte GeForce GTX 1050 Ti 4GB. Kartu grafis ini mampu menjalankan berbagai game eSports populer dan judul game AAA lama pada resolusi 1080p dengan pengaturan yang disesuaikan.\r\n\r\nSeluruh komponen ini ditenagai oleh Power Supply Corsair VS450 450 Watt 80 Plus White Certified yang menyediakan daya yang cukup dan efisien. Keseluruhan sistem dirakit dalam Casing PC Gamen GCS100 dan sudah termasuk lisensi Windows 10 Pro Original Lifetime.\r\n\r\nSecara keseluruhan, rakitan ini menawarkan keseimbangan antara harga dan performa untuk pengguna yang mencari PC fungsional untuk pekerjaan, hiburan multimedia, dan pengalaman gaming pada tingkat awal hingga menengah.', 3800000.00, '6834761244a03.png', '2025-05-26 14:09:22'),
(4, 'RAKITAN PC GAMING', 'PC rakitan ini ditenagai oleh prosesor AMD Ryzen 3 3200G dengan grafis terintegrasi Radeon Vega 8, yang dipasangkan pada motherboard Asus Prime A520M-K. Untuk memori, sistem ini menggunakan RAM Kingston HyperX FURY DDR4 8GB sebanyak dua keping (total 16GB) dengan kecepatan 2666MHz. Penyimpanan utama menggunakan SSD NVMe PNY M.2 berkapasitas 512GB, didukung oleh SSD V-GeN SATA 2.5 inci berkapasitas 256GB sebagai penyimpanan sekunder. Semua komponen ini dibalut dalam casing gaming Armaggeddon NIMITZ N7 dan ditenagai oleh Corsair TX550M 80 Plus Gold. Untuk kemampuan grafis diskrit, PC ini dilengkapi dengan kartu grafis Gigabyte GeForce RTX 3050 Windforce OC 6GB GDDR6.', 10000000.00, '6836e0c6a2421.jpg', '2025-05-28 10:09:10'),
(5, 'RAKITAN PC SULTAN', 'PC rakitan ini dirancang untuk performa tinggi, ditenagai oleh prosesor Intel Core i7-12700F dengan kecepatan hingga 4.9GHz yang terpasang pada motherboard ASUS ROG STRIX B760-F GAMING WIFI LGA1700. Untuk memori, sistem ini menggunakan satu keping RAM Kingston Fury Beast DDR5 RGB berkapasitas 16GB dengan kecepatan 5600MHz. Kemampuan grafisnya didukung oleh kartu grafis MSI GeForce RTX 4070 GAMING X TRIO 12G. Penyimpanan utama mengandalkan SSD NVMe PNY M.2 berkapasitas 512GB. Seluruh komponen ini ditenagai oleh Corsair TX550M 80 Plus Gold dan dirakit dalam casing Acer V950W White Tempered Glass ATX, dengan penggunaan pasta termal Deepcool DM9 untuk pendinginan prosesor yang optimal.', 25000000.00, '6836e5e2adb8c.jpg', '2025-05-28 10:30:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bundle_items`
--

CREATE TABLE `bundle_items` (
  `id` int(11) NOT NULL,
  `bundle_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bundle_items`
--

INSERT INTO `bundle_items` (`id`, `bundle_id`, `produk_id`, `qty`) VALUES
(41, 4, 17, 1),
(42, 4, 20, 1),
(43, 4, 29, 1),
(44, 4, 19, 2),
(45, 4, 25, 1),
(46, 4, 13, 1),
(47, 4, 21, 1),
(48, 4, 24, 1),
(49, 4, 23, 1),
(50, 5, 18, 1),
(51, 5, 32, 1),
(52, 5, 31, 2),
(53, 5, 26, 1),
(54, 5, 25, 2),
(55, 5, 21, 1),
(56, 5, 30, 1),
(57, 5, 28, 1),
(58, 5, 23, 1),
(62, 3, 3, 1),
(63, 3, 15, 1),
(64, 3, 11, 2),
(65, 3, 12, 1),
(66, 3, 22, 1),
(67, 3, 14, 1),
(68, 3, 16, 1),
(69, 3, 13, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `transaksi_id`, `produk_id`, `jumlah`, `harga`, `subtotal`) VALUES
(9, 17, 3, 1, 175000.00, 175000.00),
(10, 17, 15, 1, 355000.00, 355000.00),
(11, 17, 11, 2, 74000.00, 148000.00),
(12, 17, 12, 1, 120000.00, 120000.00),
(13, 17, 22, 1, 325000.00, 325000.00),
(14, 17, 14, 1, 450000.00, 450000.00),
(15, 17, 16, 1, 2149998.00, 2149998.00),
(16, 17, 13, 1, 255000.00, 255000.00),
(18, 19, 16, 1, 2149998.00, 2149998.00),
(28, 21, 3, 1, 175000.00, 175000.00),
(29, 21, 15, 1, 355000.00, 355000.00),
(30, 21, 11, 2, 74000.00, 148000.00),
(31, 21, 12, 1, 120000.00, 120000.00),
(32, 21, 22, 1, 325000.00, 325000.00),
(33, 21, 14, 1, 450000.00, 450000.00),
(34, 21, 16, 1, 2149998.00, 2149998.00),
(35, 21, 13, 1, 255000.00, 255000.00),
(36, 22, 17, 1, 1136000.00, 1136000.00),
(37, 23, 3, 1, 175000.00, 175000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `konfigurasi_pc`
--

CREATE TABLE `konfigurasi_pc` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `komponen` text NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `spesifikasi` text NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `gambar` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `kategori`, `spesifikasi`, `harga`, `stok`, `gambar`, `created_at`) VALUES
(3, 'Intel Core i5 3470', 'Processor', 'Nama: Intel® Core™ i5-3470\r\nGenerasi: Ivy Bridge (Generasi ke-3)\r\nJumlah Inti (Cores): 4\r\nJumlah Untaian (Threads): 4\r\nFrekuensi Dasar: 3.20 GHz\r\nFrekuensi Turbo Maksimal: 3.60 GHz\r\nCache: 6 MB Intel® Smart Cache\r\nGrafis Terintegrasi: Intel® HD Graphics 2500\r\nTDP (Daya Desain Termal): 77 W\r\nSoket: LGA1155', 175000.00, 32, 'S8346d9cd341b4f968b1516d5a176f546I.jpg', '2025-05-25 19:59:58'),
(10, 'Motherboard ASUS H61M-K LGA 1155', 'Motherboard', 'Soket CPU: Intel® Socket 1155\r\nDukungan CPU: Prosesor Intel® Core™ i7/Core™ i5/Core™ i3/Pentium®/Celeron® Generasi ke-2 dan ke-3 (Mendukung CPU Intel® 22 nm dan 32 nm, hingga 77W)\r\nChipset: Intel® H61(B3) Express Chipset\r\nMemori:\r\n2 x Slot DIMM DDR3\r\nMendukung hingga 16GB\r\nArsitektur Memori Dual Channel\r\nMendukung DDR3 2200(O.C.)/2133(O.C.)/2000(O.C.)/1866(O.C.)/1600/1333/1066 MHz Non-ECC, Un-buffered Memory\r\nCatatan: Frekuensi 1600MHz ke atas didukung oleh prosesor Intel® Generasi ke-3.\r\nGrafis:\r\nProsesor Grafis Terintegrasi (tergantung CPU)\r\nDukungan output Multi-VGA: Port DVI dan D-Sub (RGB)\r\nDVI dengan resolusi maks. 1920 x 1200 @ 60 Hz\r\nD-Sub dengan resolusi maks. 2048 x 1536 @ 75 Hz\r\nMemori bersama maksimum 1024 MB\r\nSlot Ekspansi:\r\n1 x PCIe 3.0/2.0 x16 (PCIe 3.0 didukung oleh prosesor Intel® Generasi ke-3)\r\n2 x PCIe 2.0 x1\r\nPenyimpanan:\r\n4 x Port SATA 3Gb/s (biru)\r\nLAN (Jaringan):\r\nRealtek® 8111F, 1 x Gigabit LAN Controller\r\nAudio:\r\nRealtek® ALC887 8-Channel High Definition Audio CODEC\r\nPort USB:\r\nTotal 8 x port USB 2.0 (4 di panel belakang, 4 di tengah board melalui header internal)\r\nPort I/O Belakang:\r\n1 x PS/2 keyboard (ungu)\r\n1 x PS/2 mouse (hijau)\r\n1 x DVI\r\n1 x D-Sub (VGA)\r\n1 x Port LAN (RJ45)\r\n4 x USB 2.0\r\n3 x Jack audio\r\nKonektor I/O Internal:\r\n2 x Konektor USB 2.0 (mendukung tambahan 4 port USB 2.0)\r\n4 x Konektor SATA 3Gb/s\r\n1 x Konektor Kipas CPU (4-pin)\r\n1 x Konektor Kipas Sasis (4-pin)\r\n1 x Konektor daya EATX 24-pin\r\n1 x Konektor daya ATX 12V 4-pin\r\n1 x Konektor panel depan\r\n1 x Konektor audio panel depan (AAFP)\r\n1 x Konektor speaker internal\r\n1 x Jumper Clear CMOS\r\nBIOS: 64Mb Flash ROM, UEFI BIOS, PnP, DMI v2.0, WfM2.0, SMBIOS v2.7, ACPI v2.0a\r\nForm Factor (Bentuk): uATX (Micro-ATX), 8.9 inci x 6.9 inci (22.6 cm x 17.5 cm)\r\nFitur Khusus ASUS (Beberapa di antaranya):\r\nASUS UEFI BIOS EZ Mode\r\nAI Suite II\r\nAi Charger\r\nAnti-Surge\r\nNetwork iControl\r\nASUS Fan Xpert', 335000.00, 23, '5900aa62-d2f3-4b9e-82e2-877fa048c71c.jpg', '2025-05-26 20:21:08'),
(11, 'Kingston DDR3 Memory [4 GB]', 'RAM', 'Kapasitas: 4 GB\r\nTipe Memori: DDR3\r\nKecepatan (Frekuensi): Umumnya tersedia dalam:\r\n1333MHz (PC3-10600)\r\n1600MHz (PC3-12800)\r\nFaktor Bentuk (Form Factor):\r\nDIMM (untuk PC Desktop)', 74000.00, 21, '8b2624d9d12bc7a2c3eca9e63130d7bc.jpeg', '2025-05-26 20:23:19'),
(12, 'Hardisk 500GB WD Blue Sata 3.5 HDD', 'Storage', 'Merek: Western Digital (WD)\r\nSeri: Blue (umumnya ditujukan untuk penggunaan komputasi sehari-hari pada PC Desktop)\r\nKapasitas: 500GB\r\nFaktor Bentuk: 3.5 inci (standar untuk hardisk PC desktop)\r\nAntarmuka (Interface): SATA III (SATA 6 Gb/s)\r\nKecepatan Putaran (RPM): Umumnya 7200 RPM (Rotation Per Minute), meskipun beberapa model WD Blue dengan kapasitas lain mungkin memiliki variasi RPM.\r\nCache (Buffer Size): Bervariasi tergantung model spesifik, umumnya antara 16MB hingga 32MB untuk kapasitas ini.\r\nPenggunaan Utama: Dirancang sebagai penyimpanan internal untuk komputer desktop (PC).', 120000.00, 32, 'wd_wd-hardisk-500gb--sata-blue_full02.jpg', '2025-05-26 20:25:12'),
(13, 'SSD VGen 256GB SATA 2,5\" - VGeN Solid State Drive 256GB SATA 3 2,5\"', 'Storage', 'Merek: V-GeN\r\nKapasitas: 256 GB\r\nFaktor Bentuk (Form Factor): 2,5 inci\r\nAntarmuka (Interface): SATA III (SATA 3), dengan kecepatan transfer hingga 6 Gb/s\r\nKecepatan Baca (Read Speed): Umumnya hingga sekitar 500-550 MB/s (tergantung model spesifik, misal seri Platinum)\r\nKecepatan Tulis (Write Speed): Umumnya hingga sekitar 400-480 MB/s (tergantung model spesifik)\r\nDimensi: Standar 2,5 inci, seringkali sekitar 100 x 70 x 6 atau 7 mm\r\nSeri Produk (Contoh): V-GeN memiliki beberapa seri, seperti \"Platinum\" atau \"Rescue\", yang mungkin memiliki sedikit perbedaan dalam performa atau fitur.\r\nFitur Umum:\r\nTRIM Support (membutuhkan dukungan OS)\r\nS.M.A.R.T Monitoring\r\nGarbage Collection\r\nNCQ (Native Command Queuing)\r\nBeberapa model mungkin menyertakan enkripsi AES 256-bit.\r\nPenggunaan Utama: Cocok untuk upgrade dari HDD tradisional pada laptop atau PC desktop untuk meningkatkan kecepatan booting, waktu muat aplikasi, dan responsivitas sistem secara keseluruhan.', 255000.00, 11, 'e9a3dc9cb0e9ae199f9e05207b63b6f3.jpeg', '2025-05-26 20:27:11'),
(14, 'Corsair Vs450 Watt 80 Plus White Certified Psu - Power Supply Buka', 'Power Supply', 'Merek: Corsair\r\nSeri: VS Series (VS450)\r\nKapasitas Daya: 450 Watt\r\nSertifikasi Efisiensi: 80 PLUS White (sering juga disebut 80 PLUS Standard), yang menjamin efisiensi minimal 80% pada berbagai tingkat beban (20%, 50%, 100%).\r\nFaktor Bentuk (Form Factor): ATX12V v2.31 (kompatibel dengan ATX12V 2.2 dan versi sebelumnya)\r\nVoltase Input AC: 100-240V (Universal Input, namun model lama mungkin spesifik 200-240V atau 100-120V tergantung regional, selalu periksa label unit)\r\nKipas Pendingin: 120mm fan dengan kontrol kecepatan termal (kipas berputar lebih cepat saat suhu meningkat).\r\nKabel:\r\nJenis Kabel: Sleeved, Non-Modular (kabel terpasang permanen)\r\nKonektor Utama:\r\n1x ATX Connector 24 pin (20+4)\r\n1x EPS/ATX12V 8 pin (4+4) CPU Connector\r\n1 atau 2x PCI-E 8 pin (6+2) Connector (jumlah bisa bervariasi tergantung revisi)\r\nBeberapa konektor SATA (biasanya 4 hingga 7)\r\nBeberapa konektor PATA/Molex (biasanya 2 hingga 4)\r\nBeberapa model mungkin menyertakan konektor Floppy (FDD)\r\nFitur Proteksi: Umumnya dilengkapi dengan berbagai proteksi standar, yang bisa meliputi:\r\nOVP (Over Voltage Protection / Proteksi Tegangan Lebih)\r\nUVP (Under Voltage Protection / Proteksi Tegangan Kurang)\r\nSCP (Short Circuit Protection / Proteksi Hubungan Singkat)\r\nOPP (Over Power Protection / Proteksi Daya Lebih)\r\nOTP (Over Temperature Protection / Proteksi Suhu Lebih) - tidak selalu ada di semua revisi VS series entry-level\r\nMTBF (Mean Time Between Failures): Seringkali sekitar 100.000 jam.\r\nDimensi: Standar ATX PSU (sekitar 150mm x 86mm x 140mm atau 125mm untuk kedalaman pada beberapa model yang lebih ringkas).', 450000.00, 7, '9272466_7ee60831-38d7-4b23-af49-7a4bd36ee3d0_1024_1024.jpg', '2025-05-26 20:29:37'),
(15, 'Casing PC Gamen GCS100', 'Casing', 'Merek: Gamen\r\nModel: GCS100\r\nTipe Casing: Kemungkinan besar adalah Mid Tower (berdasarkan desain umum casing gaming entry-level Gamen).\r\nDukungan Motherboard: Biasanya mendukung ATX, Micro-ATX (mATX), dan Mini-ITX.\r\nMaterial: Umumnya terbuat dari baja SPCC dan plastik ABS. Beberapa bagian mungkin memiliki panel samping transparan (akrilik atau tempered glass, tergantung varian).\r\nPanel Samping: Seringkali hadir dengan panel samping transparan (akrilik menjadi pilihan umum untuk casing di segmen harga ini).\r\nSlot Ekspansi: Standar 7 slot.\r\nDrive Bays:\r\n3.5\" HDD: Biasanya 1 atau 2 slot.\r\n2.5\" SSD: Biasanya 1 hingga 3 slot (beberapa mungkin berbagi tempat dengan slot 3.5\").\r\nDukungan Kipas Pendingin:\r\nDepan: Seringkali mendukung 2x atau 3x 120mm kipas.\r\nAtas: Mungkin mendukung 1x atau 2x 120mm kipas (tergantung desain spesifik).\r\nBelakang: Biasanya mendukung 1x 120mm kipas (kadang sudah terpasang).\r\nDukungan Radiator (Water Cooling):\r\nDukungan radiator bisa terbatas, mungkin mendukung radiator 120mm di bagian belakang atau 240mm di bagian depan jika tidak ada halangan dari drive bay.\r\nPanel I/O Depan:\r\n1x USB 3.0 (atau lebih, tergantung revisi)\r\n1x atau 2x USB 2.0\r\nPort Audio HD (Headphone dan Mikrofon)\r\nTombol Power\r\nTombol Reset\r\nIndikator LED (Power dan HDD)\r\nMaksimum Panjang GPU: Bervariasi, namun untuk casing Mid Tower umumnya sekitar 300mm - 330mm. Penting untuk diverifikasi lebih lanjut.\r\nMaksimum Tinggi CPU Cooler: Bervariasi, umumnya sekitar 155mm - 160mm. Penting untuk diverifikasi lebih lanjut.\r\nPosisi PSU: Umumnya di bagian bawah (bottom-mounted) dengan PSU shroud/cover.\r\nFilter Debu: Seringkali terdapat filter debu di bagian atas (jika ada ventilasi) dan di bawah untuk PSU.\r\nDimensi Casing (P x L x T): Perlu dicek spesifik karena Gamen mungkin memiliki beberapa varian atau tidak mencantumkan secara detail di semua platform. Namun, untuk Mid Tower perkiraannya sekitar 350-400mm (P) x 180-200mm (L) x 400-450mm (T).', 355000.00, 38, 'Gamen-GCS100.png', '2025-05-26 20:31:21'),
(16, 'Gigabyte Geforce GTX 1050 Ti 4GB GV-N105TD5-4GD Graphic Cards', 'Graphics Card', 'Unit Pemrosesan Grafis (GPU): NVIDIA GeForce® GTX 1050 Ti\r\nArsitektur GPU: Pascal\r\nCUDA® Cores: 768\r\nCore Clock (Frekuensi Inti):\r\nOC Mode: Boost: 1430 MHz / Base: 1316 MHz\r\nGaming Mode: Boost: 1392 MHz / Base: 1290 MHz\r\nMemori:\r\nKapasitas: 4 GB\r\nTipe: GDDR5\r\nBus Memori: 128-bit\r\nMemory Clock: 7008 MHz\r\nAntarmuka Bus: PCI Express 3.0 x16\r\nOutput Tampilan:\r\n1x Dual-link DVI-D\r\n1x HDMI 2.0b (Resolusi Maksimum: 4096x2160 @60 Hz)\r\n1x DisplayPort 1.4 (Resolusi Maksimum: 7680x4320 @60 Hz)\r\nDukungan Multi-view: Hingga 3 monitor\r\nResolusi Digital Maksimum: 7680x4320 @60Hz\r\nDimensi Kartu (Perkiraan):\r\nTinggi (H): Sekitar 30mm - 40mm (tergantung pada revisi dan cara pengukuran, beberapa sumber mencatat H=30 L=172 W=113 mm, sumber lain H=40 L=229 W=118 mm untuk varian Windforce yang mungkin berbeda sedikit, namun GV-N105TD5-4GD umumnya adalah desain yang lebih ringkas dengan satu kipas). Untuk GV-N105TD5-4GD (model single fan): H=30 L=172 W=113 mm adalah yang paling sering dikutip.\r\nBentuk PCB: ATX\r\nDukungan DirectX: Versi 12\r\nDukungan OpenGL: Versi 4.5\r\nRekomendasi Daya PSU (Power Supply Unit): 300W\r\nKonektor Daya Tambahan: Tidak ada (daya diambil langsung dari slot PCIe)\r\nFitur Utama Gigabyte:\r\nDesain Kipas Kustom 90mm (GIGABYTE custom-designed 90mm fan cooler)\r\n3D Active Fan (kipas akan berhenti berputar saat GPU dalam kondisi beban rendah atau suhu rendah)\r\nKomponen Ultra Durable (Lower RDS(on) MOSFETs, Metal Choke, Lower ESR Solid Capacitors)\r\nXTREME Engine Utility (untuk overclocking dan monitoring dengan sekali klik)', 2149998.00, 7, '91wSunpXgpL._AC_UF894,1000_QL80_.jpg', '2025-05-26 20:33:41'),
(17, 'AMD Ryzen 3 3200G 4-Core 3.6GHz Radeon Vega 8 Graphics (Socket AM4)', 'Processor', 'Nama Produk: AMD Ryzen™ 3 3200G\r\nArsitektur CPU: Zen+ (\"Picasso\")\r\nJumlah Core CPU: 4\r\nJumlah Thread CPU: 4\r\nClock Dasar (Base Clock): 3.6 GHz\r\nClock Maksimum Boost (Max. Boost Clock): Hingga 4.0 GHz\r\nTotal Cache L1: 384 KB\r\nTotal Cache L2: 2 MB\r\nTotal Cache L3: 4 MB\r\nUnlocked untuk Overclocking: Ya\r\nTeknologi Proses (CMOS): 12nm FinFET\r\nSocket: AM4\r\nVersi PCI Express®: PCIe® 3.0 x8\r\nSolusi Pendingin (Thermal Solution/Cooler Bawaan): Wraith Stealth\r\nTDP (Thermal Design Power) Default: 65W\r\ncTDP (Configurable TDP): 45-65W\r\nSuhu Maksimum (Max. Temps): 95°C\r\nGrafis Terintegrasi:\r\n\r\nModel Grafis: Radeon™ Vega 8 Graphics\r\nJumlah Core Grafis (Graphics Core Count): 8\r\nFrekuensi Grafis (Graphics Frequency): 1250 MHz\r\nDukungan Memori:\r\n\r\nKecepatan Memori Maksimum (Max Memory Speed): Hingga 2933MHz\r\nTipe Memori: DDR4\r\nChannel Memori: 2\r\nFitur Utama Lainnya:\r\n\r\nDukungan untuk teknologi AMD SenseMI\r\nDukungan untuk AMD Ryzen™ Master Utility\r\n', 1136000.00, 6, '3200g.jpg', '2025-05-26 20:36:38'),
(18, 'i7-12700F 2.1GHz Up To 4.9GHz - Cache 25MB [Box] Socket LGA Intel Core', 'Processor', 'Nama Produk: Intel® Core™ i7-12700F Processor\r\nArsitektur (Code Name): Alder Lake\r\nSocket: LGA1700\r\nJumlah Core: 12\r\nPerformance-cores (P-cores): 8\r\nEfficient-cores (E-cores): 4\r\nJumlah Thread: 20 (16 dari P-cores, 4 dari E-cores)\r\nFrekuensi Dasar (Base Clock):\r\nP-cores: 2.1 GHz\r\nE-cores: 1.6 GHz\r\nFrekuensi Turbo Maksimum (Max Turbo Frequency): Hingga 4.9 GHz\r\nMax Turbo Frequency P-cores: Hingga 4.8 GHz\r\nMax Turbo Frequency E-cores: Hingga 3.6 GHz\r\nIntel® Turbo Boost Max Technology 3.0 Frequency: Hingga 4.9 GHz\r\nCache:\r\nIntel® Smart Cache (L3 Cache): 25 MB\r\nTotal L2 Cache: 12 MB\r\nGrafis Terintegrasi (Integrated Graphics): Tidak Ada (Seri \"F\" memerlukan kartu grafis diskrit)\r\nDaya Dasar Prosesor (Processor Base Power / TDP): 65 W\r\nDaya Turbo Maksimum (Maximum Turbo Power): 180 W\r\nDukungan Memori:\r\nTipe Memori: Hingga DDR5 4800 MT/s atau DDR4 3200 MT/s\r\nJumlah Saluran Memori Maksimum: 2\r\nBandwidth Memori Maksimum: 76.8 GB/s\r\nDukungan PCI Express:\r\nRevisi PCI Express: 5.0 dan 4.0\r\nKonfigurasi PCI Express Maksimum: Hingga 1x16+4, 2x8+4\r\nJumlah Jalur PCI Express Maksimum: 20\r\nTeknologi Manufaktur: Intel 7\r\nFitur Utama Lainnya:\r\nIntel® Turbo Boost Technology 2.0\r\nIntel® Turbo Boost Max Technology 3.0\r\nIntel® Hyper-Threading Technology (pada P-cores)\r\nIntel® Deep Learning Boost (Intel® DL Boost)\r\nEnhanced Intel SpeedStep® Technology\r\nThermal Monitoring Technologies\r\n', 4170000.00, 9, 'i712f.jpg', '2025-05-26 20:39:10'),
(19, 'KINGSTON HyperX FURY RAM DDR4 8GB 2666Mhz', 'RAM', 'Merek: Kingston\r\nSeri: HyperX FURY\r\nTipe Memori: DDR4\r\nFaktor Bentuk (Form Factor): UDIMM (Unbuffered DIMM) - untuk PC Desktop\r\nVoltase:\r\nStandar JEDEC: 1.2V (untuk kecepatan seperti 2400MHz, 2666MHz)\r\nDengan XMP (Intel Extreme Memory Profile): Bisa mencapai 1.35V untuk kecepatan yang lebih tinggi seperti 3200MHz atau lebih, tergantung profil XMP.\r\nFitur Overclocking Otomatis:\r\nPlug N Play (PnP): Banyak modul HyperX FURY DDR4 mendukung overclocking otomatis ke kecepatan tertinggi yang diizinkan oleh BIOS sistem (biasanya hingga 2666MHz atau terkadang lebih tinggi, tergantung pada chipset dan prosesor).\r\nIntel XMP Ready: Sebagian besar modul, terutama yang berkecepatan lebih tinggi (seperti 3200MHz),', 248000.00, 21, '8gbkkingston.jpg', '2025-05-26 20:41:56'),
(20, 'Asus Prime A520M-K Socket AM4 DDR4 M-ATX Support Ryzen 3000, Ryzen 4000, Ryzen 5000', 'Motherboard', 'Socket: AMD AM4\r\nProsesor yang Didukung:\r\nAMD Ryzen™ 5000 Series Desktop Processors\r\nAMD Ryzen™ 5000 G-Series Desktop Processors with Radeon™ Graphics\r\nAMD Ryzen™ 4000 G-Series Desktop Processors with Radeon™ Graphics\r\nAMD Ryzen™ 3000 Series Desktop Processors\r\n(Periksa daftar QVL/CPU Support di situs web Asus untuk daftar lengkap dan revisi BIOS yang mungkin diperlukan)\r\nChipset:\r\n\r\nAMD A520\r\nMemori:\r\n\r\nTipe Memori: DDR4\r\nJumlah Slot DIMM: 2\r\nArsitektur Memori: Dual Channel\r\nKapasitas Maksimum: Hingga 64GB\r\nKecepatan Memori yang Didukung:\r\nDDR4 4866(O.C)/4800(O.C.)/4600(O.C)/4466(O.C.)/4400(O.C)/4333(O.C.)/4266(O.C.)/4200(O.C.)/4133(O.C.)/4000(O.C.)/3866(O.C.)/3733(O.C.)/3600(O.C.)/3466(O.C.)/3333(O.C.)/3200/3000/2933/2800/2666/2400/2133 MHz Un-buffered Memory\r\nDukungan ECC Memory (mode ECC) bervariasi tergantung CPU.\r\nDukungan Extreme Memory Profile (XMP)\r\nSlot Ekspansi:\r\n\r\nAMD Ryzen™ 5000 Series/ 5000 G-Series/ 4000 G-Series/ 3000 Series Desktop Processors:\r\n1 x PCIe 3.0 x16 slot (mendukung mode x16)\r\nAMD A520 Chipset:\r\n2 x PCIe 3.0 x1 slots\r\nPenyimpanan (Storage):\r\n\r\nTotal mendukung 1 x M.2 slot dan 4 x SATA 6Gb/s port\r\nAMD Ryzen™ 5000 Series/ 5000 G-Series/ 4000 G-Series/ 3000 Series Desktop Processors:\r\n1 x M.2 Socket 3, dengan M Key, tipe 2242/2260/2280 (mendukung mode SATA & PCIe 3.0 x4)\r\nAMD A520 Chipset:\r\n4 x SATA 6Gb/s port\r\nDukungan RAID 0, 1, 10 untuk perangkat penyimpanan SATA\r\nNetworking (LAN):\r\n\r\n1 x Realtek RTL8111H 1Gb Ethernet\r\nASUS LANGuard\r\nAudio:\r\n\r\nRealtek ALC887/ALC897 7.1 Surround Sound High Definition Audio CODEC\r\nMendukung: Jack-detection, Multi-streaming, Front Panel Jack-retasking\r\nMendukung pemutaran hingga 24-Bit/192kHz\r\nFitur Audio:\r\nAudio Shielding\r\nLapisan PCB audio khusus\r\nKapasitor audio Jepang premium\r\nPort USB:\r\n\r\nPort USB Belakang (Total 6):\r\n4 x USB 3.2 Gen 1 port(s) (4 x Type-A)\r\n2 x USB 2.0 port(s) (2 x Type-A)\r\nPort USB Depan (Total 6) (melalui header internal):\r\n1 x USB 3.2 Gen 1 header(s) mendukung tambahan 2 USB 3.2 Gen 1 port\r\n2 x USB 2.0 header(s) mendukung tambahan 4 USB 2.0 port\r\nKonektor I/O Internal:\r\n\r\n1 x CPU Fan header (1 x 4-pin)\r\n1 x Chassis Fan header (1 x 4-pin)\r\n1 x 24-pin EATX Power connector\r\n1 x 8-pin EATX 12V Power connector\r\n1 x M.2 Socket 3 dengan M key, tipe 2242/2260/2280\r\n4 x SATA 6Gb/s connector(s)\r\n1 x USB 3.2 Gen 1 header(s) (mendukung 2 port USB 3.2 Gen 1 tambahan)\r\n2 x USB 2.0 header(s) (mendukung 4 port USB 2.0 tambahan)\r\n1 x SPI TPM header\r\n1 x S/PDIF out header\r\n1 x Front panel audio header (AAFP)\r\n1 x Speaker header\r\n1 x System panel (dengan Chassis intrusion header terintegrasi)\r\n1 x Clear CMOS jumper\r\nPort I/O Panel Belakang:\r\n\r\n1 x PS/2 keyboard/mouse combo port\r\n1 x D-Sub (VGA) port\r\n1 x HDMI™ port\r\n1 x LAN (RJ45) port\r\n4 x USB 3.2 Gen 1 (biru) Type-A\r\n2 x USB 2.0\r\n3 x Audio jack(s)\r\nFaktor Bentuk (Form Factor):\r\n\r\nmATX (Micro ATX)\r\nDimensi: 8.9 inci x 8.7 inci (22.6 cm x 22.1 cm)\r\nBIOS:\r\n\r\n128 Mb Flash ROM, UEFI AMI BIOS\r\nFitur Khusus ASUS:\r\n\r\nASUS 5X PROTECTION III:\r\nASUS DIGI+ VRM\r\nASUS LANGuard\r\nASUS Overvoltage Protection\r\nASUS SafeSlot Core\r\nASUS Stainless-Steel Back I/O\r\nASUS Q-Design:\r\nASUS Q-DIMM\r\nASUS Q-Slot\r\nASUS Thermal Solution:\r\nAluminum heatsink design\r\nAURA Sync:\r\nAURA RGB header\r\nSistem Operasi yang Didukung:\r\n\r\nWindows® 10 64-bit', 975000.00, 13, 'asusprime.jpg', '2025-05-26 20:45:20'),
(21, 'Corsair Tx550m Power Supply 80 Plus Gold', 'Power Supply', 'Merek: Corsair\r\nSeri: TX-M Series (misalnya, model CP-9020133 atau CP-9020228 tergantung revisi/region)\r\nKapasitas Daya: 550 Watt (daya berkelanjutan)\r\nSertifikasi Efisiensi: 80 PLUS Gold (menjamin efisiensi hingga 90% pada beban tipikal)\r\nModularitas: Semi-Modular (Kabel ATX 24-pin dan EPS/ATX12V 4+4 pin terpasang permanen, kabel lainnya modular)\r\nFaktor Bentuk (Form Factor): ATX\r\nVersi ATX12V: v2.4\r\nVersi EPS12V: v2.92\r\nKipas Pendingin:\r\nUkuran: 120mm (beberapa revisi mungkin menggunakan 140mm, namun 120mm lebih umum untuk TX550M)\r\nJenis Bearing: Rifle Bearing (untuk operasi yang senyap dan masa pakai yang lama)\r\nZero RPM Mode: Biasanya tidak ada pada seri TX-M ini (kipas selalu berputar, kecepatan disesuaikan suhu)\r\nKabel:\r\nTipe: Low-Profile, Semua Hitam (kabel modular berbentuk pipih untuk manajemen kabel yang lebih mudah)\r\nKonektor:\r\n1x ATX Connector (24 pin atau 20+4 pin) - Terpasang permanen\r\n1x EPS/ATX12V Connector (8 pin atau 4+4 pin) - Terpasang permanen\r\n2x PCIe Connector (6+2 pin) - Modular\r\n5x SATA Connector - Modular (jumlah bisa sedikit berbeda antar revisi minor, namun 5 adalah angka yang umum)\r\n4x PATA/Molex Connector (4-pin peripheral) - Modular\r\n1x Floppy Adapter (FDD) (kadang disertakan sebagai adaptor dari Molex) - Modular\r\nFitur Proteksi:\r\nOVP (Over Voltage Protection / Proteksi Tegangan Lebih)\r\nUVP (Under Voltage Protection / Proteksi Tegangan Rendah)\r\nSCP (Short Circuit Protection / Proteksi Hubungan Singkat)\r\nOPP (Over Power Protection / Proteksi Daya Lebih)\r\nOTP (Over Temperature Protection / Proteksi Suhu Lebih)\r\nKapasitor: Menggunakan kapasitor Jepang berkualitas tinggi (seringkali 105°C rated) untuk keandalan dan performa yang solid.\r\nSuhu Operasi Berkelanjutan: Dirancang untuk beroperasi pada daya penuh hingga suhu 40°C atau 50°C (tergantung revisi spesifik).\r\nMTBF (Mean Time Between Failures): 100.000 jam\r\nDimensi (P x L x T): Umumnya 150mm x 140mm x 86mm (Panjang x Lebar x Tinggi)\r\nGaransi: Biasanya 7 tahun dari Corsair (dapat bervariasi tergantung wilayah dan penjual)\r\nInput Voltage: 100-240 VAC (Universal AC input)\r\nInput Frequency Range: 47-63 Hz\r\nInput Current: 10A - 5A\r\nSpesifikasi Rail +12V: Single +12V rail (misalnya, sekitar 43A untuk model 550W)\r\nKesesuaian Standar: Kompatibel dengan standar ATX12V v2.4 dan EPS 2.92, dan kompatibel mundur dengan sistem ATX12V 2.2, 2.31, dan ATX12V 2.01.\r\nDukungan Mode Tidur Intel C6/C7: Ya\r\nFitur Lain:\r\nResonant LLC topology dengan konversi DC-to-DC untuk regulasi voltase yang ketat dan efisiensi tinggi.\r\nKompak (panjang 140mm memudahkan instalasi di berbagai casing).\r\nMicrosoft Modern Standby compatible (pada revisi yang lebih baru).', 1356000.00, 24, 'corsair550.jpg', '2025-05-26 20:47:50'),
(22, 'Windows 10 Pro Original License Key Lisensi Lifetime', 'Software', '\r\nNama Produk: Windows 10 Pro\r\nJenis Lisensi: Original/Asli (Genuine) dari Microsoft.', 325000.00, 34, 'win10.jpg', '2025-05-26 20:50:08'),
(23, 'Windows 11 Pro Original License Key Lisensi Lifetime', 'Software', 'Nama Produk: Windows 11 Pro\r\nJenis Lisensi: Original/Asli (Genuine) dari Microsoft.', 409000.00, 34, 'microsoft_windows_11_pro_original_license_key_lisensi_full01_kv391imv.jpeg', '2025-05-26 20:52:15'),
(24, 'Gigabyte Geforce Rtx 3050 Windforce Oc 6gb Gddr6', 'Graphics Card', 'Unit Pemrosesan Grafis (GPU): NVIDIA GeForce RTX™ 3050\r\nArsitektur GPU: NVIDIA Ampere\r\nCUDA® Cores: 2304\r\nCore Clock: 1477 MHz (Kartu Referensi: 1470 MHz) - Ini adalah model OC (Overclocked) jadi memiliki sedikit peningkatan dari pabrik.\r\nMemori:\r\nKapasitas: 6 GB\r\nTipe: GDDR6\r\nMemory Clock: 14000 MHz\r\nBus Memori: 96-bit\r\nAntarmuka Bus: PCI Express 4.0\r\nOutput Tampilan:\r\n2x DisplayPort 1.4a\r\n2x HDMI 2.1\r\nDukungan Multi-view: Hingga 4 monitor\r\nResolusi Digital Maksimum: 7680x4320\r\nDimensi Kartu (Perkiraan): Panjang=191mm, Lebar=111mm, Tinggi=36mm\r\nBentuk PCB: ATX\r\nDukungan DirectX: Versi 12 Ultimate\r\nDukungan OpenGL: Versi 4.6\r\nRekomendasi Daya PSU (Power Supply Unit): 300W\r\nKonektor Daya Tambahan: Tidak ada (N/A) - Kartu ini mengambil daya sepenuhnya dari slot PCIe.\r\nSistem Pendingin: WINDFORCE Cooling System\r\nDua kipas dengan desain bilah unik (unique blade fans)\r\nAlternate Spinning (putaran kipas bergantian untuk mengurangi turbulensi dan meningkatkan tekanan udara)\r\n3D Active Fan (kipas akan berhenti berputar saat GPU dalam kondisi beban rendah atau suhu rendah)\r\nGraphene nano lubricant (untuk memperpanjang masa pakai kipas dan operasi yang lebih senyap)\r\nFitur Utama Gigabyte/NVIDIA:\r\nNVIDIA Ampere Streaming Multiprocessors\r\n2nd Generation RT Cores (untuk Ray Tracing)\r\n3rd Generation Tensor Cores (untuk DLSS dan AI)\r\nNVIDIA DLSS (Deep Learning Super Sampling)\r\nNVIDIA Reflex\r\nDirectX 12 Ultimate\r\nKomponen Ultra Durable (Lower RDS(on) MOSFETs, Metal Choke, Lower ESR Solid Capacitors)\r\nDesain PCB yang ramah (Friendly PCB design)', 3229000.00, 4, 'rtx3050.jpg', '2025-05-26 20:54:17'),
(25, 'Ssd Nvme 512gb Pny M2', 'Storage', 'Merek: PNY\r\nKapasitas: 512GB (atau sekitar 500GB, tergantung model)\r\nFaktor Bentuk (Form Factor): M.2 2280\r\nAntarmuka (Interface): NVMe (Non-Volatile Memory Express)\r\nProtokol PCIe: Bervariasi antar model (misalnya, PCIe Gen3 x4 atau PCIe Gen4 x4)\r\nTipe NAND Flash: Umumnya 3D TLC NAND atau QLC NAND (tergantung model)\r\nFitur Umum:\r\nS.M.A.R.T. (Self-Monitoring, Analysis and Reporting Technology)\r\nTRIM support\r\nManajemen suhu (Thermal Throttling)', 570000.00, 33, 'pny512gb.jpg', '2025-05-26 20:56:53'),
(26, 'MSI GeForce RTX 4070 GAMING X TRIO 12G', 'Graphics Card', 'Nama Model: GeForce RTX™ 4070 GAMING X TRIO 12G\r\nUnit Pemrosesan Grafis (GPU): NVIDIA® GeForce RTX™ 4070\r\nArsitektur GPU: NVIDIA Ada Lovelace\r\nAntarmuka: PCI Express® Gen 4\r\nCUDA® Cores: 5888 Unit\r\nCore Clocks (Frekuensi Inti):\r\nExtreme Performance (melalui MSI Center): 2625 MHz\r\nBoost Clock (Gaming & Silent Mode): 2610 MHz\r\nMemori:\r\nKapasitas: 12GB\r\nTipe: GDDR6X\r\nKecepatan Memori: 21 Gbps\r\nBus Memori: 192-bit\r\nOutput Tampilan:\r\n3x DisplayPort (v1.4a)\r\n1x HDMI™ (Mendukung 4K@120Hz HDR, 8K@60Hz HDR, dan Variable Refresh Rate seperti yang tertera pada HDMI™ 2.1a)\r\nDukungan HDCP: Ya\r\nDukungan Multi-view: Hingga 4 monitor\r\nResolusi Digital Maksimum: 7680 x 4320\r\nKonektor Daya: 1x 16-pin (Adaptor 2x 8-pin ke 1x 16-pin biasanya disertakan)\r\nKonsumsi Daya: 215 W\r\nRekomendasi Daya PSU (Power Supply Unit): 650 W\r\nDimensi Kartu (P x L x T): 338 x 141 x 52 mm\r\nBerat Kartu / dengan Kemasan: 1214 g / 2143 g\r\nSistem Pendingin: TRI FROZR 3 Thermal Design\r\nTORX FAN 5.0: Bilah kipas dihubungkan oleh ring arcs dan fan cowl untuk menstabilkan dan mempertahankan aliran udara bertekanan tinggi.\r\nCopper Baseplate: Pelat dasar tembaga berlapis nikel untuk penyerapan panas langsung dari GPU dan memori.\r\nCore Pipe: Pipa panas presisi untuk memaksimalkan kontak dengan GPU dan menyebarkan panas di sepanjang heatsink.\r\nAirflow Control: Desain sirip dengan potongan berbentuk V dan deflektor udara untuk meningkatkan efisiensi aliran udara dan mengurangi kebisingan.\r\nMetal Backplate: Memperkuat kartu dan membantu pembuangan panas dengan thermal pads.\r\nZero Frozr: Kipas berhenti berputar pada suhu rendah untuk keheningan total.\r\nDual Ball Bearing: Pada kipas untuk daya tahan yang lebih lama.\r\nDukungan DirectX: Versi 12 Ultimate\r\nDukungan OpenGL: Versi 4.6\r\nTeknologi NVIDIA Utama:\r\nNVIDIA DLSS 3 (Deep Learning Super Sampling)\r\nNVIDIA Reflex\r\nNVIDIA G-SYNC®\r\nRay Tracing Cores Generasi ke-3\r\nTensor Cores Generasi ke-4\r\nFitur MSI:\r\nMSI Center: Perangkat lunak eksklusif untuk memonitor, menyesuaikan, dan mengoptimalkan produk MSI.\r\nMystic Light: Kontrol pencahayaan RGB.\r\nDual BIOS: Memungkinkan pilihan antara mode GAMING (performa penuh) dan SILENT (operasi lebih senyap).\r\nAfterburner: Utilitas overclocking kartu grafis.\r\nHigh-Efficiency Carbonyl Inductors (HCI)\r\nDrMOS power stage solution\r\nFuse tambahan pada PCB untuk perlindungan ekstra terhadap kerusakan listrik.', 13118000.00, 3, '7f252a5e-4287-4fa7-9cc1-509d97f154bc.jpeg', '2025-05-26 20:59:05'),
(27, 'MSI PRO B660M-B DDR4 Intel B660 LGA 1700', 'Motherboard', 'Nama Model: PRO B660M-B DDR4\r\nChipset: Intel® B660 Chipset\r\nSocket CPU: LGA 1700 (mendukung prosesor Intel® Core™ Generasi ke-12 dan ke-13, Pentium® Gold, dan Celeron®)\r\nFaktor Bentuk: Micro-ATX (mATX)\r\nDukungan Memori\r\nTipe Memori: DDR4\r\nJumlah Slot DIMM: 2\r\nKapasitas Maksimum: Hingga 64GB\r\nKecepatan Memori yang Didukung: Hingga 4600+(OC) MHz\r\nArsitektur Memori: Dual Channel\r\nDukungan Profil: Intel® Extreme Memory Profile (XMP)\r\nSlot Ekspansi\r\n1x slot PCIe x16 (dari CPU)\r\nMendukung PCIe 4.0\r\n1x slot PCIe x1 (dari Chipset B660)\r\nMendukung PCIe 3.0\r\nPenyimpanan (Storage)\r\n1x slot M.2 (Key M)\r\nM2_1 (dari Chipset B660) mendukung hingga PCIe 4.0 x4, mendukung perangkat 2242/ 2260/ 2280\r\n4x port SATA 6Gb/s (dari Chipset B660)\r\nGrafis Terintegrasi (Tergantung CPU)\r\n1x port HDMI 2.1 dengan HDR, mendukung resolusi maksimum 4K 60Hz\r\n1x port VGA, mendukung resolusi maksimum 2048x1536 50Hz, 2048x1280 60Hz, 1920x1200 60Hz (Hanya tersedia pada prosesor dengan grafis terintegrasi. Spesifikasi grafis mungkin berbeda tergantung pada CPU yang dipasang)\r\nJaringan (LAN)\r\n1x Intel® I219V 1Gbps LAN controller\r\nAudio\r\nRealtek® ALC897 Codec\r\n7.1-Channel High Definition Audio\r\nPort USB\r\nChipset Intel® B660\r\n4x port USB 3.2 Gen 1 5Gbps (2 port Type-A di panel belakang, 2 port tersedia melalui konektor internal)\r\n8x port USB 2.0 (4 port Type-A di panel belakang, 4 port tersedia melalui konektor internal)\r\nKonektor I/O Internal\r\n1x Konektor daya utama ATX 24-pin\r\n1x Konektor daya ATX 12V 8-pin\r\n4x Konektor SATA 6Gb/s\r\n1x Slot M.2 (M-Key)\r\n2x Konektor USB 2.0 (mendukung tambahan 4 port USB 2.0)\r\n1x Konektor USB 3.2 Gen 1 5Gbps (mendukung tambahan 2 port USB 3.2 Gen 1)\r\n1x Konektor kipas CPU 4-pin\r\n1x Konektor kipas sistem 4-pin\r\n1x Konektor audio panel depan\r\n2x Konektor panel sistem\r\n1x Konektor Chassis Intrusion\r\n1x Konektor modul TPM\r\n1x Jumper Clear CMOS\r\nPort I/O Panel Belakang\r\nPort HDMI™\r\nPort VGA\r\nKeyboard / Mouse PS/2 Combo Port\r\n2x Port USB 3.2 Gen 1 5Gbps Tipe-A\r\nPort LAN (RJ45)\r\n4x Port USB 2.0\r\nKonektor Audio\r\nDimensi\r\nFaktor Bentuk mATX\r\n24.4 cm x 21.1 cm (9.6 in. x 8.3 in.)\r\nFitur Utama Lainnya\r\nCore Boost: Dengan layout premium dan desain daya digital untuk mendukung lebih banyak core dan memberikan performa yang lebih baik.\r\nMemory Boost: Teknologi canggih untuk menghantarkan sinyal data murni untuk performa, stabilitas, dan kompatibilitas terbaik.\r\nAudio Boost: Manjakan telinga Anda dengan kualitas suara studio.\r\nSteel Armor PCIe: Melindungi kartu VGA dari tekukan dan EMI untuk performa, stabilitas,', 1795000.00, 17, 'msipro.jpg', '2025-05-26 21:01:50'),
(28, 'Deepcool Dm9 1.5gr Professional Grade Thermal Paste', 'Lainnya', 'Nama Produk: DM9 Professional Grade Thermal Paste\r\nMerek: DeepCool\r\nBerat Bersih Pasta (Grease Weight): 1.5 gram\r\nWarna Pasta (Grease Color): Abu-abu (Gray)\r\nGravitasi Spesifik (Specific Gravity): 3.5 g/cm³\r\nSuhu Operasional (Operating Temperature): -50°C hingga +250°C\r\nKonduktivitas Listrik (Electrical Conductivity): Tidak konduktif secara elektrik (Electrically non-conductive) dan non-kapasitif, sehingga aman digunakan pada komponen elektronik.\r\nBasis Material: Senyawa termal berbasis resin silikon (Silicone resin-based thermal compound)\r\nKonsistensi: Halus dan mudah diaplikasikan untuk mengisi setiap saluran mikro guna memastikan transfer panas terbaik.\r\nKarakteristik Utama:\r\nDirancang untuk memenuhi standar ketat yang digunakan dalam aplikasi industri.\r\nDisipasi panas yang sangat efisien.\r\nResistansi termal yang rendah.\r\nStabilitas yang sangat baik.\r\nIsi Kemasan (Package Content) Umumnya:\r\n1x Syringe Deepcool DM9 Thermal Paste (1.5g)\r\n1x Spatula (untuk aplikasi)\r\n1x Pembersih gemuk (Grease cleanser/wipe)\r\nAplikasi yang Direkomendasikan: CPU, GPU, dan komponen elektronik lain yang membutuhkan disipasi panas efisien.\r\nPart Number (P/N) untuk 1.5g: R-DM9-GY015C-G', 66000.00, 76, 'deepcooltherml.jpg', '2025-05-26 21:03:39'),
(29, 'Armaggeddon NIMITZ N7 Casing for Gaming PC', 'Casing', 'Desain Panel Samping: Dilengkapi dengan panel samping transparan (umumnya tempered glass), memungkinkan pengguna untuk memamerkan komponen internal PC mereka.\r\nPencahayaan RGB: Seringkali hadir dengan strip lampu LED RGB di bagian depan atau area lain, yang memiliki beberapa mode atau efek pencahayaan yang dapat diatur melalui tombol khusus.\r\nUkuran Motherboard: Mendukung motherboard berukuran ATX.\r\nDukungan Penyimpanan: Menyediakan ruang untuk beberapa drive penyimpanan, biasanya kombinasi dari SSD 2.5 inci dan HDD 3.5 inci.\r\nDukungan Kartu Grafis: Mampu menampung kartu grafis dengan panjang tertentu (umumnya hingga sekitar 325mm, namun sebaiknya diverifikasi untuk model spesifik).\r\nManajemen Kabel: Dirancang dengan fitur manajemen kabel untuk membantu menjaga interior casing tetap rapi dan aliran udara optimal.\r\nPort I/O Depan: Biasanya dilengkapi dengan port USB 3.0, USB 2.0, serta jack audio dan mikrofon di bagian depan untuk kemudahan akses.\r\nDukungan Pendinginan: Memiliki opsi untuk pemasangan beberapa kipas pendingin dan mendukung pemasangan radiator pendingin cair (liquid cooling) dengan ukuran tertentu (misalnya hingga 170mm, namun perlu dikonfirmasi).\r\nMaterial: Umumnya terbuat dari material SPCC Blackened Steel Plate.', 520000.00, 39, 'armageddon2.jpg', '2025-05-28 17:01:00'),
(30, 'Acer V950W White Tempered Glass | Casing PC ATX', 'Casing', 'Jenis Casing: Mid-Tower ATX\r\nWarna: Putih\r\nPanel Samping: Tempered Glass\r\nKompatibilitas Motherboard: ATX, Micro-ATX, ITX\r\nFitur Khusus Motherboard: Mendukung \"back connect M/B\" untuk manajemen kabel yang lebih rapi.\r\nDukungan Pendinginan:\r\nFleksibel untuk berbagai konfigurasi kipas.\r\nDukungan untuk radiator pendingin cair.\r\nBeberapa model menyertakan hingga 7 kipas RGB.\r\nDukungan Penyimpanan: Ruang untuk kombinasi beberapa SSD dan HDD.\r\nPanel I/O Depan:\r\nUSB Type-C (pada beberapa varian)\r\nUSB 3.0\r\nPort Audio standar\r\nDimensi (P x L x T): Sekitar 426mm x 285mm x 398mm (dapat sedikit bervariasi)\r\nPanjang Maksimal Kartu Grafis: Hingga sekitar 410mm\r\nTinggi Maksimal Pendingin CPU: Sekitar 160mm hingga 163mm\r\nMaterial: SPCC Blackened Steel Plate (umumnya ketebalan 0.8mm)\r\nDesain Tambahan (pada beberapa varian):\r\nDual-chamber\r\nPanoramic view dengan dua panel tempered glass (depan dan samping kiri)', 1159000.00, 35, 'casing acer.jpg', '2025-05-28 17:05:19'),
(31, 'Kingston Fury Beast DDR5 RGB 16GB (1x16GB) 5600Mhz', 'RAM', 'Kapasitas: 16GB (satu keping/modul tunggal)\r\nJenis Memori: DDR5\r\nKecepatan: 5600MHz (MT/s)\r\nRGB Lighting: Ya, dapat disesuaikan (Kingston FURY™ Infrared Sync Technology™, kompatibel dengan software kontrol RGB motherboard)\r\nCAS Latency (CL): Umumnya CL36 atau CL40 (perlu dicek model spesifiknya, karena bisa bervariasi)\r\nTiming: Bervariasi tergantung model spesifik (misalnya 36-38-38 atau 40-40-40)\r\nVoltase: Biasanya 1.25V atau 1.35V (tergantung profil XMP/EXPO)\r\nHeat Spreader: Ya, desain heat spreader untuk pendinginan\r\nFitur Tambahan:\r\nIntel® XMP 3.0 Certified\r\nTerkadang juga mendukung AMD EXPO™ (perlu dikonfirmasi untuk model spesifik)\r\nOn-Die ECC (Error Correcting Code)\r\nPower Management IC (PMIC) terintegrasi', 1050000.00, 30, 'kingston16gb.jpg', '2025-05-28 17:20:46'),
(32, 'ASUS ROG STRIX B760-F GAMING WIFI LGA1700 ATX Motherboard, CPU Socket LGA 1700,', 'Motherboard', 'CPU Socket: LGA 1700\r\nChipset: Intel® B760\r\nForm Factor: ATX\r\nDukungan Memori:\r\nTipe: DDR5\r\nSlot: 4 x DIMM\r\nKapasitas Maksimal: Biasanya hingga 128GB atau 192GB (tergantung pembaruan BIOS dan jenis modul RAM)\r\nKecepatan: Mendukung kecepatan tinggi DDR5 (misalnya, 7800+ MT/s (OC))\r\nSlot Ekspansi:\r\n1 x PCIe 5.0 x16 slot (untuk kartu grafis)\r\nSlot PCIe x16 lainnya (beroperasi pada mode lebih rendah, misal PCIe 4.0 x4 atau x1)\r\nSlot PCIe x1\r\nPenyimpanan:\r\nBeberapa slot M.2 (umumnya 3 atau 4, dengan dukungan PCIe 4.0 x4)\r\nPort SATA 6Gb/s (biasanya 4 port)\r\nJaringan:\r\nWiFi: WiFi 6E (802.11ax)\r\nEthernet: Intel® 2.5Gb Ethernet\r\nAudio: ROG SupremeFX 7.1 Surround Sound High Definition Audio CODEC (misalnya ALC4080 atau serupa)\r\nPort I/O Belakang (Umumnya Termasuk):\r\nTombol BIOS FlashBack™\r\nTombol Clear CMOS\r\nPort USB (berbagai tipe, termasuk USB 3.2 Gen 2x2 Type-C®, USB 3.2 Gen 2, USB 3.2 Gen 1, USB 2.0)\r\nPort DisplayPort™\r\nPort HDMI™\r\nKonektor WiFi\r\nPort Ethernet (RJ45)\r\nKonektor Audio\r\nFitur Unggulan ROG Strix:\r\nDesain estetika gaming ROG\r\nSolusi pendinginan yang komprehensif (VRM heatsinks, M.2 heatsinks)\r\nAura Sync RGB lighting\r\nFitur overclocking dan tuning yang ditingkatkan', 3995000.00, 20, 'rog1700.jpg', '2025-05-28 17:27:40');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `no_transaksi` varchar(20) NOT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `bundle_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `nama_kasir` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `no_transaksi`, `tanggal`, `total`, `bundle_id`, `user_id`, `nama_kasir`) VALUES
(17, 'BDL-20250527-17', '2025-05-27 05:14:46', 3800000.00, 3, 6, 'Sinatria'),
(19, 'REG-20250528-19', '2025-05-28 16:53:43', 2149998.00, NULL, 6, 'Sinatria'),
(21, 'BDL-20250528-21', '2025-05-28 17:54:29', 3800000.00, 3, 6, 'Sinatria'),
(22, 'REG-20250528-22', '2025-05-28 17:54:46', 1136000.00, NULL, 6, 'Sinatria'),
(23, 'REG-20250528-23', '2025-05-28 20:44:42', 175000.00, NULL, 6, 'Sinatria');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `role`, `created_at`) VALUES
(1, 'admin', 'admin1945', 'Administrator', 'admin', '2025-05-25 15:40:55'),
(6, 'Sinatria', 'sina1945', '', '', '2025-05-26 20:10:21'),
(8, 'Indra', 'indra1949', '', '', '2025-05-26 20:10:45');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bundle`
--
ALTER TABLE `bundle`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bundle_items`
--
ALTER TABLE `bundle_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bundle_id` (`bundle_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `konfigurasi_pc`
--
ALTER TABLE `konfigurasi_pc`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_transaksi` (`no_transaksi`),
  ADD KEY `user_id` (`user_id`);

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
-- AUTO_INCREMENT untuk tabel `bundle`
--
ALTER TABLE `bundle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `bundle_items`
--
ALTER TABLE `bundle_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `konfigurasi_pc`
--
ALTER TABLE `konfigurasi_pc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bundle_items`
--
ALTER TABLE `bundle_items`
  ADD CONSTRAINT `bundle_items_ibfk_1` FOREIGN KEY (`bundle_id`) REFERENCES `bundle` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bundle_items_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `detail_transaksi_ibfk_1` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detail_transaksi_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);

--
-- Ketidakleluasaan untuk tabel `konfigurasi_pc`
--
ALTER TABLE `konfigurasi_pc`
  ADD CONSTRAINT `konfigurasi_pc_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
