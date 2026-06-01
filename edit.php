<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status_login'])) {
    header("Location: loginpage.php");
    exit;
}

$id = $_GET['id'];
$query_lama = "SELECT * FROM dataset WHERE id='$id'";
$result = $conn->query($query_lama);
$data = $result->fetch_assoc();

if (isset($_POST['update'])) {
    $variabel = $_POST['nama_list'];
    $nilai = $_POST['deskripsi'];

    $query_update = "UPDATE dataset SET nama_list='$variabel', deskripsi='$nilai' WHERE id='$id'";
    if ($conn->query($query_update) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        $error = "Error update data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Data</title>
    <link rel="stylesheet" href="main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card shadow-sm border-0 w-50 mx-auto">
            <div class="card-body">
                <h3 class="mb-4">Edit Data</h3>
                <?php if(isset($error)) { echo "<div class='alert alert-danger'>$error</div>"; } ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label">Nama List</label>
                        <input type="text" name="nama_list" class="form-control" value="<?php echo $data['nama_list']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control" value="<?php echo $data['deskripsi']; ?>" required>
                    </div>
                    <button type="submit" name="update" class="btn btn-success">Update Data</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>