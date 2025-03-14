<?php
// Koneksi ke database
$host = "localhost";
$user = "root"; // Sesuaikan dengan user database Anda
$pass = ""; // Jika ada password, isi di sini
$dbname = "mdnacc_db"; // Ganti dengan nama database Anda

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil query pencarian
$q = isset($_GET['q']) ? $conn->real_escape_string($_GET['q']) : "";

// Array tabel yang akan dicari
$tabels = ["sarung_hp", "simdoor", "battery", "tempered_glass"];

$search_results = [];

foreach ($tabels as $table) {
    $sql = "SELECT * FROM $table WHERE 
        Xiaomi LIKE '%$q%' OR 
        Samsung LIKE '%$q%' OR 
        Vivo LIKE '%$q%' OR 
        Realme LIKE '%$q%' OR 
        Oppo LIKE '%$q%' OR 
        Infinix LIKE '%$q%' OR 
        Techno LIKE '%$q%' OR 
        Itel LIKE '%$q%' OR 
        iPhone LIKE '%$q%'";

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $row['table_name'] = $table; // Tambahkan nama tabel
            $search_results[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Data</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
        }

        .container {
            max-width: 95%;
            margin: 30px auto;
        }

        .table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table th {
            background-color: #1e3a8a;
            color: white;
            text-align: center;
            padding: 12px;
        }

        .table td {
            vertical-align: middle;
            text-align: center;
            padding: 10px;
        }

        .search-bar {
            width: 100%;
            max-width: 400px;
        }

        .btn-custom {
            font-size: 14px;
            padding: 6px 12px;
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            .table {
                font-size: 12px;
            }

            .search-bar {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h3 class="text-center text-blue-800 font-bold mb-4">Pencarian Data</h3>

        <!-- Search Bar -->
        <div class="mb-3 flex justify-end">
            <form method="GET" class="d-flex search-bar">
                <input type="text" name="q" class="form-control me-2" placeholder="Cari..." value="<?= htmlspecialchars($q); ?>">
                <button type="submit" class="btn btn-primary btn-custom">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        <!-- Hasil Pencarian -->
        <?php if (!empty($search_results)): ?>
            <h4 class="text-center">Hasil Pencarian untuk: "<?= htmlspecialchars($q) ?>"</h4>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Table</th>
                            <th>Xiaomi</th>
                            <th>Samsung</th>
                            <th>Vivo</th>
                            <th>Realme</th>
                            <th>Oppo</th>
                            <th>Infinix</th>
                            <th>Techno</th>
                            <th>Itel</th>
                            <th>iPhone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($search_results as $index => $row): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($row['table_name']) ?></td>
                                <td><?= htmlspecialchars($row['Xiaomi']) ?></td>
                                <td><?= htmlspecialchars($row['Samsung']) ?></td>
                                <td><?= htmlspecialchars($row['Vivo']) ?></td>
                                <td><?= htmlspecialchars($row['Realme']) ?></td>
                                <td><?= htmlspecialchars($row['Oppo']) ?></td>
                                <td><?= htmlspecialchars($row['Infinix']) ?></td>
                                <td><?= htmlspecialchars($row['Techno']) ?></td>
                                <td><?= htmlspecialchars($row['Itel']) ?></td>
                                <td><?= htmlspecialchars($row['iPhone']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($_SERVER["REQUEST_METHOD"] == "GET" && !empty($q)): ?>
            <p class="text-danger text-center">Tidak ada data ditemukan.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>