<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Cek apakah ID produk ada dan ambil data produk
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM produk WHERE id=$id");
    $item = $result->fetch_assoc();
    
    if (!$item) {
        echo "Produk tidak ditemukan.";
        exit();
    }
}

// Proses form ketika disubmit
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    // Periksa apakah gambar baru diunggah
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);
    
    if ($image) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $sql = $conn->prepare("UPDATE produk SET nama_prdk=?, deskripsi_prdk=?, harga_prdk=?, image_prdk=?, stok_prdk=? WHERE id=?");
        $sql->bind_param("ssisii", $name, $description, $price, $image, $stock, $id);
    } else {
        $sql = $conn->prepare("UPDATE produk SET nama_prdk=?, deskripsi_prdk=?, harga_prdk=?, stok_prdk=? WHERE id=?");
        $sql->bind_param("ssiii", $name, $description, $price, $stock, $id);
    }

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
    <title>Edit Produk</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Edit Produk</h2>
    <a href="index.php">Batal Edit</a>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
        
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($item['nama_prdk']); ?>" required>
        
        <label for="description">Deskripsi:</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($item['deskripsi_prdk']); ?></textarea>
        
        <label for="price">Harga:</label>
        <input type="number" id="price" name="price" value="<?php echo $item['harga_prdk']; ?>" required>
        
        <label for="stock">Stok:</label>
        <input type="number" id="stock" name="stock" value="<?php echo $item['stok_prdk']; ?>" required>
        
        <label for="image">Gambar:</label>
        <input type="file" id="image" name="image">
        
        <input type="submit" name="update" value="Update">
    </form>
</div>
</body>
</html>
