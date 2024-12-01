<?php
// Koneksi ke database
include('db.php');

// Ambil data berdasarkan ID dari parameter URL
$id = $_GET['id'];
$sql = "SELECT * FROM pendaftaran WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc(); // Data berhasil ditemukan
} else {
    echo "Data tidak ditemukan."; // Jika data tidak ada, tampilkan pesan
    exit;
}

// Proses pembaruan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_hp = $_POST['nomor_hp'];
    $semester = $_POST['semester'];
    $pilihan_beasiswa = $_POST['beasiswa'];
    $status_ajuan = $_POST['status_ajuan'];
    $ipk = $_POST['ipk']; // Menambahkan input untuk IPK

    // Menangani berkas upload
    $file_berkas = $_FILES['berkas']['name'] ?? null;
    $file_path = $row['file_berkas']; // Default file_path jika tidak ada upload baru

    if ($file_berkas) {
        // Jika ada file yang diupload, proses upload
        $upload_dir = "uploads/";
        $file_path = $upload_dir . basename($file_berkas);
        if (move_uploaded_file($_FILES['berkas']['tmp_name'], $file_path)) {
            // File berhasil diupload
        } else {
            echo "<script>alert('Upload berkas gagal!'); window.history.back();</script>";
            exit;
        }
    }

    // Query untuk memperbarui data pendaftaran
    $sql = "UPDATE pendaftaran SET 
            nama = '$nama', 
            email = '$email', 
            nomor_hp = '$nomor_hp', 
            semester = $semester, 
            pilihan_beasiswa = '$pilihan_beasiswa', 
            status_ajuan = '$status_ajuan', 
            ipk = '$ipk', 
            file_berkas = '$file_path'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href = 'index.php';</script>"; // Notifikasi sukses
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error; // Tampilkan pesan error jika ada
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Update Data Pendaftaran</title>
</head>
<body>
<div class="container">
    <h2>Update Data Pendaftaran</h2>
    <!-- Form untuk memperbarui data -->
    <form action="update.php?id=<?= $id; ?>" method="POST" enctype="multipart/form-data">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?= $row['nama']; ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $row['email']; ?>" required>

        <label for="nomor_hp">Nomor HP:</label>
        <input type="number" id="nomor_hp" name="nomor_hp" value="<?= $row['nomor_hp']; ?>" required>

        <label for="semester">Semester:</label>
        <select id="semester" name="semester" required>
            <!-- Pilihan semester -->
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?= $i; ?>" <?= $i == $row['semester'] ? 'selected' : ''; ?>>Semester <?= $i; ?></option>
            <?php endfor; ?>
        </select>

        <label for="ipk">IPK:</label>
        <input type="number" step="0.01" id="ipk" name="ipk" value="<?= $row['ipk']; ?>" min="0" max="4" required>

        <label for="beasiswa">Jenis Beasiswa:</label>
        <select id="beasiswa" name="beasiswa" required>
            <!-- Pilihan jenis beasiswa -->
            <option value="Beasiswa Akademik" <?= $row['pilihan_beasiswa'] === 'Beasiswa Akademik' ? 'selected' : ''; ?>>Beasiswa Akademik</option>
            <option value="Beasiswa Non-Akademik" <?= $row['pilihan_beasiswa'] === 'Beasiswa Non-Akademik' ? 'selected' : ''; ?>>Beasiswa Non-Akademik</option>
        </select>

        <label for="status_ajuan">Status Ajuan:</label>
        <select id="status_ajuan" name="status_ajuan" required>
            <!-- Pilihan status ajuan -->
            <option value="Belum diverifikasi" <?= $row['status_ajuan'] === 'Belum diverifikasi' ? 'selected' : ''; ?>>Belum diverifikasi</option>
            <option value="Diterima" <?= $row['status_ajuan'] === 'Diterima' ? 'selected' : ''; ?>>Diterima</option>
            <option value="Ditolak" <?= $row['status_ajuan'] === 'Ditolak' ? 'selected' : ''; ?>>Ditolak</option>
        </select>

        <label for="berkas">Upload Berkas (Jika ada perubahan):</label>
        <input type="file" id="berkas" name="berkas">

        <?php if (!empty($row['file_berkas'])): ?>
            <p>File saat ini: <a href="uploads/<?= $row['file_berkas']; ?>" target="_blank">Lihat Berkas</a></p>
        <?php endif; ?>

        <button type="submit">Simpan Perubahan</button> <!-- Tombol untuk menyimpan perubahan -->
    </form>

    <!-- Tombol Kembali ke Beranda -->
    <div class="button-container">
        <a href="daftar.php">Kembali ke Daftar Peserta</a>
    </div>
</div>

</body>
</html>

<?php $conn->close(); // Tutup koneksi database ?>
