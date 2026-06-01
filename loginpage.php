<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['status_login'])) {
    header("Location: index.php");
    exit;
}

$pesan = ""; 
$pesan_gagal = "ada yang salah... login gagal!";

// register
if (isset($_POST['register'])) {
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $username = $_POST['username']; 
    $tgl_lahir = $_POST['tanggal_lahir'];
    $jk = $_POST['jenis_kelamin'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $cek = $conn->query("SELECT * FROM users WHERE email='$email' OR username='$username'");
    if ($cek->num_rows > 0) {
        $pesan = "<p style='color:red; font-size:14px; text-align:center; margin-bottom:10px;'>Email atau Username sudah terdaftar!</p>";
    } else {
        $query = "INSERT INTO users (nama_depan, nama_belakang, username, tanggal_lahir, jenis_kelamin, email, password) 
                  VALUES ('$nama_depan', '$nama_belakang', '$username', '$tgl_lahir', '$jk', '$email', '$password')";
        if ($conn->query($query)) {
            $pesan = "<p style='color:green; font-size:14px; text-align:center; margin-bottom:10px;'>Registrasi berhasil! Silakan login.</p>";
        } else {
            $pesan = "<p style='color:red; font-size:14px; text-align:center; margin-bottom:10px;'>Error: " . $conn->error . "</p>";
        }
    }
}

// login process
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek database
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        
        $_SESSION['status_login'] = true;
        $_SESSION['nama_user'] = $user_data['nama_depan'] . " " . $user_data['nama_belakang']; 
        
        header("Location: index.php");
        exit;
    } else {
        $pesan = "<p style='color:red; font-size:14px; text-align:center; margin-bottom:10px;'>Email atau password salah!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IjulDailyNotes FORM</title>
    <!-- <link rel="icon" type="image/png" href="assets/logotok.png" /> -->
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
</head>
<body>
<div class="login-page">
<input type="radio" name="tab" id="loginTab" checked>
<input type="radio" name="tab" id="registerTab">

<div class="container">
    <div class="card">

        <!-- FORM LOGIN -->
        <form class="form login" method="POST" action="">
            <h2>Welcome to <i>IjulDailyNotes!</i></h2>
            
            <!-- notif -->
            <?php echo $pesan; ?>

            <input type="email" name="email" placeholder="Email" required>
            <div style="position:relative; width:100%;">
                <input type="password" name="password" id="loginPassword" placeholder="Password" required style="padding-right:45px;">
                <button type="button" id="toggleLoginPassword" aria-label="Lihat password" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; padding:0; color:#666;">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>

            <button type="submit" name="login" class="btn-login">Login</button>

            <label for="registerTab" class="btn-register">Register</label>
        </form>

        <!-- FORM REGISTER -->
        <form class="form register" method="POST" action="">
            <h2>REGISTER</h2>

            <input type="text" name="nama_depan" placeholder="Nama Depan" required>
            <input type="text" name="nama_belakang" placeholder="Nama Belakang" required>
            <input type="text" name="username" placeholder="Username" required>
            <p style="margin-bottom:8px; margin-top:2px; text-align:left;">Tanggal Lahir</p>
            <input type="date" name="tanggal_lahir" required>

            <select name="jenis_kelamin" required>
                <option value="" disabled selected hidden>Jenis Kelamin</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

            <input type="email" name="email" placeholder="Email" required>
            <div style="position:relative; width:100%;">
                <input type="password" name="password" id="registerPassword" placeholder="Password" required style="padding-right:45px;">
                <button type="button" id="toggleRegisterPassword" aria-label="Lihat password" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; padding:0; color:#666;">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>

            <button type="submit" name="register" class="btn-login">Daftar</button>

            <label for="loginTab" class="btn-register">Kembali</label>
        </form>

    </div>
</div>
</div>

<script>
    function setupPasswordToggle(buttonId, inputId) {
        const button = document.getElementById(buttonId);
        const input = document.getElementById(inputId);

        if (!button || !input) return;

        button.addEventListener('click', function () {
            const visible = input.type === 'text';
            input.type = visible ? 'password' : 'text';
            button.innerHTML = visible
                ? '<i class="fa-solid fa-eye"></i>'
                : '<i class="fa-solid fa-eye-slash"></i>';
        });

        input.addEventListener('keydown', function (e) {
            if (e.key === '`') {
                e.preventDefault();
                button.click();
            }
        });
    }

    setupPasswordToggle('toggleLoginPassword', 'loginPassword');
    setupPasswordToggle('toggleRegisterPassword', 'registerPassword');
</script>

</body>
</html>