<?php
session_start();  // Mulai sesi

// Aktifkan pelaporan kesalahan
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../login_register/koneksi.php';  // Sesuaikan jalur file koneksi

// Ambil data dari form
$username = $_POST['username'];
$new_password = $_POST['new_password'];

// Query untuk mencari user berdasarkan username
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User ditemukan, update password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update_sql = "UPDATE users SET password='$hashed_password' WHERE username='$username'";
    
    if ($conn->query($update_sql) === TRUE) {
        // Password berhasil diupdate, redirect ke halaman login dengan pesan sukses
        header("Location: ../lupa_password/form_lupa_password.php?status=reset_success");
        exit();
    } else {
        // Kesalahan dalam mengupdate password
        echo "Error: " . $update_sql . "<br>" . $conn->error;
    }
} else {
    // User tidak ditemukan, tampilkan pesan di halaman lupa password
    header("Location: ../lupa_password/form_lupa_password.php?error=user_not_found");
    exit();
}

// Tutup koneksi
$conn->close();
?>
