<?php
// Koneksi ke database
include('db.php');

// Konstanta untuk nilai IPK
define(constant_name: "IPK", value: 3.4); // Ubah sesuai kebutuhan

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $nomor_hp = $_POST['nomor_hp'];
    $semester = $_POST['semester'];
    $pilihan_beasiswa = $_POST['beasiswa'] ?? null;
    $file_berkas = $_FILES['berkas']['name'] ?? null;
    $status_ajuan = "Belum diverifikasi";

    // Validasi IPK (berdasarkan konstanta)
    $ipk = $_POST['ipk']; // Mendapatkan IPK dari form
    if ($ipk < 3) {
        echo "<script>alert('IPK Anda kurang dari 3. Tidak dapat melanjutkan pendaftaran.'); window.history.back();</script>";
        exit;
    }

    // Upload file jika IPK valid
    if (isset($_FILES['berkas']['tmp_name']) && !empty($_FILES['berkas']['name'])) {
        $upload_dir = "uploads/";
        $file_path = $upload_dir . basename(path: $file_berkas);
        // Pindahkan file yang diupload ke folder 'uploads/'
        if (move_uploaded_file(from: $_FILES['berkas']['tmp_name'], to: $file_path)) {
            // Berkas berhasil diupload
        } else {
            echo "<script>alert('Upload berkas gagal.'); window.history.back();</script>";
            exit;
        }
    } else {
        $file_path = null; // Tidak ada berkas yang diupload
    }

    // Masukkan data ke database
    $sql = "INSERT INTO pendaftaran (nama, email, nomor_hp, semester, ipk, pilihan_beasiswa, file_berkas, status_ajuan)
            VALUES ('$nama', '$email', '$nomor_hp', $semester, $ipk, '$pilihan_beasiswa', '$file_berkas', '$status_ajuan')";

    if ($conn->query(query: $sql) === TRUE) {
        echo "<script>alert('Pendaftaran berhasil!'); window.location.href = 'hasil.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Form Pendaftaran Beasiswa</title>
    <script>
        // Fungsi untuk memvalidasi IPK
        function validateIPK() {
            const ipkField = document.getElementById('ipk');
            const beasiswaField = document.getElementById('beasiswa');
            const berkasField = document.getElementById('berkas');
            const submitButton = document.getElementById('submit');

            // Ambil nilai IPK dari input
            const ipk = parseFloat(ipkField.value);

            if (ipk < 3) {
                // Jika IPK < 3, nonaktifkan elemen-elemen ini
                beasiswaField.disabled = true;
                berkasField.disabled = true;
                submitButton.disabled = true;
            } else {
                // Jika IPK >= 3, aktifkan elemen-elemen ini
                beasiswaField.disabled = false;
                berkasField.disabled = false;
                submitButton.disabled = false;
            }
        }

        // Fungsi untuk memindahkan kursor ke dropdown setelah selesai mengetik IPK
        function moveToBeasiswa() {
            const ipkField = document.getElementById('ipk');
            const beasiswaField = document.getElementById('beasiswa');
            const ipk = parseFloat(ipkField.value);

            // Periksa apakah IPK lebih besar atau sama dengan 3
            if (ipk >= 3) {
                // Fokuskan ke dropdown beasiswa setelah selesai mengetik IPK
                beasiswaField.focus();
            }
        }

        // Jalankan validasi dan pemindahan kursor saat halaman dimuat
        document.addEventListener("DOMContentLoaded", function () {
            validateIPK();
        });
    </script>
</head>
<body>
<div class="container">
    <h2>Form Pendaftaran Beasiswa</h2>
    <form action="pendaftaran.php" method="POST" enctype="multipart/form-data">
        <label for="nama">Masukkan Nama:</label>
        <input type="text" id="nama" name="nama" required>

        <label for="email">Masukkan Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="nomor_hp">Masukkan Nomor HP:</label>
        <input type="number" id="nomor_hp" name="nomor_hp" required>

        <label for="semester">Semester Saat Ini:</label>
        <select id="semester" name="semester" required>
            <option value="" disabled selected>Pilih Semester</option>
            <?php for ($i = 1; $i <= 8; $i++): ?>
                <option value="<?= $i; ?>">Semester <?= $i; ?></option>
            <?php endfor; ?>
        </select>

        <label for="ipk">Masukkan IPK:</label>
        <input type="number" step="0.01" id="ipk" name="ipk" min="0" max="4" placeholder="IPK (0.00 - 4.00)" value="3.4" required onblur="moveToBeasiswa(); validateIPK()">

        <label for="beasiswa">Jenis Beasiswa:</label>
        <select id="beasiswa" name="beasiswa" required disabled>
            <option value="" disabled selected>Pilih Jenis Beasiswa</option>
            <option value="Beasiswa Akademik">Beasiswa Akademik</option>
            <option value="Beasiswa Non-Akademik">Beasiswa Non-Akademik</option>
        </select>

        <label for="berkas">Upload Berkas Syarat:</label>
        <input type="file" id="berkas" name="berkas" required disabled>

        <button type="submit" id="submit" disabled>Daftar</button>
    </form>

    <!-- Tombol Kembali ke Beranda -->
    <div class="button-container" style="text-align: center; margin-top: 20px;">
        <a href="index.php" style="padding: 10px 20px; background-color: #000080; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">Kembali ke Beranda</a>
    </div>
</div>
</body>
</html>
