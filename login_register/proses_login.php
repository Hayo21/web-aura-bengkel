<?php
include 'koneksi.php';

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Query untuk mencari user berdasarkan username dan password
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Login berhasil, cek peran pengguna
    $user = $result->fetch_assoc();
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
    echo "Login gagal. Periksa kembali username dan password.";
}

// Tutup koneksi
$conn->close();
?>
