<?php
session_start();
include 'db.php';

// Proses Login
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['username'] = $row['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}

// Proses Registrasi
if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_BCRYPT);

    $checkUser = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $checkUser);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username sudah terdaftar!');</script>";
    } else {
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registrasi berhasil, silakan login!'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1A237E',
                        secondary: '#FFD700',
                        accent: '#FF9800'
                    }
                }
            }
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-md p-6 rounded-lg w-96">
        <h2 class="text-center text-primary font-bold text-2xl">Login</h2>
        <form method="POST" class="mt-4">
            <input type="text" name="username" placeholder="Username" class="form-control mb-3" required>
            <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
            <button type="submit" name="login" class="btn btn-primary w-full">Login</button>
        </form>
        <p class="text-center mt-3">Belum punya akun? <a href="#" onclick="toggleForm()" class="text-accent">Daftar</a></p>
    </div>

    <div class="bg-white shadow-md p-6 rounded-lg w-96 hidden" id="registerForm">
        <h2 class="text-center text-primary font-bold text-2xl">Register</h2>
        <form method="POST" class="mt-4">
            <input type="text" name="username" placeholder="Username" class="form-control mb-3" required>
            <input type="password" name="password" placeholder="Password" class="form-control mb-3" required>
            <button type="submit" name="register" class="btn btn-secondary w-full">Register</button>
        </form>
        <p class="text-center mt-3">Sudah punya akun? <a href="#" onclick="toggleForm()" class="text-accent">Login</a></p>
    </div>

    <script>
        function toggleForm() {
            document.querySelector('div:not(.hidden)').classList.add('hidden');
            document.getElementById('registerForm').classList.toggle('hidden');
        }
    </script>
</body>

</html>