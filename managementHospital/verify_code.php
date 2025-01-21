<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doğrulama Kodu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .verification-container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            color: #333;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .form-control:focus {
            box-shadow: 0 0 10px rgba(102, 126, 234, 0.5);
            border-color: #667eea;
        }
        small#passwordMatchMessage {
            font-size: 0.9rem;
            margin-top: 5px;
            display: block;
        }
    </style>
    <script>
        function checkPasswords() {
            const newPassword = document.getElementById("new_password").value;
            const confirmPassword = document.getElementById("confirm_password").value;
            const message = document.getElementById("passwordMatchMessage");

            if (newPassword !== confirmPassword) {
                message.textContent = "Şifreler eşleşmiyor!";
                message.style.color = "red";
                return false;
            } else {
                message.textContent = "Şifreler eşleşiyor.";
                message.style.color = "green";
                return true;
            }
        }
    </script>
</head>
<body>
    <div class="verification-container">
        <h3 class="text-center mb-4">Doğrulama Kodunu Girin</h3>
        <form action="reset_password.php" method="POST" onsubmit="return checkPasswords();">
            <div class="mb-3">
                <label for="email" class="form-label">E-posta Adresi</label>
                <input type="email" class="form-control" id="email" name="email" 
                       value="<?php echo htmlspecialchars($_GET['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" readonly required>
            </div>
            <div class="mb-3">
                <label for="verification_code" class="form-label">Doğrulama Kodu</label>
                <input type="text" class="form-control" id="verification_code" name="verification_code" required>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Yeni Şifre</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Yeni Şifre (Tekrar)</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required oninput="checkPasswords();">
                <small id="passwordMatchMessage"></small>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Şifre Sıfırla</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
