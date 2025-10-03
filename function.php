<?php
// function.php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // bantu debugging
$host = "localhost";
$user = "root";
$pass = "";
$db   = "octa";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
$conn->set_charset("utf8mb4");
?>
