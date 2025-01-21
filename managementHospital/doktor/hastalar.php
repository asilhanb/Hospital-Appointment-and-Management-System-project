<?php
include '../db_connection.php';

$query = "SELECT * FROM hastalar";
$result = $conn->query($query);
?>
<div class="container mt-5">
    <h4>Hasta Yönetimi</h4>
    <button class="btn btn-success mb-3" data-toggle="modal" data-target="#addPatientModal">Yeni Hasta Ekle</button>
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>#</th>
                <th>Ad Soyad</th>
                <th>Doğum Tarihi</th>
                <th>Şikayet</th>
                <th>İşlemler</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['ad_soyad'] ?></td>
                    <td><?= $row['dogum_tarihi'] ?></td>
                    <td><?= $row['sikayetler'] ?></td>
                    <td>
                        <a href="hasta_detay.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Detay</a>
                        <a href="hasta_sil.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Sil</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
