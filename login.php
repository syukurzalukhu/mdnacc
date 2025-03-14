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
                        primary: '#3B82F6',
                        secondary: '#FBBF24',
                        accent: '#EF4444'
                    }
                }
            }
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #3B82F6 40%, #FBBF24 60%, #EF4444 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Arial', sans-serif;
        }

        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
        }

        .toggle-password:hover {
            color: #000;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2 class="text-center text-primary font-bold text-2xl">Login</h2>
        <form method="POST" class="mt-4">
            <input type="text" name="username" placeholder="Username" class="form-control mb-3" required>
            <div class="position-relative">
                <input type="password" name="password" id="login-password" placeholder="Password" class="form-control mb-3" required>
                <span class="toggle-password" onclick="togglePassword('login-password')">👁</span>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3">Belum punya akun? <a href="#" onclick="toggleForm()" class="text-accent">Daftar</a></p>
    </div>

    <div class="form-container d-none" id="registerForm">
        <h2 class="text-center text-primary font-bold text-2xl">Register</h2>
        <form method="POST" class="mt-4">
            <input type="text" name="username" placeholder="Username" class="form-control mb-3" required>
            <div class="position-relative">
                <input type="password" name="password" id="register-password" placeholder="Password" class="form-control mb-3" required>
                <span class="toggle-password" onclick="togglePassword('register-password')">👁</span>
            </div>
            <button type="submit" name="register" class="btn btn-secondary w-100">Register</button>
        </form>
        <p class="text-center mt-3">Sudah punya akun? <a href="#" onclick="toggleForm()" class="text-accent">Login</a></p>
    </div>

    <script>
        function toggleForm() {
            document.querySelector('.form-container:not(.d-none)').classList.add('d-none');
            document.getElementById('registerForm').classList.toggle('d-none');
        }

        function togglePassword(inputId) {
            const passwordField = document.getElementById(inputId);
            passwordField.type = passwordField.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>