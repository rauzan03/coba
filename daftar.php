<?php
include('db.php');

// Mengambil data dari tabel 'pendaftaran' di database
$sql = "SELECT * FROM pendaftaran"; 
$result = $conn->query(query: $sql); // Menjalankan query dan menyimpan hasilnya dalam $result
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pendaftaran Beasiswa</title>
    <style>
        /* Gaya untuk tombol kembali ke beranda */
        .btn-back {
            padding: 10px 20px;
            background-color: #000080; 
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        /* Efek saat tombol di-hover */
        .btn-back:hover {
            background-color: #000080;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Pendaftaran Beasiswa</h2>
    <p>Berikut adalah daftar peserta yang sudah mendaftar:</p>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Nomor HP</th>
                    <th>Semester</th>
                    <th>IPK</th>
                    <th>Jenis Beasiswa</th>
                    <th>Berkas</th>
                    <th>Status Ajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= htmlspecialchars(string: $row['nama']); ?></td>
                        <td><?= htmlspecialchars(string: $row['email']); ?></td>
                        <td><?= htmlspecialchars(string: $row['nomor_hp']); ?></td>
                        <td><?= $row['semester']; ?></td>
                        <td><?= $row['ipk']; ?></td>
                        <td><?= htmlspecialchars(string: $row['pilihan_beasiswa']); ?></td>
                        <td>
                            <?php 
                            // Memeriksa apakah ada file berkas dan apakah file tersebut ada di server
                            if (isset($row['file_berkas']) && !empty($row['file_berkas'])) {
                                $file_path = "uploads/" . htmlspecialchars(string: $row['file_berkas']);
                                if (file_exists(filename: $file_path)) {
                                    echo '<a href="' . $file_path . '" target="_blank">Download</a>';
                                } else {
                                    echo 'File tidak ditemukan';
                                }
                            } else {
                                echo 'Tidak ada berkas';
                            }
                            ?>
                        </td>
                        <td><?= htmlspecialchars(string: $row['status_ajuan']); ?></td>
                        <td>
                            <a href="update.php?id=<?= $row['id']; ?>"><button class="btn-edit">Edit</button></a>
                            <a href="delete.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?')"><button class="btn-delete">Hapus</button></a>
                            <a href="read.php?id=<?= $row['id']; ?>"><button class="btn-view">Lihat</button></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Tidak ada data pendaftar.</p>
    <?php endif; ?>

    <div class="button-container">
        <a href="pendaftaran.php">Pendaftaran Baru</a>
        <a href="index.php" class="btn-back">Kembali ke Beranda</a>
    </div>
</div>
</body>
</html>

<?php $conn->close(); ?>
