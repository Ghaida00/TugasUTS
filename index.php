<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="style.css">  <!-- CSS umum -->
    <link rel="stylesheet" href="index.css"> <!-- CSS khusus untuk halaman ini -->
</head>
<body>
<div class="container">
    <a href="logout.php">Logout</a>
<h2>Daftar Produk</h2>
<a href="add_produk.php">Tambah Produk</a>
<ul>
<?php
$result = $conn->query("SELECT * FROM produk");
while($row = $result->fetch_assoc()):
?>
    <li>
        <?php echo $row['nama_prdk']; ?> Rp<?php echo number_format($row['harga_prdk']); ?> Stok: <?php echo $row['stok_prdk']; ?>
        [<a href="detail_produk.php?id=<?php echo $row['id']; ?>">Detail</a>]
        [<a href="edit_produk.php?id=<?php echo $row['id']; ?>">Edit</a>]
        [<a href="delete_produk.php?id=<?php echo $row['id']; ?>">Delete</a>]
    </li>
<?php endwhile; ?>
    </ul>
</div>
</body>
</html>
