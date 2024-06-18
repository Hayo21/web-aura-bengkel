<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../lupa_password/form_style_lupa.css">
</head>
<body style="background-color: #2d3250;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Lupa Password</h2>
                        <?php
                        if (isset($_GET['status']) && $_GET['status'] == 'reset_success') {
                            echo '<p class="text-success">Password berhasil direset. Silakan login dengan password baru Anda.</p>';
                        }
                        if (isset($_GET['error'])) {
                            $error = $_GET['error'];
                            if ($error == 'user_not_found') {
                                echo '<p style="color: red;">Pengguna tidak ditemukan. Silakan coba lagi.</p>';
                            }
                        }
                        ?>
                        <form action="../lupa_password/proses_lupa_password.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" id="new_password" name="new_password" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <input type="submit" value="Reset Password" class="btn btn-primary">
                            </div>
                            <div class="d-grid mt-3">
                                <a href="../login_register/form_login.php" class="btn btn-secondary">Back to Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
