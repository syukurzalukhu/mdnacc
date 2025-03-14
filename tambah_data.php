<?php
session_start();
$conn = new mysqli("localhost", "root", "", "mdnacc_db");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kategori = $_POST['kategori'];  // Kategori produk (sarung_hp, simdoor, battery, tempered_glass)
    $merek = $_POST['merek'];        // Merek HP yang dipilih
    $tipe_hp = $_POST['tipe_hp'];    // Tipe HP yang dimasukkan

    // Validasi kategori agar sesuai dengan tabel yang ada
    $allowed_categories = ['sarung_hp', 'simdoor', 'battery', 'tempered_glass'];
    if (!in_array($kategori, $allowed_categories)) {
        die("Kategori tidak valid!");
    }

    // Validasi merek agar sesuai dengan kolom dalam tabel
    $allowed_brands = ['Xiaomi', 'Samsung', 'Vivo', 'Realme', 'Oppo', 'Infinix', 'Techno', 'Itel', 'iPhone'];
    if (!in_array($merek, $allowed_brands)) {
        die("Merek tidak valid!");
    }

    // Query untuk memasukkan data ke kolom merek yang dipilih di tabel kategori
    $query = "INSERT INTO $kategori ($merek) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $tipe_hp);

    if ($stmt->execute()) {
        $message = "Data berhasil ditambahkan ke tabel $kategori!";
    } else {
        $message = "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg p-4">
                    <h2 class="text-center text-primary">Tambah Data Produk</h2>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-success" role="alert">
                            <?= $message; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori Produk:</label>
                            <select name="kategori" class="form-select" required>
                                <option value="sarung_hp">Sarung HP</option>
                                <option value="simdoor">Simdoor</option>
                                <option value="battery">Battery</option>
                                <option value="tempered_glass">Tempered Glass</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="merek" class="form-label">Merek HP:</label>
                            <select name="merek" class="form-select" required>
                                <option value="Xiaomi">Xiaomi</option>
                                <option value="Samsung">Samsung</option>
                                <option value="Vivo">Vivo</option>
                                <option value="Realme">Realme</option>
                                <option value="Oppo">Oppo</option>
                                <option value="Infinix">Infinix</option>
                                <option value="Techno">Techno</option>
                                <option value="Itel">Itel</option>
                                <option value="iPhone">iPhone</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tipe_hp" class="form-label">Tipe HP:</label>
                            <input type="text" name="tipe_hp" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Simpan</button>
                    </form>
                    <a href="dashboard.php" class="btn btn-secondary mt-3 w-100">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>