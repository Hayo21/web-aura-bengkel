<?php
include 'koneksi.php';

// Fungsi untuk mengamankan input dari SQL Injection dan XSS
function secure_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = $conn->real_escape_string($data);
    return $data;
}

// Ambil data dari form
$username = secure_input($_POST['username']);
$email = secure_input($_POST['email']);
$password = password_hash(secure_input($_POST['password']), PASSWORD_DEFAULT); // Hash password

// Query untuk memeriksa apakah username atau email sudah ada di database
$sql_check_username = "SELECT COUNT(*) as username_count FROM users WHERE username = '$username'";
$result_check_username = $conn->query($sql_check_username);
$row_username = $result_check_username->fetch_assoc();
$username_count = $row_username['username_count'];

$sql_check_email = "SELECT COUNT(*) as email_count FROM users WHERE email = '$email'";
$result_check_email = $conn->query($sql_check_email);
$row_email = $result_check_email->fetch_assoc();
$email_count = $row_email['email_count'];

// Validasi apakah username atau email sudah ada di database
if ($username_count > 0) {
    // Jika username sudah ada, tampilkan notifikasi dan arahkan kembali ke halaman registrasi
    $error_message = "Username sudah digunakan.";
    echo "<script>alert('$error_message'); window.location.href='form_registrasi.php';</script>";
    exit;
}

if ($email_count > 0) {
    // Jika email sudah ada, tampilkan notifikasi dan arahkan kembali ke halaman registrasi
    $error_message = "Email sudah digunakan.";
    echo "<script>alert('$error_message'); window.location.href='form_registrasi.php';</script>";
    exit;
}

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
    // Jika registrasi berhasil, arahkan ke halaman login dengan pesan sukses
    header("Location: form_login.php?status=success");
    exit;
} else {
    // Jika registrasi gagal, arahkan kembali ke halaman registrasi dengan pesan error
    $error_message = $conn->error;
    header("Location: form_registrasi.php?status=error&message=" . urlencode($error_message));
    exit;
}

// Tutup koneksi
$conn->close();
?>
