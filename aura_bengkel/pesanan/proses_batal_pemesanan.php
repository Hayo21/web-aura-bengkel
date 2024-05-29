<?php
session_start();  // Mulai sesi

include '../login_register/koneksi.php';  // Sesuaikan jalur file koneksi

// Ambil ID pesanan dari parameter URL
if (isset($_GET['id'])) {
    $id_pesanan = $_GET['id'];

    // Query untuk mengubah status pesanan menjadi "dibatalkan"
    $sql = "UPDATE pemesanan_layanan SET status='dibatalkan' WHERE id='$id_pesanan'";

    if ($conn->query($sql) === TRUE) {
        // Pembatalan berhasil
        header("Location: ../dashboard/dashboard_page.php?status=canceled");
    } else {
        // Jika terjadi kesalahan, tampilkan pesan kesalahan
        echo "Error updating record: " . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
} else {
    // Jika ID pesanan tidak diberikan, kembali ke dashboard
    header("Location: ../dashboard/dashboard_page.php");
}
?>
