<?php
session_start();
$conn = new mysqli("localhost", "root", "", "mdnacc_db");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Validasi ID dan table
if (!isset($_GET['id']) || !isset($_GET['table'])) {
    die("Parameter tidak lengkap.");
}

$id = intval($_GET['id']); // Hindari SQL Injection
$table = $_GET['table'];

// Pastikan tabel yang dihapus benar-benar ada dalam daftar
$allowed_tables = ['tempered_glass', 'battery', 'sarung_hp', 'simdoor'];
if (!in_array($table, $allowed_tables)) {
    die("Tabel tidak valid.");
}

// Buat query DELETE
$query = "DELETE FROM $table WHERE No=$id";
$result = $conn->query($query);

if ($result) {
    // Redirect kembali ke halaman sebelumnya
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}
