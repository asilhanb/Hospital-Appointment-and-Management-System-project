<?php
include '../db_connection.php';

if (isset($_GET['id'])) {
    $zaman_id = intval($_GET['id']); 

    $sql = "DELETE FROM doktor_zaman WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $zaman_id);
        if ($stmt->execute()) {
            echo "<script>
                    alert('Zaman başarıyla silindi!');
                    window.location.href = 'zaman_cizelgesi.php';
                  </script>";
        } else {
            echo "Hata: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Hata: " . $conn->error;
    }
}

$conn->close();
?>
