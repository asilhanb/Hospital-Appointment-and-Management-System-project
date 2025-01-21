<?php
include '../db_connection.php';

if (isset($_GET['id'])) {
    $hasta_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM hastalar WHERE id = ?");
    $stmt->bind_param("i", $hasta_id);

    if ($stmt->execute()) {
        echo "<script>alert('Hasta başarıyla silindi!'); window.location.href = 'doktor_paneli.php';</script>";
    } else {
        echo "<script>alert('Silme sırasında bir hata oluştu: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Hasta ID belirtilmedi.'); window.location.href = 'doktor_paneli.php';</script>";
}

$conn->close();
?>
