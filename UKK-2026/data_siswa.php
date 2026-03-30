<?php
session_start();
include 'db.php';

if (!isset($_SESSION["status_login"]) || $_SESSION["status_login"] != true) {
    echo '<script>window.location="login.php"</script>';
    exit;
}

// TAMBAH DATA SISWA

if (isset($_POST['submit'])) {
    $nis = mysqli_real_escape_string($conn, trim($_POST['nis']));
    $kelas = mysqli_real_escape_string($conn, trim($_POST['kelas']));

    if (empty($nis) || empty($kelas)) {
        echo "<script>
                alert('NIS dan Kelas harus diisi!');
                window.location='data_siswa.php';
              </script>";
        exit;
    } else {
        $check_nis = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis'");
        if (mysqli_num_rows($check_nis) > 0) {
            echo "<script>
                    alert('NIS sudah terdaftar!');
                    window.location='data_siswa.php';
                  </script>";
            exit;
        } else {
            $add = mysqli_query($conn, "INSERT INTO siswa (nis, kelas) VALUES ('$nis', '$kelas')");
            if ($add) {
                echo "<script>
                        alert('Data siswa berhasil ditambahkan!');
                        window.location='data_siswa.php';
                      </script>";
                exit;
            } else 
            echo "<script>
                    alert('Gagal menambahkan data siswa!');
                    window.location='data_siswa.php';
                  </script>";

        }
    }
}


   //  DELETE DATA SISWA 

if (isset($_GET['delete'])) {
    $nis = mysqli_real_escape_string($conn, $_GET['delete']);
    
    // Ambil semua id_pelaporan dari siswa ini
    $get_ids = mysqli_query($conn, "SELECT id_pelaporan FROM input_aspirasi WHERE nis = '$nis'");
    $ids_to_delete = array();
    
    while ($row_id = mysqli_fetch_assoc($get_ids)) {
        $ids_to_delete[] = $row_id['id_pelaporan'];
    }
    
    // Hapus dari tabel aspirasi dulu berdasarkan id_pelaporan yang ditemukan 
    if (count($ids_to_delete) > 0) {
        $id_list = implode(',', $ids_to_delete);
        mysqli_query($conn, "DELETE FROM aspirasi WHERE id_pelaporan IN ($id_list)");
    }
    
    // Hapus dari tabel input_aspirasi
    mysqli_query($conn, "DELETE FROM input_aspirasi WHERE nis = '$nis'");
    
    // Hapus siswa
    $delete = mysqli_query($conn, "DELETE FROM siswa WHERE nis = '$nis'");
    
    if ($delete) {
        echo "<script>
                alert('✅ Data siswa dan semua aspirasi terkait berhasil dihapus!');
                window.location='data_siswa.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('❌ Gagal menghapus data siswa');
                window.location='data_siswa.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
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
                <li><a href="data_siswa.php" >Siswa</a></li>
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
            <h1>👥 Data Siswa</h1>
        </div>

        <div class="layout-content">
            <!-- FORM TAMBAH SISWA (KECIL) -->
            <div class="form-kecil">
                <div class="form-container">
                    <h3>➕ Tambah Siswa</h3>

                    <form method="POST">
                        <div class="form-group">
                            <label>NIS</label>
                            <input type="text" name="nis" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Kelas</label>
                            <input type="text" name="kelas" class="form-control" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-success" style="width:100%;">
                            ✅ Simpan
                        </button>
                    </form>
                </div>
            </div>

            <!-- TABEL DATA SISWA (BESAR) -->
            <div class="tabel-besar">
                <div class="table-container">
                    <div class="table-header">
                        <h2>Daftar Siswa</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nis DESC");

                            if (mysqli_num_rows($query) > 0) :
                                while ($row = mysqli_fetch_assoc($query)) :
                            ?>
                                    <tr>
                                        <td><strong><?= $row['nis']; ?></strong></td>
                                        <td><?= $row['kelas']; ?></td>
                                        <td>
                                            <a href="edit_siswa.php?nis=<?= $row['nis']; ?>" class="btn btn-warning btn-sm">✏️ Ubah</a>
                                            <a href="?delete=<?= $row['nis']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('⚠️ PERHATIAN! Yakin ingin menghapus siswa dengan NIS: <?= $row['nis']; ?>? Data siswa BESERTA SEMUA ASPIRASI akan DIHAPUS PERMANEN!')">🗑️ Hapus</a>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                            else:
                                ?>
                                <tr>
                                    <td colspan="3">
                                        <div class="empty-state">
                                            <div class="empty-state-icon">📭</div>
                                            <p>Tidak ada data siswa</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   <!-- footer -->
    <footer style="text-align: center; padding: 20px; color: #64748b; font-size: 14px; margin-top: 40px; border-top: 1px solid #e2e8f0;">
        <p>&copy; 2026 Sistem Aspirasi Siswa</p>
    </footer>



</body>

</html>