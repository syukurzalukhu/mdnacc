<?php
$host = "localhost"; // Sesuaikan dengan host database Anda
$user = "root"; // Ganti dengan username database
$pass = ""; // Ganti dengan password database
$dbname = "mdnacc_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
