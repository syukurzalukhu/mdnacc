<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - TOKO MDNACC</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#1A237E',
                        /* Biru Tua */
                        secondary: '#FFD700',
                        /* Emas */
                        accent: '#FF9800' /* Oranye */
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            height: 100vh;
            background-color: #f4f4f4;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #1A237E, #3949AB);
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px;
            transition: 0.3s ease-in-out;
            min-height: 100vh;
        }

        .sidebar h2 {
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
            color: #FFD700;
        }

        .sidebar a {
            color: white;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.3s;
        }

        .sidebar a:hover {
            background: #FFD700;
            color: #1A237E;
            font-weight: 600;
        }

        /* Konten */
        .content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
            background-color: #ecf0f1;
        }

        .header {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #1A237E;
        }

        .card-custom {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .btn-custom {
            background: #FF9800;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 8px;
            transition: 0.3s;
            font-weight: 600;
        }

        .btn-custom:hover {
            background: #F57C00;
        }
    </style>
</head>

<body>

    <!-- Sidebar Menu -->
    <div class="sidebar">
        <h2>TOKO MDNACC</h2>
        <a href="#" onclick="loadPage('home')"><i class="fa-solid fa-home"></i> Beranda</a>
        <a href="#" onclick="loadPage('persamaan_tempered.php')"><i class="fa-solid fa-table"></i> Persamaan Tempered Glass</a>
        <a href="#" onclick="loadPage('persamaan_sarung.php')"><i class="fa-solid fa-mobile"></i> Persamaan Sarung</a>
        <a href="#" onclick="loadPage('persamaan_simdoor.php')"><i class="fa-solid fa-door-open"></i> Persamaan Simdoor</a>
        <a href="#" onclick="loadPage('persamaan_battery.php')"><i class="fa-solid fa-battery-full"></i> Persamaan Battery</a>
        <a href="logout.php"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Konten Utama -->
    <div class="content">
        <div class="header">Dashboard TOKO MDNACC</div>
        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Cari produk..." onkeyup="searchData()">
        </div>
        <div id="content-area">
            <!-- Konten Beranda Default -->
            <div class="card-custom">
                <h3>Selamat Datang di Dashboard</h3>
                <p>Klik menu di sebelah kiri untuk melihat data produk.</p>
                <a href="tambah_data.php" class="btn btn-custom mt-3"><i class="fa-solid fa-plus"></i> Tambah Data Produk</a>
            </div>
        </div>
    </div>

    <script>
        function logout() {
            fetch('logout.php')
                .then(() => window.location.href = 'login.php')
                .catch(error => console.error('Logout gagal:', error));
        }

        function searchData() {
            let query = document.getElementById("searchInput").value;
            if (query.length > 2) { // Hanya mencari jika lebih dari 2 karakter
                fetch(`search.php?q=${query}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('content-area').innerHTML = data;
                    })
                    .catch(error => {
                        document.getElementById('content-area').innerHTML = "<p class='text-danger'>Gagal memuat hasil pencarian.</p>";
                    });
            }
        }

        function loadPage(page) {
            if (page === 'home') {
                document.getElementById('content-area').innerHTML = `
                    <div class="card-custom">
                        <h3>Selamat Datang di Dashboard</h3>
                        <p>Klik menu di sebelah kiri untuk melihat data produk.</p>
                        <a href="tambah_data.php" class="btn btn-custom mt-3"><i class="fa-solid fa-plus"></i> Tambah Data Produk</a>
                    </div>
                `;
            } else {
                fetch(page)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('content-area').innerHTML = `<div class="card-custom">${data}</div>`;
                    })
                    .catch(error => {
                        document.getElementById('content-area').innerHTML = "<p class='text-danger'>Error loading page.</p>";
                    });
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>