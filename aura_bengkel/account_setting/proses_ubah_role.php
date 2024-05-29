<?php
session_start();
include '../login_register/koneksi.php';

$id = $_GET['id'];
$new_role = $_GET['role'];

$sql = "UPDATE users SET role = '$new_role' WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    $_SESSION['pesan'] = array('type' => 'success', 'message' => 'Peran pengguna berhasil diubah.');
    header("Location: ../account_setting/user_account.php");
    exit;
} else {
    $_SESSION['pesan'] = array('type' => 'danger', 'message' => 'Gagal mengubah peran pengguna: ' . $conn->error);
    header("Location: ../account_setting/user_account.php");
    exit;
}

$conn->close();
?>
