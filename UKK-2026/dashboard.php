<?php
session_start();
include 'db.php';

if($_SESSION["status_login"] != true){
    echo '<script>window.location="login.php"</script>';
    exit;
}

// Hitung jumlah data
$total_aspirasi = 0;
$total_pelaporan = 0;
$total_kategori = 0;
$total_siswa = 0;

$query = mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi");
$data = mysqli_fetch_assoc($query);
$total_aspirasi = $data['total'];

$query = mysqli_query($conn, "SELECT COUNT(*) as total FROM input_aspirasi");
$data = mysqli_fetch_assoc($query);
$total_pelaporan = $data['total'];

$query = mysqli_query($conn, "SELECT COUNT(*) as total FROM kategori");
$data = mysqli_fetch_assoc($query);
$total_kategori = $data['total'];

$query = mysqli_query($conn, "SELECT COUNT(*) as total FROM siswa");
$data = mysqli_fetch_assoc($query);
$total_siswa = $data['total'];

// Hitung status aspirasi
$menunggu = mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi WHERE status = 'Menunggu'");
$data_menunggu = mysqli_fetch_assoc($menunggu);
$total_menunggu = $data_menunggu['total'];

$proses = mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi WHERE status = 'Proses'");
$data_proses = mysqli_fetch_assoc($proses);
$total_proses = $data_proses['total'];

$selesai = mysqli_query($conn, "SELECT COUNT(*) as total FROM aspirasi WHERE status = 'Selesai'");
$data_selesai = mysqli_fetch_assoc($selesai);
$total_selesai = $data_selesai['total'];

// Search defaults and list query (shows aspirasi with related data)
$search_nis    = "";
$search_kelas  = "";
$search_status = "";
$search_tanggal = "";

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
    $search_kelas  = mysqli_real_escape_string($conn,$_POST['kelas']);
    $search_status = mysqli_real_escape_string($conn,$_POST['status']);

    if(!empty($search_nis))    $sql .= " AND ia.nis LIKE '%$search_nis%'";
    if(!empty($search_kelas))  $sql .= " AND s.kelas LIKE '%$search_kelas%'";
    if(!empty($search_status)) $sql .= " AND a.status = '$search_status'";

}

$sql .= " ORDER BY ia.id_pelaporan DESC";
$query = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Aspirasi</title>
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
            <h1>Dashboard</h1>
            <p>Kelola data sistem aspirasi siswa</p>
        </div>

        <!-- STATS-->
        <div class="stats-grid">
            <div class="stat-card blue">
                <div class="stat-icon">📤</div>
                <div class="stat-label">Total Aspirasi</div>
                <div class="stat-value"><?= $total_aspirasi ?></div>
            </div>

            <div class="stat-card orange">
                <div class="stat-icon">📥</div>
                <div class="stat-label">Total Pelaporan</div>
                <div class="stat-value"><?= $total_pelaporan ?></div>
            </div>

            <div class="stat-card green">
                <div class="stat-icon">👥</div>
                <div class="stat-label">Total Siswa</div>
                <div class="stat-value"><?= $total_siswa ?></div>
            </div>

            <div class="stat-card red">
                <div class="stat-icon">📋</div>
                <div class="stat-label">Total Kategori</div>
                <div class="stat-value"><?= $total_kategori ?></div>
            </div>
        </div>

        <!-- STATUS -->
        <div class="stats-grid">
            <div class="stat-card" style="border-left-color: #f59e0b;">
                <div class="stat-icon">⏳</div>
                <div class="stat-label">Status Menunggu</div>
                <div class="stat-value" style="color: #f59e0b;"><?= $total_menunggu ?></div>
            </div>

            <div class="stat-card" style="border-left-color: #3b82f6;">
                <div class="stat-icon">⚙️</div>
                <div class="stat-label">Status Proses</div>
                <div class="stat-value" style="color: #3b82f6;"><?= $total_proses ?></div>
            </div>

            <div class="stat-card" style="border-left-color: #10b981;">
                <div class="stat-icon">✅</div>
                <div class="stat-label">Status Selesai</div>
                <div class="stat-value" style="color: #10b981;"><?= $total_selesai ?></div>
            </div>
        </div>
    </div>

    <div class="main-container">


    <!-- ================= SEARCH + FILTER ================= -->

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
                    <th>Kelas</th>
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
        $status_class = strtolower($row['status']);
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $row['created_at'] ?></td>
    <td><?= $row['nis'] ?></td>
    <td><?= $row['kelas'] ?></td>
    <td><?= $row['ket_kategori'] ?></td>
    <td><?= $row['lokasi'] ?></td>
    <td><?= $row['ket'] ?></td>
    <td><span class="badge badge-<?= $status_class ?>"><?= $row['status'] ?></span></td>
    <td><?= $row['feedback'] ?></td>
</tr>
<?php
    }
}else{
?>
<tr>
    <td colspan="9" class="text-center">Data tidak ditemukan</td>
</tr>
<?php } ?>
            </tbody>
        </table>
    </div>


    
    <footer style="text-align: center; padding: 20px; color: #64748b; font-size: 14px; margin-top: 40px; border-top: 1px solid #e2e8f0;">
        <p>&copy; 2026 Sistem Aspirasi Siswa</p>
    </footer>
</body>
</html>
