<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sekreter_adi = trim($_POST['sekreter_adi']);
    $sekreter_kullanici_adi = trim($_POST['sekreter_kullanici_adi']);
    $sekreter_email = trim($_POST['sekreter_email']);
    $sekreter_sifre = trim($_POST['sekreter_sifre']);

    if (!empty($sekreter_adi) && !empty($sekreter_kullanici_adi) && !empty($sekreter_email) && !empty($sekreter_sifre)) {
        $hashed_password = password_hash($sekreter_sifre, PASSWORD_BCRYPT);

        $sql = "INSERT INTO kullanicilar (ad_soyad, kullanici_adi, sifre, rol, email) 
                VALUES (?, ?, ?, 'sekreter', ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $sekreter_adi, $sekreter_kullanici_adi, $hashed_password, $sekreter_email);

            if ($stmt->execute()) {
                echo "Sekreter başarıyla eklendi!<br>";
                echo "Yönlendiriliyorsunuz...";
                header("Refresh: 3; url=sekreter_yonetimi.php");
                exit;
            } else {
                echo "Hata: " . $stmt->error . "<br>";
            }

            $stmt->close();
        } else {
            echo "Hata: SQL sorgusu hazırlanamadı. (" . $conn->error . ")<br>";
        }
    } else {
        echo "Lütfen tüm alanları doldurunuz.<br>";
    }
}

$conn->close();

?>
