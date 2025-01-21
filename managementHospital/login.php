<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; 

    $query = "SELECT * FROM kullanicilar WHERE kullanici_adi = ? AND rol = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['sifre'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['rol'];

            if ($role == 'doktor') {
                header("Location: doktor/doktor_paneli.php");
            } elseif ($role == 'sekreter') {
                header("Location: sekreter/sekreter_paneli.php");
            }
        } else {
            // Şifre yanlış
            echo "<script>alert('Hatalı şifre!'); window.location.href = 'login.html';</script>";
        }
    } else {
        echo "<script>alert('Hatalı kullanıcı adı veya rol!'); window.location.href = 'login.html';</script>";
    }
}
?>
