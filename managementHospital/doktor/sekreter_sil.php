<?php
include '../db_connection.php';

if (isset($_GET['id'])) {
    $sekreter_id = $_GET['id'];

    $sql = "DELETE FROM kullanicilar WHERE id = ? AND rol = 'sekreter'";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $sekreter_id);

        if ($stmt->execute()) {
            echo "<script>
                    alert('Sekreter başarıyla silindi!');
                    window.location.href = 'sekreter_yonetimi.php'; // Yönlendirme
                  </script>";
        } else {
            echo "<script>
                    alert('Sekreter silinirken bir hata oluştu.');
                    window.location.href = 'sekreter_yonetimi.php';
                  </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
                alert('SQL sorgusu hazırlanırken bir hata oluştu.');
                window.location.href = 'sekreter_yonetimi.php';
              </script>";
    }
} else {
    echo "<script>
            alert('Geçersiz istek.');
            window.location.href = 'sekreter_yonetimi.php';
          </script>";
}

$conn->close();
?>
