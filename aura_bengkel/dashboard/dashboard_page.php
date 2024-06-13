<?php
session_start();  // Mulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: ../form_login.php");  // Redirect ke halaman login jika belum login
    exit();
}

include '../login_register/koneksi.php';  // Sesuaikan jalur file koneksi

// Ambil data pesanan dari database untuk pengguna yang sedang login
$email = $_SESSION['email'];  // Pastikan email disimpan dalam sesi saat login
$sql = "SELECT * FROM pemesanan_layanan WHERE email='$email'";
$result = $conn->query($sql);

// Debugging: Cek apakah query berhasil
if ($result === FALSE) {
    die("Error: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../dashboard/dashboard_style.css"> <!-- Link ke file CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Recursive:wght@400;700&display=swap" rel="stylesheet" /> <!-- font -->
</head>
<body>
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
                    <!-- Home link -->
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Home</a>
                    </li>
                    <!-- Lihat Kalender Booking link -->
                    <li class="nav-item">
                        <a class="nav-link" href="../dashboard/page_pesanan/kalender_jadwal.php" class="btn btn-info">Lihat Kalender Booking</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar end -->

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Dashboard</h2>
                        <p class="text-center">Selamat datang, <?php echo $_SESSION['username']; ?>!</p>
                        <div class="text-center mt-3 mb-4">
                            <a href="../login_register/logout.php" class="btn btn-danger">Logout</a>
                        </div>
                        
                        <div class="row" id="home">
                            <div class="col-md-6">
                                <h3 class="mt-4">Formulir Pemesanan Layanan</h3>
                                <?php
                                if (isset($_GET['status']) && $_GET['status'] == 'success') {
                                    echo '<p class="text-success">Pemesanan berhasil!</p>';
                                }
                                if (isset($_GET['error']) && $_GET['error'] == 'slot_taken') {
                                    echo '<p class="text-danger">Waktu pemesanan sudah terisi. Silakan pilih waktu lain.</p>';
                                }
                                ?>
                                <form action="../pesanan/proses_pemesanan.php" method="POST" onsubmit="return validateForm()">
                                    <div class="mb-3">
                                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                        <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" name="email" class="form-control" required>
                                        <p class="small">( pastikan email anda sama dengan akun yang didaftarkan agar tercata di historis pemesanan )</p>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_telepon" class="form-label">Nomor Telepon</label>
                                        <input type="tel" id="nomor_telepon" name="nomor_telepon" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="merek_model" class="form-label">Merek dan Model Motor</label>
                                        <input type="text" id="merek_model" name="merek_model" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomor_polisi" class="form-label">Nomor Polisi (Plat Nomor)</label>
                                        <input type="text" id="nomor_polisi" name="nomor_polisi" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tahun_pembuatan" class="form-label">Tahun Pembuatan</label>
                                        <input type="text" id="tahun_pembuatan" name="tahun_pembuatan" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jenis Layanan yang Dibutuhkan</label>
                                        <br>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="servis_rutin" name="layanan[]" value="Servis Rutin">
                                            <label class="form-check-label" for="servis_rutin">Servis Rutin</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="ganti_oli" name="layanan[]" value="Ganti Oli">
                                            <label class="form-check-label" for="ganti_oli">Ganti Oli</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="perbaikan_rem" name="layanan[]" value="Perbaikan Rem">
                                            <label class="form-check-label" for="perbaikan_rem">Perbaikan Rem</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="ganti_ban" name="layanan[]" value="Ganti Ban">
                                            <label class="form-check-label" for="ganti_ban">Ganti Ban</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="pemeriksaan_umum" name="layanan[]" value="Pemeriksaan Umum">
                                            <label class="form-check-label" for="pemeriksaan_umum">Pemeriksaan Umum</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="deskripsi_masalah" class="form-label">Deskripsi Masalah</label>
                                        <textarea id="deskripsi_masalah" name="deskripsi_masalah" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                                        <input type="date" id="tanggal_pemesanan" name="tanggal_pemesanan" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="waktu_pemesanan" class="form-label">Waktu Pemesanan</label>
                                        <input type="time" id="waktu_pemesanan" name="waktu_pemesanan" class="form-control" required min="08:00" max="21:00">
                                    </div>
                                    <div class="mb-3">
                                        <label for="lokasi_bengkel" class="form-label">Lokasi Anda</label>
                                        <input type="text" id="lokasi_bengkel" name="lokasi_bengkel" class="form-control" required>
                                    </div>
                                    <div class="d-grid">
                                        <input type="submit" value="Kirim Pemesanan" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <h3 class="mt-4">Daftar Pesanan Anda</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
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
                                            while ($row = $result->fetch_assoc()) {
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
                                                echo "<td>" . $row["lokasi_bengkel"] . "</td>";
                                                echo "<td>" . $row["status"] . "</td>";
                                                echo "<td><a href='../pesanan/proses_batal_pemesanan.php?id=" . $row["id"] . "' class='btn btn-danger btn-sm'>Batalkan</a></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='14' class='text-center no-orders'>Tidak ada pesanan.</td></tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center mt-3">
                                    <a href="../dashboard/page_pesanan/kalender_jadwal.php" class="btn btn-info">Lihat Kalender Jadwal Pembookingan</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function validateForm() {
            const form = document.forms[0];
            const inputs = form.querySelectorAll('input[required], textarea[required]');

            for (let input of inputs) {
                if (!input.value) {
                    alert('Harap isi semua field yang wajib.');
                    input.focus();
                    return false;
                }
            }
            return true;
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
