<?php
session_start();
$conn = new mysqli("localhost", "root", "", "mdnacc_db");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Validasi parameter id dan tabel
if (!isset($_GET['id']) || !isset($_GET['table'])) {
    die("Parameter tidak lengkap!");
}

$id = (int) $_GET['id']; // Konversi ID ke integer
$table = $_GET['table']; // Nama tabel

// Pastikan tabel yang dipilih valid untuk mencegah SQL Injection
$allowed_tables = ['battery', 'sarung_hp', 'simdoor', 'tempered_glass'];
if (!in_array($table, $allowed_tables)) {
    die("Tabel tidak valid!");
}

// Ambil data berdasarkan ID dari tabel yang dipilih
$query = "SELECT * FROM $table WHERE No = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan atau telah dihapus.");
}

$success_message = ""; // Variabel untuk pesan sukses

// Proses update jika ada submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Xiaomi = $_POST['Xiaomi'];
    $Samsung = $_POST['Samsung'];
    $Vivo = $_POST['Vivo'];
    $Realme = $_POST['Realme'];
    $Oppo = $_POST['Oppo'];
    $Infinix = $_POST['Infinix'];
    $Techno = $_POST['Techno'];
    $Itel = $_POST['Itel'];
    $iPhone = $_POST['iPhone'];

    $update_query = "UPDATE $table SET Xiaomi = ?, Samsung = ?, Vivo = ?, Realme = ?, Oppo = ?, Infinix = ?, Techno = ?, Itel = ?, iPhone = ? WHERE No = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssssi", $Xiaomi, $Samsung, $Vivo, $Realme, $Oppo, $Infinix, $Techno, $Itel, $iPhone, $id);

    if ($stmt->execute()) {
        $success_message = "Data berhasil diperbarui!";
        // Ambil ulang data yang telah diperbarui untuk menampilkan perubahan
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data <?= htmlspecialchars($table); ?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Edit Data <?= htmlspecialchars($table); ?></h2>

        <?php if ($success_message) : ?>
            <div class="alert alert-success"><?= $success_message; ?></div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>Xiaomi</label>
                <input type="text" name="Xiaomi" class="form-control" value="<?= htmlspecialchars($data['Xiaomi']); ?>" required>
            </div>
            <div class="form-group">
                <label>Samsung</label>
                <input type="text" name="Samsung" class="form-control" value="<?= htmlspecialchars($data['Samsung']); ?>" required>
            </div>
            <div class="form-group">
                <label>Vivo</label>
                <input type="text" name="Vivo" class="form-control" value="<?= htmlspecialchars($data['Vivo']); ?>" required>
            </div>
            <div class="form-group">
                <label>Realme</label>
                <input type="text" name="Realme" class="form-control" value="<?= htmlspecialchars($data['Realme']); ?>" required>
            </div>
            <div class="form-group">
                <label>Oppo</label>
                <input type="text" name="Oppo" class="form-control" value="<?= htmlspecialchars($data['Oppo']); ?>" required>
            </div>
            <div class="form-group">
                <label>Infinix</label>
                <input type="text" name="Infinix" class="form-control" value="<?= htmlspecialchars($data['Infinix']); ?>" required>
            </div>
            <div class="form-group">
                <label>Techno</label>
                <input type="text" name="Techno" class="form-control" value="<?= htmlspecialchars($data['Techno']); ?>" required>
            </div>
            <div class="form-group">
                <label>Itel</label>
                <input type="text" name="Itel" class="form-control" value="<?= htmlspecialchars($data['Itel']); ?>" required>
            </div>
            <div class="form-group">
                <label>iPhone</label>
                <input type="text" name="iPhone" class="form-control" value="<?= htmlspecialchars($data['iPhone']); ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </form>
    </div>
</body>

</html>