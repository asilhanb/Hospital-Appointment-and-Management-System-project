<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../db_connection.php';
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekreter Yönetimi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(45deg, #0d6efd, #6610f2);
        }
        .navbar-brand {
            color: #fff !important;
            font-size: 1.5rem;
            font-weight: 600;
        }
        .navbar-nav .nav-link {
            color: #f8f9fa !important;
            margin-right: 15px;
        }
        .navbar-nav .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #6610f2;
            color: #fff;
            font-weight: 600;
        }
        .btn-primary {
            background-color: #0d6efd;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-warning {
            background-color: #ffc107;
            border: none;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(45deg, #007bff, #6610f2);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="../assets/logo.png" alt="Logo" width="30" height="30" class="me-2">
            Doktor Paneli
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="doktor_paneli.php">Hasta Listesi & Düzenle</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sekreter_yonetimi.php">Sekreter Yönetimi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="zaman_cizelgesi.php">Zaman Yönetimi</a>
                </li>
                <li class="nav-item">
                    <form action="../logout.php" method="POST" class="d-inline">
                        <button type="submit" class="btn btn-danger btn-sm nav-link">Çıkış Yap</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            Sekreter Yönetimi
        </div>
        <div class="card-body">
        <form action="sekreter_ekle.php" method="POST" class="row g-3">
    <div class="col-md-3">
        <input type="text" class="form-control" name="sekreter_adi" placeholder="Sekreter Adı" required>
    </div>
    <div class="col-md-3">
        <input type="text" class="form-control" name="sekreter_kullanici_adi" placeholder="Kullanıcı Adı" required>
    </div>
    <div class="col-md-3">
        <input type="email" class="form-control" name="sekreter_email" placeholder="E-posta" required>
    </div>
    <div class="col-md-3">
        <input type="password" class="form-control" name="sekreter_sifre" placeholder="Şifre" required>
    </div>
    <div class="col-md-12 text-end">
        <button type="submit" class="btn btn-primary">Sekreter Ekle</button>
    </div>
</form>

            <hr class="my-4">

            <h6>Kayıtlı Sekreterler</h6>
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Ad Soyad</th>
                    <th>Kullanıcı Adı</th>
                    <th>E-posta</th>
                    <th>İşlemler</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT * FROM kullanicilar WHERE rol='sekreter'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['ad_soyad']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['kullanici_adi']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td>
                                <a href='sekreter_duzenle.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Düzenle</a>
                                <a href='sekreter_sil.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Silmek istediğinize emin misiniz?\")'>Sil</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Kayıtlı sekreter yok.</td></tr>";
                }
                $conn->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
