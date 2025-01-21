<?php
include '../db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tarih = $_POST['tarih'];
    $saatler = $_POST['saatler']; // Checkboxlardan gelen saatler

    if (!empty($tarih) && !empty($saatler)) {
        foreach ($saatler as $saat) {
            // Aynı tarih ve saatte tekrarı önlemek için kontrol 
            $sql = "INSERT INTO doktor_zaman (tarih, saat) VALUES (?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ss", $tarih, $saat);
                if (!$stmt->execute()) {
                    echo "Hata: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Hata: " . $conn->error;
            }
        }
        echo "<script>
                alert('Zaman çizelgesi başarıyla kaydedildi!');
                window.location.href = 'zaman_cizelgesi.php';
              </script>";
    } else {
        echo "<script>
                alert('Lütfen bir gün ve saat seçin.');
                window.location.href = 'zaman_cizelgesi.php';
              </script>";
    }
}

$conn->close();
?>
