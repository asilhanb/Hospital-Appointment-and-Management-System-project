<?php
include '../db_connection.php';

if (isset($_GET['id'])) {
    $sekreter_id = intval($_GET['id']);
    $sql = "SELECT * FROM kullanicilar WHERE id = ? AND rol = 'sekreter'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $sekreter_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $sekreter = $result->fetch_assoc();
    } else {
        echo "Sekreter bulunamadı.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sekreter_id = intval($_POST['sekreter_id']);
    $sekreter_adi = trim($_POST['sekreter_adi']);
    $sekreter_email = trim($_POST['sekreter_email']);
    $kullanici_adi = trim($_POST['kullanici_adi']);
    $sekreter_sifre = trim($_POST['sekreter_sifre']);
    $sekreter_sifre2 = trim($_POST['sekreter_sifre2']);

    if (!empty($sekreter_sifre)) {
        if ($sekreter_sifre === $sekreter_sifre2) {
            $hashed_password = password_hash($sekreter_sifre, PASSWORD_BCRYPT);
            $sql = "UPDATE kullanicilar SET ad_soyad = ?, email = ?, sifre = ?, kullanici_adi=? WHERE id = ? AND rol = 'sekreter'";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $sekreter_adi, $sekreter_email, $hashed_password, $kullanici_adi, $sekreter_id);
        } else {
            echo "<script>alert('Şifreler eşleşmiyor!');</script>";
            exit;
        }
    } else {
        $sql = "UPDATE kullanicilar SET ad_soyad = ?, email = ? WHERE id = ? AND rol = 'sekreter'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $sekreter_adi, $sekreter_email, $sekreter_id);
    }

    if ($stmt->execute()) {
        header("Location: sekreter_yonetimi.php?message=Sekreter başarıyla güncellendi.");
        exit;
    } else {
        echo "Hata: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekreter Düzenle</title>
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
    </div>
    
</nav>

<div class="container mt-4">
    <div class="card border-primary">
        <div class="card-header">Sekreter Bilgilerini Düzenle</div>
        <div class="card-body">
            <form action="sekreter_duzenle.php?id=<?php echo $sekreter_id; ?>" method="POST">
                <input type="hidden" name="sekreter_id" value="<?php echo $sekreter['id']; ?>">
                <div class="mb-3">
                    <label for="sekreter_adi" class="form-label">Ad Soyad</label>
                    <input type="text" class="form-control" id="sekreter_adi" name="sekreter_adi" value="<?php echo htmlspecialchars($sekreter['ad_soyad']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="sekreter_email" class="form-label">E-posta</label>
                    <input type="email" class="form-control" id="sekreter_email" name="sekreter_email" value="<?php echo htmlspecialchars($sekreter['email']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="kullanici_adi" class="form-label">Kullanıcı Adı</label>
                    <input type="text" class="form-control" id="kullanici_adi" name="kullanici_adi" value="<?php echo htmlspecialchars($sekreter['kullanici_adi']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="sekreter_sifre" class="form-label">Yeni Şifre</label>
                    <input type="password" class="form-control" id="sekreter_sifre" name="sekreter_sifre">
                </div>
                <div class="mb-3">
                    <label for="sekreter_sifre2" class="form-label">Şifreyi Tekrar Girin</label>
                    <input type="password" class="form-control" id="sekreter_sifre2" name="sekreter_sifre2">
                </div>
                <button type="submit" class="btn btn-primary">Bilgileri Güncelle</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
