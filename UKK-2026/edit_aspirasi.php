<?php
session_start();
include 'db.php';

if($_SESSION["status_login"] != true){
    echo '<script>window.location="login.php"</script>';
    exit;
}

$id = $_GET['id'];

// ambil data dari tabel input_aspirasi
$query = mysqli_query($conn, "SELECT a.*, i.ket 
    FROM aspirasi a 
    LEFT JOIN input_aspirasi i ON a.id_pelaporan = i.id_pelaporan 
    WHERE a.id_aspirasi = '$id'");
$data = mysqli_fetch_assoc($query);

if(!$data){
    echo '<script>alert("Data tidak ditemukan!"); window.location="data_aspirasi.php"</script>';
    exit;
}

if(isset($_POST['submit'])){
    $id_pelaporan = $_POST['id_pelaporan'];
    $status = $_POST['status'];
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    $update = mysqli_query($conn, "UPDATE aspirasi SET id_pelaporan='$id_pelaporan', status='$status', feedback='$feedback' WHERE id_aspirasi='$id'");
    
    if($update){
        echo '<script>alert("Data berhasil diperbarui!"); window.location="data_aspirasi.php"</script>';
        exit;
    } else {
        echo '<script>alert("Gagal memperbarui data!"); window.location="edit_aspirasi.php?id='.$id.'"</script>';
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jawab Aspirasi - Sistem Aspirasi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="dashboard.php" class="navbar-brand">
                 Sistem Aspirasi
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
            <h1>✏️ Jawab Aspirasi</h1>
            <p>Perbarui data aspirasi siswa</p>
        </div>

        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="id_pelaporan">Pilih Pelaporan</label>
                    <?php
                    $pelaporan_row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nis FROM input_aspirasi WHERE id_pelaporan = '" . $data['id_pelaporan'] . "'"));
                    $display = $data['id_pelaporan'];
                    if($pelaporan_row && !empty($pelaporan_row['nis'])){
                        $display = '#' . $data['id_pelaporan'] . ' - NIS: ' . $pelaporan_row['nis'];
                    }
                    ?>
                    <input type="hidden" name="id_pelaporan" value="<?= $data['id_pelaporan'] ?>">
                    <input type="text" name="pelaporan_display" class="form-control" value="<?= $display ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="keterangan">Keterangan Aspirasi</label>
                    <input type="text" name="keterangan" class="form-control" value="<?= isset($data['ket']) ? htmlspecialchars($data['ket']) : '-' ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="Menunggu" <?= ($data['status'] == 'Menunggu') ? 'selected' : '' ?>>Menunggu</option>
                        <option value="Proses" <?= ($data['status'] == 'Proses') ? 'selected' : '' ?>>Proses</option>
                        <option value="Selesai" <?= ($data['status'] == 'Selesai') ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="feedback">Feedback</label>
                    <textarea id="feedback" name="feedback" class="form-control" required><?= $data['feedback'] ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit" class="btn btn-success">✅ Simpan Perubahan</button>
                    <a href="data_aspirasi.php" class="btn" style="background-color: #64748b;">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <footer style="text-align: center; padding: 20px; color: #64748b; font-size: 14px; margin-top: 40px; border-top: 1px solid #e2e8f0;">
        <p>&copy; 2026 Sistem Aspirasi Siswa</p>
    </footer>
</body>
</html>
