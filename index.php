<?php
// Koneksi ke database
include('db.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Bagian meta dan stylesheet -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Portal Beasiswa</title>
</head>
<body>

<div class="container">
    <!-- Tampilan portal beranda -->
    <h2>Selamat Datang di dunia baru penuh peluang !</h2>
    <p style="text-align: center;">Ingin meraih Cita Cita tanpa Hambatan Finansial ? Yuk Segera Daftarkan Diri !</p>
<p style="text-align: center;"></p>

    <div class="button-container">
        <!-- Tombol navigasi -->
        <a href="pendaftaran.php">Daftar Beasiswa</a>
        <a href="daftar.php">Lihat Data Pendaftaran</a>
    </div>
</div>
</body>
</html>

<?php $conn->close(); ?>
