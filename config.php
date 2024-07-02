<?php
$server = "localhost";
$user = "root";
$pass = "";
$database = "pengajuan_santunan";
$conn = mysqli_connect($server, $user, $pass, $database);
if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>