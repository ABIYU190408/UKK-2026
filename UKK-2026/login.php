<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN - Sistem Aspirasi Siswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <div class="login-header">
                <h1>Sistem Aspirasi</h1>
            </div>
            
            <form action="" method="POST" class="login-form">
                <div class="form-group">
                    <label for="user">Username</label>
                    <input type="text" id="user" name="user" placeholder="Masukkan username" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="pass">Password</label>
                    <input type="password" id="pass" name="pass" placeholder="Masukkan password" class="form-control" required>
                </div>

                <button type="submit" name="submit" class="btn btn-danger">LOGIN</button>
                <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">KEMBALI KE BERANDA</button>
                
            </form>
        </div>
    </div>

    <?php
    session_start();
    if(isset($_POST['submit'])){
        include 'db.php'; 
        
        $user = trim($_POST['user']);
        $pass = $_POST['pass'];

        $user = mysqli_real_escape_string($conn, $user);
        $pass_hash = md5($pass);

        $cek = mysqli_query($conn, "SELECT * FROM admin WHERE username = '".$user."' AND password = '".$pass_hash."'");
        
        if(mysqli_num_rows($cek) > 0){
            $d = mysqli_fetch_object($cek);
            $_SESSION["status_login"] = true;
            $_SESSION["a_global"] = $d;
            $_SESSION["id_admin"] = $d->id_admin;
            $_SESSION["username"] = $d->username;

            echo "<script>
                alert('Login Berhasil! Selamat datang di sistem aspirasi, ".$d->username."');
                window.location='dashboard.php';
            </script>";
        }else{
            echo "<script>alert('❌ Login Gagal: Username atau password salah!')</script>";
        }
    }
    ?>
</body>
</html>