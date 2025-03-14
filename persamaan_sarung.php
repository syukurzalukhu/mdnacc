<?php
session_start();
$conn = new mysqli("localhost", "root", "", "mdnacc_db");

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$query = "SELECT * FROM sarung_hp";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Persamaan Sarung - TOKO MDNACC</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- FontAwesome -->
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

        @media (max-width: 768px) {
            .table {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h3 class="text-center text-blue-800 font-bold mb-4">Persamaan Sarung HP</h3>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Xiaomi</th>
                        <th>Samsung</th>
                        <th>Vivo</th>
                        <th>Realme</th>
                        <th>Oppo</th>
                        <th>Infinix</th>
                        <th>Techno</th>
                        <th>Itel</th>
                        <th>iPhone</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row['Xiaomi']; ?></td>
                            <td><?= $row['Samsung']; ?></td>
                            <td><?= $row['Vivo']; ?></td>
                            <td><?= $row['Realme']; ?></td>
                            <td><?= $row['Oppo']; ?></td>
                            <td><?= $row['Infinix']; ?></td>
                            <td><?= $row['Techno']; ?></td>
                            <td><?= $row['Itel']; ?></td>
                            <td><?= $row['iPhone']; ?></td>
                            <td>
                                <a href="edit.php?id=<?= $row['No']; ?>&table=sarung_hp" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="delete.php?id=<?= $row['No']; ?>&table=sarung_hp" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>