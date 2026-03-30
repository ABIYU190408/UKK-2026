<?php
session_start();
include 'db.php';

if($_SESSION["status_login"] != true){
    echo '<script>window.location="login.php"</script>';
    exit;
}

$nis = $_GET['nis'];

// Get current data
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis'");
$data = mysqli_fetch_assoc($query);

if(!$data){
    echo '<script>alert("Data tidak ditemukan!"); window.location="data_siswa.php"</script>';
    exit;
}

if(isset($_POST['submit'])){
    $nis_baru = mysqli_real_escape_string($conn, $_POST['nis']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);

    // Jika NIS berubah, gunakan UPDATE dengan kondisi WHERE nis lama
    if($nis_baru != $nis){
        $update = mysqli_query($conn, "UPDATE siswa SET nis='$nis_baru', kelas='$kelas' WHERE nis='$nis'");
    } else {
        // Jika NIS tidak berubah, update hanya kelas
        $update = mysqli_query($conn, "UPDATE siswa SET kelas='$kelas' WHERE nis='$nis'");
    }
    
    if($update){
        echo '<script>alert("Data berhasil diperbarui!"); window.location="data_siswa.php"</script>';
        exit;
    } else {
        echo '<script>alert("Gagal memperbarui data! Pastikan NIS tidak duplikat."); window.location="data_siswa.php"</script>';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa - Sistem Aspirasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="dashboard.php" class="navbar-brand">
                🎓 Sistem Aspirasi
            </a>

            <ul class="navbar-menu">
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="data_aspirasi.php">Aspirasi</a></li>
                <li><a href="data_input_aspirasi.php">Input Aspirasi</a></li>
                <li><a href="data_siswa.php" class="active">Siswa</a></li>
                <li><a href="data_kategori.php">Kategori</a></li>
            </ul>

            <div class="navbar-user">
                <strong><?= $_SESSION["username"]; ?></strong>
                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="main-container">
        <div class="page-header">
            <h1>✏️ Edit Siswa</h1>
            <p>Perbarui data siswa</p>
        </div>

        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="text" id="nis" name="nis" class="form-control" value="<?= $data['nis'] ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <input type="text" id="kelas" name="kelas" class="form-control" value="<?= $data['kelas'] ?>" required>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-warning btn-sm">Simpan</button>
                    <a href="data_siswa.php" class="btn btn-danger btn-sm">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <footer style="text-align: center; padding: 20px; color: #64748b; font-size: 14px; margin-top: 40px; border-top: 1px solid #e2e8f0;">
        <p>&copy; 2026 Sistem Aspirasi Siswa</p>
    </footer>
</body>
</html>
