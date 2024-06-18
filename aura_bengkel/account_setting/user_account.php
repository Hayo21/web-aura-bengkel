<?php
session_start(); // Mulai sesi

// Cek apakah pengguna sudah login dan merupakan admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login_register/form_login.php"); // Redirect ke halaman login jika belum login atau bukan admin
    exit();
}

// Tambahkan logika halaman admin di sini
include '../login_register/koneksi.php'; // Sesuaikan jalur file koneksi

// Ambil pesan notifikasi jika ada
if (isset($_SESSION['pesan'])) {
    $pesan = $_SESSION['pesan'];
    $type = $pesan['type']; // Jenis notifikasi (success, danger, warning, dll.)
    $message = $pesan['message']; // Isi pesan notifikasi
    // Tampilkan notifikasi dengan alert Bootstrap
    echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
                $message
                  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
           </div>";
    unset($_SESSION['pesan']); // Hapus pesan setelah ditampilkan
}

// Inisialisasi variabel pencarian
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search']; // Tangkap nilai pencarian dari formulir
}

// Ambil data pengguna dari database
$sql = "SELECT id, username, role FROM users";

// Periksa apakah ada input pencarian
if (!empty($search)) {
    // Gunakan parameter pencarian dalam query SQL
    $sql .= " WHERE username LIKE '%$search%'";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>
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
                    <!-- Kembali ke Halaman Admin -->
                    <li class="nav-item">
                        <a class="nav-link" href="../dashboard/admin_page.php" style="color: #f9b17a;">Kembali ke Halaman Admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar end -->

    <div class="container mt-5">
        <h2 class="text-center mb-4">User Account</h2>

        <!-- Form Pencarian -->
        <form method="GET" action="" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan username" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-secondary">Filter Pencarian</button>
                <?php if (!empty($search)) : ?>
                    <a href="user_account.php" class="btn btn-danger">Clear Filter</a>
                <?php endif; ?>
            </div>
        </form>
        <!-- End Form Pencarian -->

        <!-- Tampilkan informasi akun pengguna -->
        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title">Daftar User Account</h3>
                <div class="table-responsive">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["username"] . "</td>";
                                    echo "<td>" . $row["role"] . "</td>";
                                    echo "<td>";
                                    echo "<div class='btn-group' role='group' aria-label='Aksi'>";
                                    echo "<a href='proses_ubah_role.php?id=" . $row["id"] . "&role=user' class='btn btn-info'>Ubah ke User</a>";
                                    echo "<a href='proses_ubah_role.php?id=" . $row["id"] . "&role=admin' class='btn btn-success'>Ubah ke Admin</a>";
                                    echo "<a href='proses_hapus_akun.php?id=" . $row["id"] . "' class='btn btn-danger'>Hapus Akun</a>";
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>Tidak ada user account</td></tr>";
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
