<?php
session_start();  // Mulai sesi

// Cek apakah pengguna sudah login dan merupakan admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login_register/form_login.php");  // Redirect ke halaman login jika belum login atau bukan admin
    exit();
}

include '../login_register/koneksi.php';  // Sesuaikan jalur file koneksi

// Ambil ID pesanan dan status baru dari URL
$id_pesanan = $_GET['id'];
$status_baru = $_GET['status'];

//debug tes jika pesanan berhasil diterima
// echo "ID: $id_pesanan, Status: $status_baru";
// exit(); 


// Cek apakah status yang dimasukkan adalah status yang valid
if (!in_array($status_baru, ['diproses', 'dibatalkan', 'diterima'])) {
    header("Location: ../dashboard/admin_page.php?error=invalid_status");  // Redirect ke halaman admin_page.php dengan pesan kesalahan
    exit();
}

// Update status pesanan
$sql = "UPDATE pemesanan_layanan SET status='$status_baru' WHERE id='$id_pesanan'";

if ($conn->query($sql) === TRUE) {
    if ($status_baru == 'dibatalkan') {
        $_SESSION['pesan'] = "Pesanan berhasil dibatalkan.";
    } elseif ($status_baru == 'diterima') {
        $_SESSION['pesan'] = "Pesanan berhasil diterima.";
    } elseif ($status_baru == 'diproses') {
        $_SESSION['pesan'] = "Pesanan sedang diproses.";
    }
    header("Location: ../dashboard/admin_page.php?status=success");  // Redirect ke halaman admin_page.php dengan status berhasil
    exit();
} else {
    header("Location: ../dashboard/admin_page.php?error=update_failed");  // Redirect ke halaman admin_page.php dengan pesan kesalahan
    exit();
}

// Tutup koneksi
$conn->close();
?>
