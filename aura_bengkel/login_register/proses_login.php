<?php
session_start();  // Mulai sesi

// Aktifkan pelaporan kesalahan
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';  // Sesuaikan jalur file koneksi

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Query untuk mencari user berdasarkan username
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User ditemukan, cek password
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        // Login berhasil, simpan informasi ke sesi
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            // Redirect ke halaman admin jika peran adalah admin
            header("Location: ../dashboard/admin_page.php");
            exit();
        } else {
            // Redirect ke halaman dashboard jika peran adalah pengguna biasa
            header("Location: ../dashboard/dashboard_page.php");
            exit();
        }
    } else {
        // Password salah, tampilkan pesan di halaman login
        header("Location: ../login_register/form_login.php?error=password");
        exit();
    }
} else {
    // User tidak ditemukan, tampilkan pesan di halaman login
    header("Location: ../login_register/form_login.php?error=user_not_found");
    exit();
}

// Tutup koneksi
$conn->close();
?>
