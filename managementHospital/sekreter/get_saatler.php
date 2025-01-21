<?php
include '../db_connection.php';

if (isset($_GET['tarih'])) {
    $tarih = $_GET['tarih'];
    
    $sql = "SELECT DISTINCT saat FROM doktor_zaman WHERE tarih = ? ORDER BY saat";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $tarih);
        $stmt->execute();
        $stmt->bind_result($saat);
        
        $saatler = [];
        while ($stmt->fetch()) {
            $saatler[] = $saat;
        }
        
        echo json_encode($saatler);
        
        $stmt->close();
    }
}
?>
