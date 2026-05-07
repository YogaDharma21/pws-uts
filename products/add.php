<?php
require_once '../classes/Product.php';

$product = new Product();
$error = '';
$success = '';

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
        if ($product->create($nama, $jenis, $stok, $harga)) {
            $success = 'Produk berhasil ditambahkan.';
        } else {
            $error = 'Gagal menambahkan produk.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
</head>

<body>
    <h1>Tambah Produk</h1>
    <a href="../index.php"><button>
            Dashboard
        </button></a>

    <?php if ($error): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?= $success ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="nama">Nama Produk:</label>
        <br>
        <input type="text" name="nama" id="nama" required>
        <br>
        <label for="jenis">Jenis Produk:</label>
        <br>
        <select name="jenis" id="jenis" required>
            <option value="">-- Pilih Jenis --</option>
            <option value="Laptop">Laptop</option>
            <option value="Smartphone">Smartphone</option>
        </select>
        <br>
        <label for="stok">Stok Awal:</label>
        <br>
        <input type="number" name="stok" id="stok" value="0" required>
        <br>
        <label for="harga">Harga (Rp):</label>
        <br>
        <input type="number" name="harga" id="harga" required>
        <br>
        <button type="submit">Simpan Produk</button>
    </form>
</body>

</html>
