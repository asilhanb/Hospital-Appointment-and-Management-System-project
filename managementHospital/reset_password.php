<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $verification_code = trim($_POST['verification_code']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Şifreler eşleşmiyor! Lütfen tekrar deneyin.'); window.location.href = 'verify_code.php?email=" . urlencode($email) . "';</script>";
        exit;
    }

    $query = "SELECT * FROM kullanicilar WHERE email = ? AND verification_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $verification_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_query = "UPDATE kullanicilar SET sifre = ?, verification_code = NULL WHERE email = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ss", $hashed_password, $email);

        if ($stmt->execute()) {
            echo "<script>alert('Şifreniz başarıyla güncellendi. Şimdi giriş yapabilirsiniz.'); window.location.href = 'login.html';</script>";
            exit;
        } else {
            echo "<script>alert('Şifre güncellenirken bir hata oluştu. Lütfen tekrar deneyin.'); window.location.href = 'verify_code.php?email=" . urlencode($email) . "';</script>";
        }
    } else {
        echo "<script>alert('Doğrulama kodu hatalı veya süresi dolmuş!'); window.location.href = 'verify_code.php?email=" . urlencode($email) . "';</script>";
    }
} else {
    // Direkt erişimi engelle
    echo "<script>alert('Geçersiz istek!'); window.location.href = 'login.html';</script>";
}
?>
