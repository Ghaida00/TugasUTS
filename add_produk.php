<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['insert'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $sql = $conn->prepare("INSERT INTO produk (nama_prdk, deskripsi_prdk, harga_prdk, image_prdk, stok_prdk) VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("ssisi", $name, $description, $price, $image, $stock);

    if ($sql->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Tambah Produk</h2>
    <a href="index.php">Batal Tambah</a>
    <form method="post" enctype="multipart/form-data">
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Deskripsi:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="price">Harga:</label>
        <input type="number" id="price" name="price" required>

        <label for="stock">Stok:</label>
        <input type="number" id="stock" name="stock" required>

        <label for="image">Gambar:</label>
        <input type="file" id="image" name="image" required>

        <input type="submit" name="insert" value="Tambah">
    </form>
</div>
</body>
</html>


