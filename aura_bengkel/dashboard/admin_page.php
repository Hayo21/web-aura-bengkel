<?php
session_start();  // Mulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login_register/form_login.php");  // Redirect ke halaman login jika belum login atau bukan admin
    exit();
}

// Tambahkan logika halaman admin di sini
include '../login_register/koneksi.php';  // Sesuaikan jalur file koneksi

// Ambil data pesanan dari database
$sql = "SELECT * FROM pemesanan_layanan";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../dashboard/admin_style.css"> <!-- Link ke file CSS -->
</head>
<body style="background-color: #2d3250;">

<!-- Navbar start -->
<nav class="navbar navbar-expand-lg shadow mb-5 sticky-top navbar-custom" style="background-color: #192055">
      <div class="container">
        <!-- Brand/logo -->
        <a class="navbar-brand me-auto" href="#" style="font-size: 24px; color: #f9b17a">
          <img src="../halaman_utama/img/profile.jpg" alt="logo" width="40" height="34" class="d-inline-block align-text-top" />
          AURA
        </a>
        <!-- Toggler button for mobile -->
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
          style="color: #f9b17a"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse mt-2" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <!-- Pesanan Dibatalkan link -->
            <li class="nav-item">
              <a class="nav-link" href="../dashboard/page_pesanan/pesanan_dibatalkan.php">Pesanan Dibatalkan</a>
            </li>
            <!-- Pesanan Diterima link -->
            <li class="nav-item">
              <a class="nav-link" href="../dashboard/page_pesanan/pesanan_diterima.php">Pesanan Diterima</a>
            </li>
            <!-- user account -->
            <li class="nav-item">
              <a class="nav-link" href="../account_setting/user_account.php">User Account</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

<!-- Navbar end -->

<div class="container mt-5">
    <h2 class="text-center mb-4">Admin Page</h2>
    <h2 class="text-center mb-4">Selamat datang, <?php echo $_SESSION['username']; ?>!</h2>
    <a href="../login_register/logout.php" class="btn btn-danger mb-3">Logout</a>
    
    <?php
    if (isset($_SESSION['pesan'])) {
        echo "<div class='alert alert-success'>" . $_SESSION['pesan'] . "</div>";
        unset($_SESSION['pesan']);  // Hapus pesan setelah ditampilkan
    }
    if (isset($_GET['error'])) {
        echo "<div class='alert alert-danger'>Terjadi kesalahan: " . htmlspecialchars($_GET['error']) . "</div>";
    }
    ?>

    <div class="card shadow">
        <div class="card-body">
            <h3 class="card-title">Daftar Pesanan</h3>
            <div class="table-responsive">
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Merek dan Model Motor</th>
                            <th>Nomor Polisi</th>
                            <th>Tahun Pembuatan</th>
                            <th>Layanan</th>
                            <th>Deskripsi Masalah</th>
                            <th>Tanggal Pemesanan</th>
                            <th>Waktu Pemesanan</th>
                            <th>Lokasi Anda</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            // Output data dari setiap baris
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["id"] . "</td>";
                                echo "<td>" . $row["nama_lengkap"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["nomor_telepon"] . "</td>";
                                echo "<td>" . $row["merek_model"] . "</td>";
                                echo "<td>" . $row["nomor_polisi"] . "</td>";
                                echo "<td>" . $row["tahun_pembuatan"] . "</td>";
                                echo "<td>" . $row["layanan"] . "</td>";
                                echo "<td>" . $row["deskripsi_masalah"] . "</td>";
                                echo "<td>" . $row["tanggal_pemesanan"] . "</td>";
                                echo "<td>" . $row["waktu_pemesanan"] . "</td>";
                                echo "<td>" . $row["lokasi_bengkel"] . "</td>"; // lokasi bengkel diubah menjadi lokasi_anda
                                echo "<td>" . $row["status"] . "</td>";  // Tampilkan status
                                echo "<td>";
                                echo "<div class='btn-group' role='group' aria-label='Aksi'>";
                                echo "<a href='../pesanan/proses_ubah_status.php?id=" . $row["id"] . "&status=diproses' class='btn btn-info'>Diproses</a>";
                                echo "<a href='../pesanan/proses_ubah_status.php?id=" . $row["id"] . "&status=dibatalkan' class='btn btn-warning'>Dibatalkan</a>";
                                echo "<a href='../pesanan/proses_ubah_status.php?id=" . $row["id"] . "&status=diterima' class='btn btn-success'>Terima</a>";
                                echo "</div>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='14' class='text-center'>Tidak ada pesanan</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Tutup koneksi
$conn->close();
?>
