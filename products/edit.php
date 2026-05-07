<?php
require_once '../classes/Product.php';

$product = new Product();
$error = '';
$success = '';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('ID produk tidak valid.');
}

$id = intval($_GET['id']);
$data = $product->getById($id);

if (!$data) {
    die('Produk tidak ditemukan.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    if (empty($nama) || empty($jenis)) {
        $error = 'Nama dan jenis produk harus diisi.';
    } elseif ($stok < 0) {
        $error = 'Stok tidak boleh kurang dari 0.';
    } elseif ($harga < 0) {
        $error = 'Harga tidak boleh kurang dari 0.';
    } else {
        if ($product->update($id, $nama, $jenis, $stok, $harga)) {
            $success = 'Produk berhasil diperbarui.';
            $data = $product->getById($id);
        } else {
            $error = 'Gagal memperbarui produk.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>

<body>
    <h1>Edit Produk</h1>
    <a href="../index.php"><button>
            Dashboard
        </button></a>
    <?php if ($error): ?>
        <p style="color: red;"><?= $error?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?= $success ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nama">Nama Produk:</label><br>
        <input type="text" name="nama" id="nama" value="<?= $data['nama'] ?>" required>
        <br>
        <label for="jenis">Jenis Produk:</label><br>
        <select name="jenis" id="jenis" required>
            <option value="Laptop" <?= $data['jenis'] === 'Laptop' ? 'selected' : '' ?>>Laptop</option>
            <option value="Smartphone" <?= $data['jenis'] === 'Smartphone' ? 'selected' : '' ?>>Smartphone</option>
        </select>
        <br>

        <label for="stok">Stok:</label><br>
        <input type="number" name="stok" id="stok" value="<?= $data['stok'] ?>" required>
        <br>
        <label for="harga">Harga (Rp):</label><br>
        <input type="number" name="harga" id="harga" value="<?= $data['harga'] ?>" required>
        <br>
        <button type="submit">Update Produk</button>
    </form>
</body>

</html>
