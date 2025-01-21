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
    <title>Zaman Çizelgesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(45deg, #17a2b8, #6610f2);
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
            background-color: #17a2b8;
            color: #fff;
            font-weight: 600;
        }
        .btn-primary {
            background-color: #17a2b8;
            border: none;
        }
        .btn-primary:hover {
            background-color: #138496;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .accordion-button {
            font-weight: 600;
        }
        .list-group-item {
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
            Müsait Saatleri Belirle
        </div>
        <div class="card-body">
            <form action="zaman_cizelgesi_kaydet.php" method="POST">
                <div class="mb-3">
                    <label for="tarih" class="form-label">Gün Seçiniz</label>
                    <input type="date" id="tarih" name="tarih" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="saatler" class="form-label">Saatler</label>
                    <div class="d-flex flex-wrap">
                        <?php
                        for ($hour = 8; $hour <= 20; $hour++) {
                            $time1 = sprintf("%02d:00", $hour);
                            echo "
                                <div class='form-check me-3'>
                                    <input class='form-check-input' type='checkbox' name='saatler[]' value='$time1' id='saat_$time1'>
                                    <label class='form-check-label' for='saat_$time1'>$time1</label>
                                </div>";

                            $time2 = sprintf("%02d:30", $hour);
                            echo "
                                <div class='form-check me-3'>
                                    <input class='form-check-input' type='checkbox' name='saatler[]' value='$time2' id='saat_$time2'>
                                    <label class='form-check-label' for='saat_$time2'>$time2</label>
                                </div>";
                        }
                        ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>

            <hr class="my-4">

            <h6>Mevcut Zaman Çizelgesi</h6>
            <div class="accordion" id="zamanAccordion">
                <?php
                $sql = "SELECT tarih, GROUP_CONCAT(saat ORDER BY saat) AS saatler, id FROM doktor_zaman GROUP BY tarih ORDER BY tarih";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $counter = 0;
                    while ($row = $result->fetch_assoc()) {
                        $counter++;
                        $tarih = htmlspecialchars($row['tarih']);
                        $saatler = explode(",", htmlspecialchars($row['saatler']));
                        $id = htmlspecialchars($row['id']);

                        echo "
                        <div class='accordion-item'>
                            <h2 class='accordion-header' id='heading$counter'>
                                <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$counter' aria-expanded='false' aria-controls='collapse$counter'>
                                    $tarih
                                </button>
                            </h2>
                            <div id='collapse$counter' class='accordion-collapse collapse' aria-labelledby='heading$counter' data-bs-parent='#zamanAccordion'>
                                <div class='accordion-body'>
                                    <ul class='list-group'>";
                        foreach ($saatler as $saat) {
                            echo "<li class='list-group-item d-flex justify-content-between align-items-center'>
                                    $saat
                                    <a href='zaman_sil.php?id=$id&saat=" . urlencode($saat) . "' class='btn btn-sm btn-danger'>Sil</a>
                                  </li>";
                        }
                        echo "          </ul>
                                </div>
                            </div>
                        </div>";
                    }
                } else {
                    echo "<div class='alert alert-info'>Henüz bir zaman eklenmedi.</div>";
                }
                $conn->close();
                ?>
            </div>
            <form action="zaman_cizelgesi_sil.php" method="POST" class="mt-3">
                <button type="submit" class="btn btn-danger">Tüm Zamanları Sil</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
