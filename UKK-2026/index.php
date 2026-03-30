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

<div class="main-container">
    <div class="page-header">
        <h1>Selamat Datang di Sistem Aspirasi Siswa</h1>
        <p>Sampaikan aspirasi dan masukan Anda untuk membangun sekolah yang lebih baik</p>
    </div>

    <div style="background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); margin-bottom: 30px;">
        <h2 style="color: #1f2937; margin-bottom: 15px; font-size: 20px;"> Selamat Datang!</h2>
        <p style="color: #6b7280; line-height: 1.8; margin-bottom: 15px;">
            Platform ini memudahkan Anda untuk menyampaikan aspirasi, keluhan, dan saran kepada pihak sekolah. 
            Setiap aspirasi Anda akan ditanggani dengan serius dan akan mendapatkan feedback dari tim yang bertanggung jawab.
        </p>
        <p style="color: #6b7280; line-height: 1.8; margin-bottom: 20px;">
            Untuk memulai, silakan klik tombol "Kirim Aspirasi" di menu navigasi di atas.
        </p>
        <a href="tambah-aspirasi.php" class="btn btn-success" style="font-size: 14px; padding: 12px 24px;">
            Kirim Aspirasi Anda
        </a>
         <a href="history.php" class="btn btn-success" style="font-size: 14px; padding: 12px 24px;">
             Lihat History Aspirasi
        </a>
    </div>

</div>
</body>
</html>