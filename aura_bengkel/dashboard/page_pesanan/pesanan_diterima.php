<?php
session_start();  // Mulai sesi

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../../login_register/form_login.php");  // Redirect ke halaman login jika belum login atau bukan admin
    exit();
}

// Tambahkan logika halaman admin di sini
include '../../login_register/koneksi.php';  // Sesuaikan jalur file koneksi

$search = "";  // Inisialisasi variabel pencarian
if (isset($_GET['search'])) {
    $search = $_GET['search'];  // Tangkap nilai pencarian dari formulir
}

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : '';  // Tangkap nilai bulan dari formulir

// Ambil data pesanan yang diterima dari database
$sql = "SELECT * FROM pemesanan_layanan WHERE status='diterima'";

// Periksa apakah ada input pencarian
if (!empty($search)) {
    // Gunakan parameter pencarian dalam query SQL
    $sql .= " AND (nama_lengkap LIKE '%$search%' OR email LIKE '%$search%' OR nomor_telepon LIKE '%$search%')";
}

// Periksa apakah ada input filter bulan
if (!empty($bulan)) {
    // Gunakan parameter bulan dalam query SQL
    $sql .= " AND MONTH(tanggal_pemesanan) = '$bulan'";
}

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Diterima</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../admin_style.css"> <!-- Link ke file CSS -->
</head>
<body style="background-color: #2d3250;">
    <div class="container mt-5">
        <h2 class="text-center mb-4">Pesanan Diterima</h2>
        <a href="../admin_page.php" class="btn btn-primary mb-3">Kembali ke Halaman Admin</a>

        <!-- Form Pencarian -->
        <form method="GET" action="" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama, email, atau nomor telepon" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-secondary">Cari</button>
            </div>
        </form>
        <!-- End Form Pencarian -->

        <!-- Form Filter Bulan -->
        <form method="GET" action="pesanan_diterima.php" class="mb-3">
            <div class="input-group">
                <select name="bulan" class="form-select">
                    <option value="">Pilih Bulan</option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter Bulan</button>
                <a href="pesanan_diterima.php" class="btn btn-danger">Clear Filter</a>
            </div>
        </form>
        <!-- End Form Filter Bulan -->

        <div class="card shadow">
            <div class="card-body">
                <h3 class="card-title">Daftar Pesanan Diterima</h3>
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                // Loop untuk setiap baris data
                                while($row = $result->fetch_assoc()) {
                                    // Tampilkan data dalam baris tabel
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
                                    echo "</tr>";
                                }
                            } else {
                                // Tampilkan pesan jika tidak ada data ditemukan
                                echo "<tr><td colspan='13' class='text-center'>Tidak ada pesanan diterima</td></tr>";
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
