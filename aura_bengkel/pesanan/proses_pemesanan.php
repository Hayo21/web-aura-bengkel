<?php
session_start();  // Mulai sesi

include '../login_register/koneksi.php';  // Sesuaikan jalur file koneksi

// Ambil data dari form
$nama_lengkap = $_POST['nama_lengkap'];
$email = $_POST['email'];
$nomor_telepon = $_POST['nomor_telepon'];
$merek_model = $_POST['merek_model'];
$nomor_polisi = $_POST['nomor_polisi'];
$tahun_pembuatan = $_POST['tahun_pembuatan'];
$layanan = implode(", ", $_POST['layanan']);
$deskripsi_masalah = $_POST['deskripsi_masalah'];
$tanggal_pemesanan = $_POST['tanggal_pemesanan'];
$waktu_pemesanan = $_POST['waktu_pemesanan'];
$lokasi_bengkel = $_POST['lokasi_bengkel'];

// Ambil username dari sesi
$username = $_SESSION['username'];

// Cek apakah slot waktu sudah terisi
$sql_check_slot = "SELECT COUNT(*) as slot_count FROM pemesanan_layanan WHERE tanggal_pemesanan = '$tanggal_pemesanan' AND waktu_pemesanan = '$waktu_pemesanan' AND lokasi_bengkel = '$lokasi_bengkel'";
$result_check_slot = $conn->query($sql_check_slot);
$row = $result_check_slot->fetch_assoc();

if ($row['slot_count'] > 0) {
    // Slot waktu sudah terisi
    header("Location: ../dashboard/dashboard_page.php?error=slot_taken");
    exit();
} else {
    // Slot waktu tersedia, simpan data pemesanan ke database
    $sql = "INSERT INTO pemesanan_layanan (username, nama_lengkap, email, nomor_telepon, merek_model, nomor_polisi, tahun_pembuatan, layanan, deskripsi_masalah, tanggal_pemesanan, waktu_pemesanan, lokasi_bengkel, status) VALUES ('$username', '$nama_lengkap', '$email', '$nomor_telepon', '$merek_model', '$nomor_polisi', '$tahun_pembuatan', '$layanan', '$deskripsi_masalah', '$tanggal_pemesanan', '$waktu_pemesanan', '$lokasi_bengkel', 'diproses')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../dashboard/dashboard_page.php?status=success");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>
