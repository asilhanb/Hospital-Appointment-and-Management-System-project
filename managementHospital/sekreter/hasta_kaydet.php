<?php
include '../db_connection.php';

if ($conn->connect_error) {
    die("Veritabanına bağlanılamadı: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ad_soyad = $_POST['ad_soyad'];
    $dogum_tarihi = $_POST['dogum_tarihi'];
    $gecmis_hastaliklar = $_POST['gecmis_hastaliklar'];
    $kullandigi_ilaclar = $_POST['kullandigi_ilaclar'];
    $sikayetler = $_POST['sikayetler'];
    $muayene_sonucu = $_POST['muayene_sonucu'];
    $kayit_bolumu = $_POST['kayit_bolumu'];
    $randevu_tarihi = $_POST['randevu_tarihi'];
    $randevu_saati = $_POST['randevu_saati'];

    $stmt = $conn->prepare("INSERT INTO hastalar (ad_soyad, dogum_tarihi, gecmis_hastaliklar, kullandigi_ilaclar, sikayetler, muayene_sonucu, kayit_bolumu, randevu_tarihi, randevu_saati)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $ad_soyad, $dogum_tarihi, $gecmis_hastaliklar, $kullandigi_ilaclar, $sikayetler, $muayene_sonucu, $kayit_bolumu, $randevu_tarihi, $randevu_saati);

    if ($stmt->execute()) {
        echo "Hasta başarıyla eklendi! Lütfen bekleyiniz<br>";
        header("Refresh: 3; url=sekreter_paneli.php");
    } else {
        // Hata durumunda kullanıcıya bilgi ver
        echo "Hata: " . $stmt->error;
    }

    // Bağlantıyı kapatalım
    $stmt->close();
}

// Bağlantıyı kapatalım
$conn->close();
?>
