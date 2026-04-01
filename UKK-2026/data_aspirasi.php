<?php
session_start();
include 'db.php';

/* ================= CEK LOGIN ================= */
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
    exit;
}

/* ================= FILTER ================= */
$tgl = isset($_GET['tgl']) ? $_GET['tgl'] : '';
$bulan_tahun = isset($_GET['bulan_tahun']) ? $_GET['bulan_tahun'] : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';
$nis = isset($_GET['nis']) ? $_GET['nis'] : '';
$kelas = isset($_GET['kelas']) ? $_GET['kelas'] : '';

$status = isset($_GET['status']) ? $_GET['status'] : '';

$where = "";

if ($tgl) {
    $where .= " AND DATE(i.created_at) = '$tgl'";
}

if ($bulan_tahun) {
    $ym = explode('-', $bulan_tahun);
    if(count($ym) == 2) {
        $where .= " AND YEAR(i.created_at) = " . (int)$ym[0] . " AND MONTH(i.created_at) = " . (int)$ym[1];
    }
}

if ($kategori) {
    $where .= " AND i.id_kategori='$kategori'";
}

if ($nis) {
    $where .= " AND i.nis='$nis'";
}

if ($kelas) {
    $where .= " AND s.kelas='$kelas'";
}

if ($status) {
    $where .= " AND a.status='$status'";
}


/* ================= HAPUS ================= */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Ambil id_pelaporan dari aspirasi yang akan dihapus
    $result = mysqli_query($conn, "SELECT id_pelaporan FROM aspirasi WHERE id_aspirasi='$id'");
    $row = mysqli_fetch_assoc($result);
    $id_pelaporan = $row['id_pelaporan'];

    // Hapus dari aspirasi
    mysqli_query($conn, "DELETE FROM aspirasi WHERE id_aspirasi='$id'");

    // Hapus dari input_aspirasi (history)
    mysqli_query($conn, "DELETE FROM input_aspirasi WHERE id_pelaporan='$id_pelaporan'");

    echo "<script>window.location='data_aspirasi.php'</script>";
}

/* ================= QUERY ================= */
$query = mysqli_query($conn, "
SELECT i.*, a.status, a.feedback, a.id_aspirasi, k.ket_kategori, s.kelas
FROM input_aspirasi i
JOIN aspirasi a ON i.id_pelaporan = a.id_pelaporan
JOIN kategori k ON i.id_kategori = k.id_kategori
JOIN siswa s ON i.nis = s.nis
WHERE 1=1 $where
ORDER BY i.created_at DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Aspirasi</title>
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
            <h1>📤 Data Aspirasi</h1>
            <p>Kelola semua data aspirasi siswa</p>
        </div>

        <!-- FILTER SECTION -->
        <div class="search-box">
            <form method="GET" class="filter-form">

                <label>
                    Tanggal
                    <input type="date" name="tgl" value="<?= $tgl ?>">
                </label>

                <label>
                    Bulan & Tahun
                    <input type="month" name="bulan_tahun" value="<?= $bulan_tahun ?>">
                </label>

                <label>
                    Kategori
                    <select name="kategori">
                        <option value="">-- Semua --</option>
                        <?php
                        $kat = mysqli_query($conn, "SELECT * FROM kategori");
                        while ($k = mysqli_fetch_array($kat)) {
                        ?>
                            <option value="<?= $k['id_kategori'] ?>"
                                <?= $kategori == $k['id_kategori'] ? 'selected' : '' ?>>
                                <?= $k['ket_kategori'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </label>

                <label>
                    NIS
                    <select name="nis">
                        <option value="">-- Semua --</option>
                        <?php
                        $ns = mysqli_query($conn, "SELECT * FROM siswa");
                        while ($n = mysqli_fetch_array($ns)) {
                        ?>
                            <option value="<?= $n['nis'] ?>"
                                <?= $nis == $n['nis'] ? 'selected' : '' ?>>
                                <?= $n['nis'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </label>

                <label>
                    Kelas
                    <select name="kelas">
                        <option value="">-- Semua --</option>
                        <?php
                        $kl = mysqli_query($conn, "SELECT DISTINCT kelas FROM siswa");
                        while ($kls = mysqli_fetch_array($kl)) {
                        ?>
                            <option value="<?= $kls['kelas'] ?>"
                                <?= $kelas == $kls['kelas'] ? 'selected' : '' ?>>
                                <?= $kls['kelas'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </label>

                <label>
                    Status
                    <select name="status">
                        <option value="">-- Semua --</option>
                        <option value="Menunggu" <?= $status == 'Menunggu' ? 'selected' : '' ?>>Menunggu</option>
                        <option value="Proses" <?= $status == 'Proses' ? 'selected' : '' ?>>Proses</option>
                        <option value="Selesai" <?= $status == 'Selesai' ? 'selected' : '' ?>>Selesai</option>
                    </select>
                </label>

                <div class="filter-actions">
                    <button type="submit" class="btn"> Filter</button>
                    <a href="data_aspirasi.php" class="btn btn-secondary"> Reset</a>
                </div>

            </form>
        </div>

        <!-- TABLE SECTION -->
        <div class="table-container">
            <div class="table-header">
                <h2>Daftar Aspirasi Siswa</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <!-- <th>ID</th> -->
                        <th>NIS</th>
                        <th>Kelas</th>
                        <th>Tanggal & Waktu</th>
                        <th>Kategori</th>
                        <th>Lokasi</th>
                        <!-- <th>Laporan</th> -->
                        <th>Status</th>
                        <th>Feedback</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(mysqli_num_rows($query) > 0) {
                        while ($row = mysqli_fetch_array($query)) { 
                    ?>
                        <tr>
                            <!-- <td><?= $row['id_aspirasi'] ?></td> -->
                            <td><?= $row['nis'] ?></td>
                            <td><?= $row['kelas'] ?></td>  
                            <td>
                                <?= date("d-m-Y H:i:s", strtotime($row['created_at'])) ?>
                            </td>
                            <td><?= $row['ket_kategori'] ?></td>
                            <td><?= $row['lokasi'] ?></td>
                            <!-- <td><?= $row['ket'] ?></td> -->

                            <td>
                                <span class="badge <?= strtolower(str_replace(' ', '', $row['status'])) ?>">
                                    <?= $row['status'] ?>
                                </span>
                            </td>
                            <td>
                               <?= $row['feedback'] ? $row['feedback'] : '-' ?>
                            </td>
                            <td>
                                <a href="edit_aspirasi.php?id=<?= $row['id_aspirasi'] ?>" class="btn btn-warning btn-sm">! JAWAB</a>
                                <a href="?hapus=<?= $row['id_aspirasi'] ?>"
                                    onclick="return confirm('Yakin hapus?')"
                                    class="btn btn-danger btn-sm"> - Hapus</a>
                            </td>
                        </tr>
                    <?php 
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <p>❌ Tidak ada data aspirasi</p>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
