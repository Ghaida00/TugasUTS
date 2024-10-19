<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$sql = $conn->prepare("DELETE FROM produk WHERE id=?");
$sql->bind_param("i", $id);
$sql->execute();
header("Location: index.php");
exit();
?>
