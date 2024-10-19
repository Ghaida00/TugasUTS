<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM produk WHERE id=$id");
$item = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
<a href="logout.php">Logout</a>
<div class="container">
    <h2>Detail Produk</h2>
    <div class="product-image">
        <img src="uploads/<?php echo $item['image_prdk']; ?>" alt="<?php echo $item['nama_prdk']; ?>" width="200">
    </div>
    <div class="product-details">
        <h3>Nama Produk: <?php echo $item['nama_prdk']; ?></h3>
        <p>Deskripsi: <?php echo $item['deskripsi_prdk']; ?></p>
        <p>Harga: Rp<?php echo number_format($item['harga_prdk']); ?></p>
        <p>Stok: <?php echo $item['stok_prdk']; ?></p>
    </div>
    <a href="index.php" class="back-link">Kembali</a>
</div>
</body>
</html>