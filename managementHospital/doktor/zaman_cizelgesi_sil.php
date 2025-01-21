<?php
include '../db_connection.php';

$sql = "DELETE FROM doktor_zaman";
if ($conn->query($sql) === TRUE) {
    echo "Tüm zamanlar başarıyla silindi!";
} else {
    echo "Silme işlemi başarısız oldu: " . $conn->error;
}

$conn->close();

header("Location: zaman_cizelgesi.php");
exit();
?>
