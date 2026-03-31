<?php
session_start();
include 'db.php';


// LOGIN CEK
if (!isset($_SESSION["status_login"]) || $_SESSION["status_login"] != true) {
    echo '<script>window.location="login.php"</script>';
    exit;
}

//    TAMBAH KATEGORI
if (isset($_POST['submit'])) {

    $ket_kategori = mysqli_real_escape_string(
        $conn,
        trim($_POST['ket_kategori'])
    );

    if (empty($ket_kategori)) {
        echo "<script>
                alert('Keterangan kategori harus diisi!');
                window.location='data_kategori.php';
              </script>";
        exit;
    } else {

        $add = mysqli_query(
            $conn,
            "INSERT INTO kategori (ket_kategori)
             VALUES ('$ket_kategori')"
        );

        if ($add) {
            echo '<script>alert("Data berhasil ditambahkan!"); window.location="data_kategori.php"</script>';
            exit;
        } else {
            echo '<script>alert("Gagal menambahkan data!"); window.location="data_kategori.php"</script>';
        }
    }
}

    // = DELETE KATEGORI = //
if (isset($_GET['delete'])) {

    $id = (int) $_GET['delete'];

    // Ambil semua id_pelaporan yang pakai kategori ini
    $get_ids = mysqli_query($conn, "SELECT id_pelaporan FROM input_aspirasi WHERE id_kategori = '$id'");
    $ids_to_delete = array();
    
    while ($row_id = mysqli_fetch_assoc($get_ids)) {
        $ids_to_delete[] = $row_id['id_pelaporan'];
    }
    
    // Hapus dari tabel aspirasi 
    if (count($ids_to_delete) > 0) {
        $id_list = implode(',', $ids_to_delete);
        mysqli_query($conn, "DELETE FROM aspirasi WHERE id_pelaporan IN ($id_list)");
    }
    
    // Hapus dari tabel input_aspirasi
    mysqli_query($conn, "DELETE FROM input_aspirasi WHERE id_kategori = '$id'");
    
    // Hapus kategori
    $delete = mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori = '$id'");

    if ($delete) {
        echo "<script>
                alert('✅ Kategori dan semua aspirasi terkait berhasil dihapus!');
                window.location='data_kategori.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('❌ Gagal menghapus kategori');
                window.location='data_kategori.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori</title>
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
            <h1>📋 Kelola Kategori</h1>
        </div>

        <div class="layout-content">
            <!-- + KATEGORI (KECIL) -->
            <div class="form-kecil">
                <div class="form-container">
                    <h3>➕ Tambah Kategori</h3>

                    <form method="POST">
                        <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="ket_kategori" class="form-control" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-success" style="width:100%;">
                            ✅ Simpan
                        </button>
                    </form>
                </div>
            </div>

            <!-- KATEGORI (BESAR) -->
            <div class="tabel-besar">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $query = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori ASC");

                            if (mysqli_num_rows($query) > 0) :
                                while ($row = mysqli_fetch_assoc($query)) :
                            ?>
                                    <tr>
                                        <td><?= $row['id_kategori']; ?></td>
                                        <td><?= $row['ket_kategori']; ?></td>
                                        <td>
                                            <a href="?delete=<?= $row['id_kategori']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('⚠️ PERHATIAN! Yakin ingin menghapus kategori: <?= $row['ket_kategori']; ?>? Data kategori BESERTA SEMUA ASPIRASI akan DIHAPUS PERMANEN!')">
                                                🗑️ Hapus
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                            else:
                                ?>
                                <tr>
                                    <td colspan="3">Belum ada kategori</td>
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