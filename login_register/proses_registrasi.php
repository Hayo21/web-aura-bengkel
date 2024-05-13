<?php
include 'koneksi.php';

// Ambil data dari form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Query untuk memeriksa apakah sudah ada admin
$sql_check_admin = "SELECT COUNT(*) as admin_count FROM users WHERE role = 'admin'";
$result_check_admin = $conn->query($sql_check_admin);
$row = $result_check_admin->fetch_assoc();
$admin_count = $row['admin_count'];

// Jika belum ada admin, set peran sebagai admin, jika tidak, set sebagai user
if ($admin_count == 0) {
    $role = 'admin';
} else {
    $role = 'user';
}

// Query untuk menyimpan data registrasi ke database
$sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";

if ($conn->query($sql) === TRUE) {
    echo "Registrasi berhasil!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
?>
