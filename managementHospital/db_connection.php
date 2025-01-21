<?php
$servername = "localhost";
$username = "hastaneyonetimpaneli"; // Kullanıcı
$password = "123456789";     // şşifre
$dbname = "randevusystem"; // veritabanı adı

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error); //hatayı göstert
}
?>
