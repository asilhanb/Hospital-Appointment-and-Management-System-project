<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'db_connection.php';

// Composer autoload dosyasını dahil et
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? null;
    $role = $_POST['role'] ?? null;

    // E-posta ve rol kontrolü
    if (!$email || !$role) {
        die("Hata: E-posta veya rol eksik!");
    }

    // Kullanıcıyı kontrol et
    $query = "SELECT * FROM kullanicilar WHERE email = ? AND rol = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Hata: Sorgu hazırlanırken hata oluştu. " . $conn->error);
    }

    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Rastgele bir doğrulama kodu oluştur
        $reset_code = bin2hex(random_bytes(2)); // 16 byte = 32 karakter 4 karaterli bir kod

        // Doğrulama kodunu veritabanına kaydet
        $update_query = "UPDATE kullanicilar SET verification_code = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_query);

        if (!$update_stmt) {
            die("Hata: Verification kodu güncellenirken hata oluştu. " . $conn->error);
        }

        $update_stmt->bind_param("ss", $reset_code, $email);
        if (!$update_stmt->execute()) {
            die("Hata: Verification kodu veritabanına kaydedilemedi.");
        }

        // PHPMailer ile e-posta gönderme
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hosptlcyprus@gmail.com'; // E-posta adresiniz
            $mail->Password = 'bqfl kuuc boun epny'; // E-posta şifreniz
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            $mail->setFrom('hosptlcyprus@gmail.com', 'Hastane Sistemi');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Sifre Sifirlama Dogrulama Kodu';
            $mail->Body = "
                <html>
                <head>
                    <title>Sifre Sifirlama</title>
                </head>
                <body>
                    <p>Merhaba,</p>
                    <p>Sifre sifirlama isleminiz icin dogrulama kodunuz:</p>
                    <h3 style='color: #0073e6;'>$reset_code</h3>
                    <p>Bu kodu kullanarak şifrenizi sifirlayabilirsiniz.</p>
                    <p>Teşekkürler,</p>
                    <p>Eğer siz talep etmediyseniz lütfen bu mesaji görmezden geliniz.</p>
                    <p><strong>Hastane Sistemi</strong></p>
                </body>
                </html>
            ";

            $mail->send();

            // Mail başarıyla gönderildiyse yönlendirme
            header("Location: verify_code.php?email=$email");
            exit;

        } catch (Exception $e) {
            die("E-posta gönderilemedi. Hata: {$mail->ErrorInfo}");
        }
    } else {
        die("Hata: E-posta adresi veya rol hatalı!");
    }
} else {
    die("Hata: Form POST ile gönderilmedi!");
}
?>
