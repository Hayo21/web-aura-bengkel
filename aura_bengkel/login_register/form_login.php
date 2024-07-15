<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/form_style.css"> <!-- Link ke file CSS -->
</head>
<body style="background-color: #2d3250;">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Login</h2>
                        <?php
                        if (isset($_GET['status']) && $_GET['status'] == 'success') {
                            echo '<p class="text-success">Registrasi berhasil! Silakan login.</p>';
                        }
                        if (isset($_GET['error'])) {
                            $error = $_GET['error'];
                            if ($error == 'password') {
                                echo '<p style="color: red;">Password salah. Silakan coba lagi.</p>';
                            }
                        }
                        ?>
                        <form action="proses_login.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <input type="submit" value="Login" class="btn btn-primary">
                            </div>
                            <div class="text-center mt-3">
                                <a href="form_registrasi.php" class="btn btn-secondary">Register</a>
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
