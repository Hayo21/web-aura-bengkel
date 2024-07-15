<?php
// Konfigurasi database
$host = 'localhost';  // Sesuaikan dengan host database Anda
$username = 'root';  // Ganti dengan username database Anda
$password = '';  // Ganti dengan password database Anda
$database = 'aura_bengkel';  // Ganti dengan nama database Anda

// Koneksi ke database
$conn = new mysqli($host, $username, $password, $database);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
