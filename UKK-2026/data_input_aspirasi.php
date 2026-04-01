<?php
session_start();
include 'db.php';

if($_SESSION["status_login"] != true){
    echo '<script>window.location="login.php"</script>';
    exit;
}

// Delete 
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    // aspirasi to foreign key
    mysqli_query($conn, "DELETE FROM aspirasi WHERE id_pelaporan = '$id'");
    
    // Delete from input_aspirasi
    $delete = mysqli_query($conn, "DELETE FROM input_aspirasi WHERE id_pelaporan = '$id'");
    if($delete){
        echo '<script>alert("Data berhasil dihapus!"); window.location="data_input_aspirasi.php"</script>';
    } else {
        echo '<script>alert("Gagal menghapus data!"); window.location="data_input_aspirasi.php"</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Input Aspirasi - Sistem Aspirasi</title>
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
            <li><a href="data_siswa.php">Siswa</a></li>
            <li><a href="data_kategori.php" >Kategori</a></li>
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
            <h1>📥 PELAPORAN ASPIRASI SISWA</h1>
            <p>Kelola semua input aspirasi siswa</p>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h2>Daftar Pelaporan Aspirasi siswa</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>NIS</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <th>Keterangan</th>
                        <!-- <th>Aksi</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM input_aspirasi ORDER BY id_pelaporan DESC");
                    if(mysqli_num_rows($query) > 0):
                        while($row = mysqli_fetch_array($query)):
                    ?>
                    <tr>
                        <td><strong>#<?= $row['id_pelaporan'] ?></strong></td>
                        <td><?= $row['created_at'] ?></td>
                        <td><?= $row['nis'] ?></td>
                        <td><?= $row['id_kategori'] ?></td>
                        <td><?= $row['lokasi'] ?></td>
                        <td><?= $row['ket'] ?></td>
                        <!-- <td>
                            <a href="?delete=<?= $row['id_pelaporan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">🗑️ Hapus</a>
                        </td> -->
                    </tr>
                    <?php 
                        endwhile;
                    else:
                    ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon">📭</div>
                                <p>Tidak ada data input aspirasi</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer style="text-align: center; padding: 20px; color: #64748b; font-size: 14px; margin-top: 40px; border-top: 1px solid #e2e8f0;">
        <p>&copy; 2026 Sistem Aspirasi Siswa</p>
    </footer>
</body>
</html>
