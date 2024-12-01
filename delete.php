<?php
// Koneksi ke database
include('db.php');

// Mengambil parameter ID dari URL
$id = $_GET['id'];

// Menghapus data berdasarkan ID
$sql = "DELETE FROM pemesanan_kamar WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    // Reset ulang ID pada tabel agar tetap berurutan
    $conn->query("SET @num = 0");
    $conn->query("UPDATE pemesanan_kamar SET id = (@num := @num + 1)");
    $conn->query("ALTER TABLE pemesanan_kamar AUTO_INCREMENT = 1");

    // Menampilkan notifikasi bahwa data berhasil dihapus
    echo "<script>alert('Data berhasil dihapus!'); window.location.href = 'index.php';</script>";
} else {
    // Menampilkan pesan error jika proses penghapusan gagal
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Menutup koneksi ke database
$conn->close();
?>
