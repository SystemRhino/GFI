<?php
try {
  $conn = new PDO('mysql:host=127.0.0.1:3307;dbname=bd_gfi', 'root', 'usbw');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>