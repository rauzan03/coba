<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "beasiswa";

// Membuat koneksi ke database
$conn = new mysqli(hostname: $servername, username: $username, password: $password, database: $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
