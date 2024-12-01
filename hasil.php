<?php

// Koneksi ke database
include('db.php');

// Bagian untuk mengambil data terakhir dari tabel 'pendaftaran'
$sql = "SELECT * FROM pendaftaran ORDER BY id DESC LIMIT 1";
$result = $conn->query(query: $sql);

// Mengecek apakah ada data yang ditemukan
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc(); // Menyimpan data yang ditemukan ke dalam array
} else {
    echo "Data tidak ditemukan."; // Menampilkan pesan jika data tidak ditemukan
    exit; // Menghentikan script jika tidak ada data
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bagian untuk konfigurasi meta dan stylesheet -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css"> <!-- Menghubungkan dengan file CSS eksternal -->
    <title>Hasil Pendaftaran</title>
</head>
<body>
<div class="container">
    <!-- Bagian untuk menampilkan hasil data pendaftaran -->
    <h2>Hasil Pendaftaran</h2>
    <p><strong>Nama:</strong> <?= htmlspecialchars(string: $data['nama']); ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars(string: $data['email']); ?></p>
    <p><strong>Nomor HP:</strong> <?= htmlspecialchars(string: $data['nomor_hp']); ?></p>
    <p><strong>Semester:</strong> <?= $data['semester']; ?></p>
    <p><strong>IPK:</strong> <?= $data['ipk']; ?></p>
    <p><strong>Jenis Beasiswa:</strong> <?= htmlspecialchars(string: $data['pilihan_beasiswa']); ?></p>
    <p><strong>Status Ajuan:</strong> <?= $data['status_ajuan']; ?></p>
    <p><strong>Berkas:</strong> <?= htmlspecialchars(string: $data['file_berkas']); ?></p>

    <!-- Tombol untuk kembali ke halaman beranda -->
    <div class="button-container">
        <a href="index.php">Kembali ke Beranda</a>
    </div>
</div>
</body>
</html>
