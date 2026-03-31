<?php
session_start();
include 'db.php';

if(isset($_POST['submit'])){
    $nis = (int)$_POST['nis'];
    $id_kategori = (int)$_POST['id_kategori'];
    $lokasi = mysqli_real_escape_string($conn, trim($_POST['lokasi']));
    $ket = mysqli_real_escape_string($conn, trim($_POST['ket']));

    // Validasi NIS
    $check_nis = mysqli_query($conn, "SELECT nis FROM siswa WHERE nis = $nis");
    if(mysqli_num_rows($check_nis) == 0){
        echo '<script>alert("NIS tidak valid!"); window.location="tambah-aspirasi.php"</script>';
        exit;
    }
    // Validasi kategori
    else {
        $check_kat = mysqli_query($conn, "SELECT id_kategori FROM kategori WHERE id_kategori = $id_kategori");
        if(mysqli_num_rows($check_kat) == 0){
            echo '<script>alert("Kategori tidak valid!"); window.location="tambah-aspirasi.php"</script>';
            exit;
        }
        else if(empty($lokasi) || empty($ket)){
            echo '<script>alert("Lokasi dan Keterangan harus diisi!"); window.location="tambah-aspirasi.php"</script>';
            exit;
        }
        else {
            // Insert (ID otomatis)
            $add = mysqli_query($conn, "INSERT INTO input_aspirasi (nis, id_kategori, lokasi, ket) 
                                        VALUES ($nis, $id_kategori, '$lokasi', '$ket')");
            
            if($add){
                $new_id = mysqli_insert_id($conn);
                // Auto create aspirasi record
                mysqli_query($conn, "INSERT INTO aspirasi (id_pelaporan, status, feedback) 
                                    VALUES ($new_id, 'Menunggu', '-')");
                
                echo '<script>alert("Terima kasih! Aspirasi Anda telah dikirim dengan ID: #'.$new_id.'"); window.location="tambah-aspirasi.php"</script>';
                exit;
            } else {
                echo '<script>alert("Gagal menambahkan data!"); window.location="tambah-aspirasi.php"</script>';
                exit;
            }
        }
    }
}

// Get lists
$siswa_list = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nis ASC");
$kategori_list = mysqli_query($conn, "SELECT * FROM kategori ORDER BY ket_kategori ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Input Aspirasi - Sistem Aspirasi</title>
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

    <!-- MAIN CONTENT -->
    <div class="main-container">
        <div class="page-header">
            <h1> Kirim Aspirasi & Masukan Anda</h1>
            <p>Bagikan aspirasi Anda untuk membangun sekolah yang lebih baik</p>
        </div>

        <br>
        <br>

        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="nis">Pilih Siswa (NIS)</label>
                    <select id="nis" name="nis" class="form-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php while($row = mysqli_fetch_assoc($siswa_list)): ?>
                        <option value="<?= $row['nis'] ?>"><?= $row['nis'] ?> - <?= $row['kelas'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_kategori">Pilih Kategori</label>
                    <select id="id_kategori" name="id_kategori" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php 
                        $kategori_list = mysqli_query($conn, "SELECT * FROM kategori");
                        while($row = mysqli_fetch_assoc($kategori_list)): 
                        ?>
                   <!-- <option value="<?= $row['id_kategori'] ?>"> <?= $row['id_kategori'] ?> - <?= $row['ket_kategori'] ?></option> -->
                        <option value="<?= $row['id_kategori'] ?>"> <?= $row['ket_kategori'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="lokasi">Lokasi</label>
                    <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Masukkan lokasi..." required>
                </div>

                <div class="form-group">
                    <label for="ket">Keterangan</label>
                    <input type="text" id="ket" name="ket" class="form-control" placeholder="Masukkan keterangan..." required>
                </div>

                <div class="form-actions">
                    <button type="submit" name="submit" class="btn btn-success">✅ Simpan</button>
                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>

    <!-- footer -->
    <footer style="text-align: center; padding: 20px; color: #64748b; font-size: 14px; margin-top: 40px; border-top: 1px solid #e2e8f0;">
        <p>&copy; 2026 Sistem Aspirasi Siswa</p>
    </footer>

</body>
</html>
