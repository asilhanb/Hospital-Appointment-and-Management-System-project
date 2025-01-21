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
    <title>Hasta Listesi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(45deg, #007bff, #6610f2);
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
        .card-header {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
        }
        .btn-primary, .btn-warning, .btn-danger {
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-warning:hover {
            background-color: #e0a800;
        }
        .btn-danger:hover {
            background-color: #bd2130;
        }
        .form-inline {
            display: flex;
            gap: 10px;
        }
        .table-striped tbody tr:hover {
            background-color: #f1f1f1;
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
    <div class="card border-primary">
        <div class="card-header">Hasta Listesi</div>
        <div class="card-body">
            <!-- Arama Çubuğu -->
            <form method="GET" action="" class="form-inline mb-3">
                <input type="text" name="search" class="form-control" placeholder="Hasta adı veya bölüm ara" 
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary">Ara</button>
            </form>

            <table class="table table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Ad Soyad</th>
                        <th>Doğum Tarihi</th>
                        <th>Şikayetler</th>
                        <th>Geçmiş Hastalıklar</th>
                        <th>Kullandığı İlaçlar</th>
                        <th>Bölüm</th>
                        <th>Randevu Tarihi</th>
                        <th>Randevu Saati</th>
                        <th>Muayene Sonucu</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Arama kriterlerini al
                    $search_query = "";
                    if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
                        $search_term = trim($_GET['search']);
                        $search_query = "WHERE ad_soyad LIKE '%$search_term%' OR kayit_bolumu LIKE '%$search_term%'";
                    }

                    // Hasta sorgusu
                    $sql = "SELECT * FROM hastalar $search_query";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['ad_soyad']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['dogum_tarihi']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['sikayetler']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['gecmis_hastaliklar']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['kullandigi_ilaclar']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['kayit_bolumu']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['randevu_tarihi']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['randevu_saati']) . "</td>";
                            echo "<td>
                                    <form action='muayene_sonucu_duzenle.php' method='POST'>
                                        <textarea class='form-control' name='muayene_sonucu' rows='2'>" . htmlspecialchars($row['muayene_sonucu']) . "</textarea>
                                        <input type='hidden' name='hasta_id' value='" . $row['id'] . "'>
                                        <button type='submit' class='btn btn-warning btn-sm mt-2'>Sonucu Düzenle</button>
                                    </form>
                                  </td>";
                            echo "<td>
                                    <a href='hasta_duzenle.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Düzenle</a>
                                    <a href='hasta_sil.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Silmek istediğinize emin misiniz?\")'>Sil</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10'>Arama kriterine uygun hasta bulunamadı.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
