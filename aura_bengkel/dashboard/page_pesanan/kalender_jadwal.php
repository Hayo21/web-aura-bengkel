<?php
session_start();  // Mulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../../login_register/form_login.php");  // Redirect ke halaman login jika belum login
    exit();
}

include '../../login_register/koneksi.php';  // Sesuaikan jalur file koneksi

// Ambil jumlah pembookingan untuk setiap tanggal yang sekarang atau yang akan datang
$sql = "SELECT tanggal_pemesanan, COUNT(*) as jumlah_pembooking 
        FROM pemesanan_layanan 
        WHERE tanggal_pemesanan >= CURDATE() 
        GROUP BY tanggal_pemesanan";
$result = $conn->query($sql);

// Debugging: Cek apakah query berhasil
if ($result === FALSE) {
    die("Error: " . $conn->error);
}

$pembookingan = [];
while ($row = $result->fetch_assoc()) {
    $pembookingan[$row['tanggal_pemesanan']] = $row['jumlah_pembooking'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalender Jadwal Pembookingan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/dashboard_style.css"> <!-- Link ke file CSS -->
</head>
<body style="background-color: #2d3250;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Kalender Jadwal Pembookingan</h2>
                        <div class="text-center mt-3">
                            <a href="../../dashboard/dashboard_page.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                        </div>

                        <div class="container shadow p-3">
                            <div class="table-responsive mt-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Jumlah Pembooking</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($pembookingan as $tanggal => $jumlah) {
                                            echo "<tr>";
                                            echo "<td>" . $tanggal . "</td>";
                                            echo "<td>" . $jumlah . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
