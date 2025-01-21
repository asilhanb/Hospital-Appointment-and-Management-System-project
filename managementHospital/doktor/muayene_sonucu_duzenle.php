<?php
include '../db_connection.php';
session_start();

if (isset($_POST['hasta_id']) && isset($_POST['muayene_sonucu'])) {
    $hasta_id = $_POST['hasta_id'];
    $muayene_sonucu = $_POST['muayene_sonucu'];

    $sql = "UPDATE hastalar SET muayene_sonucu = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("si", $muayene_sonucu, $hasta_id);

        if ($stmt->execute()) {
            header("Location: doktor_paneli.php?message=Muayene sonucu başarıyla güncellendi.");
            exit();
        } else {
            echo "Hata: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "Sorgu hazırlanırken bir hata oluştu.";
    }
} else {
    echo "Geçersiz işlem!";
}
ini_set('display_errors', 1);
error_reporting(E_ALL);

$conn->close();


?>
