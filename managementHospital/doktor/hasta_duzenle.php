<?php
include '../db_connection.php';
session_start();

if (isset($_GET['id'])) {
    $hasta_id = $_GET['id'];

    $sql = "SELECT * FROM hastalar WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $hasta_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $hasta = $result->fetch_assoc();
        } else {
            echo "Hasta bulunamadı.";
            exit();
        }
        $stmt->close();
    }
}

// Hasta bilgilerini güncelleme işlemi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ad_soyad = $_POST['ad_soyad'];
    $dogum_tarihi = $_POST['dogum_tarihi'];
    $sikayetler = $_POST['sikayetler'];
    $gecmis_hastaliklar = $_POST['gecmis_hastaliklar'];
    $kullandigi_ilaclar = $_POST['kullandigi_ilaclar'];
    $kayit_bolumu = $_POST['kayit_bolumu'];
    $randevu_tarihi = $_POST['randevu_tarihi'];
    $randevu_saati = $_POST['randevu_saati'];

    $sql = "UPDATE hastalar SET ad_soyad = ?, dogum_tarihi = ?, sikayetler = ?, gecmis_hastaliklar = ?, kullandigi_ilaclar = ?, kayit_bolumu = ?, randevu_tarihi=?, randevu_saati=? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssssi", $ad_soyad, $dogum_tarihi, $sikayetler, $gecmis_hastaliklar, $kullandigi_ilaclar, $kayit_bolumu, $randevu_tarihi, $randevu_saati, $hasta_id);
        if ($stmt->execute()) {
            header("Location: doktor_paneli.php?message=Hasta bilgileri başarıyla güncellendi.");
            exit();
        } else {
            echo "Hata: " . $conn->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasta Düzenle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(45deg, #007bff, #6610f2);
        }
        .navbar-brand {
            color: #fff !important;
            font-size: 1.4rem;
            font-weight: 600;
        }
        .navbar-text {
            color: #fff;
            font-size: 1rem;
            margin-right: 15px;
        }
        .card-header {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="doktor_paneli.php">
            <img src="../assets/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
            Doktor Paneli
        </a>
        <div class="d-flex align-items-center">
            <span class="navbar-text">
                Hoş geldiniz, <strong><?php echo htmlspecialchars($_SESSION['doktor_adi']); ?></strong>
            </span>
            <form action="../logout.php" method="POST">
                <button type="submit" class="btn btn-danger btn-sm">Çıkış Yap</button>
            </form>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="card border-primary">
        <div class="card-header">Hasta Bilgilerini Düzenle</div>
        <div class="card-body">
            <form action="hasta_duzenle.php?id=<?php echo $hasta_id; ?>" method="POST">
                <div class="mb-3">
                    <label for="ad_soyad" class="form-label">Ad Soyad</label>
                    <input type="text" class="form-control" id="ad_soyad" name="ad_soyad" value="<?php echo htmlspecialchars($hasta['ad_soyad']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="dogum_tarihi" class="form-label">Doğum Tarihi</label>
                    <input type="date" class="form-control" id="dogum_tarihi" name="dogum_tarihi" value="<?php echo htmlspecialchars($hasta['dogum_tarihi']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="sikayetler" class="form-label">Şikayetler</label>
                    <textarea class="form-control" id="sikayetler" name="sikayetler" rows="3" required><?php echo htmlspecialchars($hasta['sikayetler']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="gecmis_hastaliklar" class="form-label">Geçmiş Hastalıklar</label>
                    <textarea class="form-control" id="gecmis_hastaliklar" name="gecmis_hastaliklar" rows="3" required><?php echo htmlspecialchars($hasta['gecmis_hastaliklar']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="kullandigi_ilaclar" class="form-label">Kullandığı İlaçlar</label>
                    <textarea class="form-control" id="kullandigi_ilaclar" name="kullandigi_ilaclar" rows="3" required><?php echo htmlspecialchars($hasta['kullandigi_ilaclar']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="kayit_bolumu" class="form-label">Bölüm</label>
                    <input type="text" class="form-control" id="kayit_bolumu" name="kayit_bolumu" value="<?php echo htmlspecialchars($hasta['kayit_bolumu']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="randevu_tarihi" class="form-label">Randevu Tarihi</label>
                    <input type="date" class="form-control" id="randevu_tarihi" name="randevu_tarihi" value="<?php echo htmlspecialchars($hasta['randevu_tarihi']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="randevu_saati" class="form-label">Randevu Saati</label>
                    <input type="time" class="form-control" id="randevu_saati" name="randevu_saati" value="<?php echo htmlspecialchars($hasta['randevu_saati']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Bilgileri Güncelle</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
