<?php
session_start();
// Oturum verilerini sil
session_unset();
session_destroy();
//girişe yolla
header('Location: login.html');
exit();
?>
