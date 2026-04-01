<?php
session_start();
include 'db.php';

/* ================= SEARCH FILTER ================= */
$search_nis    = "";

$sql = "
SELECT
    ia.id_pelaporan,
    ia.nis,
    s.kelas,
    ia.lokasi,
    ia.created_at,
    ia.ket,
    k.ket_kategori,
    a.status,
    a.feedback
FROM input_aspirasi ia
LEFT JOIN kategori k ON ia.id_kategori = k.id_kategori
LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
LEFT JOIN siswa s ON ia.nis = s.nis
WHERE 1=1
";

if(isset($_POST['search'])){
    $search_nis    = mysqli_real_escape_string($conn,$_POST['nis']);
    
    if(!empty($search_nis))   $sql .= " AND ia.nis LIKE '%$search_nis%'";
    
}

$sql .= " ORDER BY ia.id_pelaporan DESC";
$query = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sistem Aspirasi Siswa</title>
<link rel="stylesheet" href="style.css">
</head>

<body>

<!-- NAVBAR -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="index.php" class="navbar-brand">
                Aspirasi Siswa
            </a>
            <ul class="navbar-menu">
                <li><a href="index.php">Beranda</a></li>
                <li><a href="tambah-aspirasi.php">Kirim Aspirasi</a></li>
                <li><a href="history.php">History Aspirasi</a></li>
                <li><a href="login.php">Admin</a></li>
            </ul>
        </div>
    </nav>

    
    <div class="search-box">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Cari Aspirasi</h2>
            <button type="button" class="btn btn-success" onclick="location.href='tambah-aspirasi.php'">
                Kirim Aspirasi Anda
            </button>
        </div>

    <!--  SEARCH + FILTER  -->
        <form method="POST" class="filter-form">
            <!-- Search NIS -->
            <label>
                NIS Siswa
                <input type="text" name="nis" placeholder="Masukkan NIS..." value="<?= $search_nis ?>">
            </label>

            <div class="filter-actions">
                <button type="submit" name="search" class="btn">
                    Cari
                </button>
                
            </div>
        </form>
        <div class="search-info">
           </i> Kosongkan pencarian untuk melihat semua data
        </div>
    </div>

    <!-- ================= TABLE ================= -->
    <div class="table-container">
        <div class="table-header">
            <h2>History Aspirasi Siswa</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>NIS</th>
                    <!-- <th>Kelas</th> -->
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                    <th>Feedback</th>
                </tr>
            </thead>
            <tbody>
<?php
$no = 1;
if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_assoc($query)){
        $status_lower = strtolower($row['status']);
        $badge_class = $status_lower === 'selesai' ? 'badge-selesai' : ($status_lower === 'proses' ? 'badge-proses' : 'badge-menunggu');
?>
<tr>
    <td style="text-align: center; font-weight: 600;"><?= $no++ ?></td>
    <td>
        <?= date('d/m/Y H:i', strtotime($row['created_at'])) ?>
    </td>
    <td style="font-weight: 600;">
        <?= $row['nis'] ?>
    </td>
    <!-- <td><?= $row['kelas'] ?></td> -->
    <td><?= $row['ket_kategori'] ?></td>
    <td><?= $row['lokasi'] ?></td>
    <td><?= $row['ket'] ?></td>
    <td><?= $row['status'] ?></td>
    <td><?= $row['feedback'] ?></td>
</tr>
<?php
    }
}else{
?>
<tr>
    <td colspan="9" class="text-center" style="padding: 40px;">
        <div class="empty-state">
            <div class="empty-state-icon">📭</div>
            <h3>Data Tidak Ditemukan</h3>
            <p>Tidak ada aspirasi yang sesuai dengan filter pencarian Anda</p>
        </div>
    </td>
</tr>
<?php } ?>
            </tbody>
        </table>
    </div>

</div>
    
    <!-- footer -->
    <footer style="text-align: center; padding: 20px; color: #64748b; font-size: 14px; margin-top: 40px; border-top: 1px solid #e2e8f0;">
        <p>&copy; 2026 Sistem Aspirasi Siswa</p>
    </footer>
</body>
</html>
