<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['status_login'])) {
    header("Location: loginpage.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard IjulDailyNotes</title>
    <link rel="stylesheet" href="main.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">

</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Halo, <b><?php echo $_SESSION['nama_user'] ?? 'Admin'; ?>!</b></h2>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h4 class="card-title mb-3">To do List</h4>
                <a href="create.php" class="btn btn-primary mb-3">+ Tambah List</a>

                <table class="table table-hover table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama List</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM dataset";
                        $result = $conn->query($query);
                        $no = 1;

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='text-center'>" . $no++ . "</td>";
                                echo "<td>" . $row['nama_list'] . "</td>";
                                echo "<td>" . $row['deskripsi'] . "</td>";
                                echo "<td class='text-center'>
                                        <a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a>
                                        <a href='delete.php?id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center text-muted'>Data masih kosong. Silakan tambah data.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>