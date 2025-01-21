<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sekreter Paneli</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }
        .navbar {
            background-color: #007bff;
            padding: 15px;
        }
        .navbar .navbar-brand {
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .navbar .navbar-brand img {
            margin-right: 10px;
        }
        .navbar .ml-auto {
            color: white;
            font-size: 1rem;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
            border-radius: 10px 10px 0 0;
        }
        .form-label {
            font-weight: 600;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            color: white;
        }
        .progress-bar {
            background-color: #28a745;
        }
        .footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
        .container {
            max-width: 900px;
            margin: auto;
        }
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<body>

   <!-- Navbar -->
   <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../assets/logo.png" alt="Logo" width="40" height="40">
            Sekreter Paneli
        </a>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="sekreter_paneli.php">Hasta Ekle</a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="hasta_listele.php">Hastaları Görüntüle</a>
            </li>
        </ul>
        <div class="ml-auto text-white">
            <?php
                include '../db_connection.php';
                $sql = "SELECT ad_soyad FROM kullanicilar WHERE rol = 'sekreter'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    echo "Hoş geldiniz, <strong>" . htmlspecialchars($row['ad_soyad']) . "</strong>";
                } else {
                    echo "Hoş geldiniz, <strong>Misafir</strong>";
                }
            ?>
            <form action="../logout.php" method="POST" style="display: inline;">
                <button type="submit" class="btn btn-outline-light btn-sm ml-3">Çıkış Yap</button>
            </form>
        </div>
    </div>
</nav>



<!-- Main Container -->
<div class="container">
    <!-- Hasta Kayıt Formu -->
    <div class="card">
        <div class="card-header">Hasta Kayıt Formu</div>
        <div class="card-body">
            <form action="hasta_kaydet.php" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="ad_soyad" class="form-label">Hasta Adı ve Soyadı</label>
                        <input type="text" class="form-control" id="ad_soyad" name="ad_soyad" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="dogum_tarihi" class="form-label">Doğum Tarihi</label>
                        <input type="date" class="form-control" id="dogum_tarihi" name="dogum_tarihi" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gecmis_hastaliklar" class="form-label">Geçmiş Hastalıklar</label>
                    <textarea class="form-control" id="gecmis_hastaliklar" name="gecmis_hastaliklar"></textarea>
                </div>
                <div class="form-group">
                    <label for="kullandigi_ilaclar" class="form-label">Kullandığı İlaçlar</label>
                    <textarea class="form-control" id="kullandigi_ilaclar" name="kullandigi_ilaclar"></textarea>
                </div>
                <div class="form-group">
                    <label for="sikayetler" class="form-label">Şikayetler</label>
                    <textarea class="form-control" id="sikayetler" name="sikayetler"></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="kayit_bolumu" class="form-label">Kayıt Bölümü</label>
                        <input type="text" class="form-control" id="kayit_bolumu" name="kayit_bolumu" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="randevu_tarihi" class="form-label">Randevu Tarihi</label>
                        <select class="form-control" id="randevu_tarihi" name="randevu_tarihi" required>
                            <option value="">Tarih Seçin</option>
                            <?php
                                $sql = "SELECT DISTINCT tarih FROM doktor_zaman";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . htmlspecialchars($row['tarih']) . "'>" . htmlspecialchars($row['tarih']) . "</option>";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="randevu_saati" class="form-label">Randevu Saati</label>
                    <select class="form-control" id="randevu_saati" name="randevu_saati" required>
                        <option value="">Saat Seçin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom btn-block">Kaydet</button>
            </form>
        </div>
    </div>

    <!-- Doktor Çalışma Oranı -->
    <div class="card">
        <div class="card-header">Doktor Çalışma Oranı</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Çalışma Oranı</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $sql = "SELECT DISTINCT tarih FROM doktor_zaman";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $tarih = $row['tarih'];
                        
                        $baslangic_saati = 8;
                        $bitis_saati = 20;
                        $toplam_randevu_kapasitesi = 0;
                        $toplam_randevular = 0;

                        for ($saat = $baslangic_saati; $saat < $bitis_saati; $saat++) {
                            for ($dakika = 0; $dakika < 60; $dakika += 30) {
                                $zaman = sprintf("%02d:%02d", $saat, $dakika);

                                $randevu_sql = "SELECT COUNT(*) as randevu_sayisi FROM doktor_zaman WHERE tarih = ? AND saat = ?";
                                if ($stmt = $conn->prepare($randevu_sql)) {
                                    $stmt->bind_param("ss", $tarih, $zaman);
                                    $stmt->execute();
                                    $stmt->bind_result($randevu_sayisi);
                                    $stmt->fetch();
                                    $stmt->close();
                                }

                                $toplam_randevu_kapasitesi += 1;
                                $toplam_randevular += $randevu_sayisi;
                            }
                        }

                        if ($toplam_randevu_kapasitesi > 0) {
                            $doluluk_orani = ($toplam_randevular / $toplam_randevu_kapasitesi) * 100;
                        } else {
                            $doluluk_orani = 0;
                        }

                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($tarih) . "</td>";
                        echo "<td>";
                        echo "<div style='width: 100%; background-color: #f3f3f3; border-radius: 5px;'>";
                        echo "<div style='width: " . $doluluk_orani . "%; background-color: #4CAF50; height: 20px; border-radius: 5px;'></div>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Henüz müsait saat yok.</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="footer">
    <p>© 2024 Sekreter Paneli | Tüm Hakları Saklıdır</p>
</div>

<script>
    //müsait saatleri çeker. O tarih ve gündeki
    document.getElementById("randevu_tarihi").addEventListener("change", function () {
        var tarih = this.value;
        var saatiSelect = document.getElementById("randevu_saati");

        saatiSelect.innerHTML = '<option value="">Saat Seçin</option>';

        if (tarih) {
            fetch("get_saatler.php?tarih=" + tarih)
                .then(response => response.json())
                .then(data => {
                    data.forEach(function (saat) {
                        var option = document.createElement("option");
                        option.value = saat;
                        option.textContent = saat;
                        saatiSelect.appendChild(option);
                    });
                });
        }
    });
</script>

</body>
</html>
