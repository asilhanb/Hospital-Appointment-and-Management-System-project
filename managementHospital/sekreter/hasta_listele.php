<?php
include '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = intval($_POST['delete_id']);
    $deleteSql = "DELETE FROM hastalar WHERE id = $deleteId";
    if ($conn->query($deleteSql) === TRUE) {
        echo "<div class='alert alert-success text-center'>Hasta başarıyla silindi.</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Hata: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hastaları Listele</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .table {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-danger {
            transition: background-color 0.3s ease;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
        .table th {
            background-color: #007bff;
            color: #fff;
        }
        .footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../assets/logo.png" alt="Logo" width="40" height="40">
            Sekreter Paneli
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="sekreter_paneli.php">Hasta Ekle</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="hasta_listele.php">Hastaları Görüntüle</a>
            </li>
        </ul>
        <div class="ml-auto text-white">
            <?php
                include 'db_connection.php';
                $sql = "SELECT ad_soyad FROM kullanicilar WHERE rol = 'sekreter'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "Hoş geldiniz, <strong>" . htmlspecialchars($row['ad_soyad']) . "</strong>";
                } else {
                    echo "Hoş geldiniz, <strong>Misafir</strong>";
                }
            ?>
            <form action="../logout.php" method="POST" style="display: inline;">
                <button type="submit" class="btn btn-outline-light btn-sm ml-3">Çıkış Yap</button>
            </form>
        </div>
    </div>
</nav>


    <div class="container">
        <h2>Hasta Listesi</h2>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Ad Soyad</th>
                    <th>Doğum Tarihi</th>
                    <th>Geçmiş Hastalıklar</th>
                    <th>Kullandığı İlaçlar</th>
                    <th>Şikayetler</th>
                    <th>Muayene Sonucu</th>
                    <th>Kayıt Bölümü</th>
                    <th>Randevu Tarihi</th>
                    <th>Randevu Saati</th>
                    <th>Sil</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM hastalar";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['ad_soyad']) . "</td>
                                <td>" . htmlspecialchars($row['dogum_tarihi']) . "</td>
                                <td>" . htmlspecialchars($row['gecmis_hastaliklar']) . "</td>
                                <td>" . htmlspecialchars($row['kullandigi_ilaclar']) . "</td>
                                <td>" . htmlspecialchars($row['sikayetler']) . "</td>
                                <td>" . htmlspecialchars($row['muayene_sonucu']) . "</td>
                                <td>" . htmlspecialchars($row['kayit_bolumu']) . "</td>
                                <td>" . htmlspecialchars($row['randevu_tarihi']) . "</td>
                                <td>" . htmlspecialchars($row['randevu_saati']) . "</td>
                                <td>
                                    <form method='POST' action='' onsubmit='return confirm(\"Bu hastayı silmek istediğinize emin misiniz?\");'>
                                        <input type='hidden' name='delete_id' value='" . intval($row['id']) . "'>
                                        <button type='submit' class='btn btn-danger btn-sm'>Sil</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='11' class='text-center'>Hiçbir hasta bulunamadı.</td></tr>";
                }
                ?>
            </tbody>
        </table>
 
    </div>
<div class="footer">
    <p>© 2024 Sekreter Paneli | Tüm Hakları Saklıdır</p>
</div>
</body>
</html>
