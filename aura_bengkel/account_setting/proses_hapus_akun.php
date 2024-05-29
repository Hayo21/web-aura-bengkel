<?php
session_start();
include '../login_register/koneksi.php';

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    $_SESSION['pesan'] = array('type' => 'success', 'message' => 'Akun berhasil dihapus.');
    header("Location: ../account_setting/user_account.php");
    exit;
} else {
    $_SESSION['pesan'] = array('type' => 'danger', 'message' => 'Gagal menghapus akun: ' . $conn->error);
    header("Location: ../account_setting/user_account.php");
    exit;
}

$conn->close();
?>
