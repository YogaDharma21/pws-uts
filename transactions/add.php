<?php
require_once '../classes/Product.php';
require_once '../classes/Transaksi.php';

$product = new Product();
$transaksi = new Transaksi();

$productsResult = $product->getAllProducts();
$products = [];
while ($row = $productsResult->fetch_assoc()) {
    $products[] = $row;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];

    if ($product_id <= 0) {
        $error = 'Pilih produk yang valid.';
    } elseif ($qty <= 0) {
        $error = 'Jumlah harus lebih dari 0.';
    } else {
        $productData = $product->getById($product_id);
        if (!$productData) {
            $error = 'Produk tidak ditemukan.';
        } elseif ($qty > $productData['stok']) {
            $error = 'Stok tidak mencukupi. Stok tersedia: ' . $productData['stok'] . ' unit.';
        } else {
            if ($transaksi->create($product_id, $qty) && $product->reduceStock($product_id, $qty)) {
                $success = 'Transaksi berhasil dicatat. Stok berhasil dikurangi.';
            } else {
                $error = 'Gagal mencatat transaksi.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Penjualan</title>
</head>

<body>
    <h1>Catat Transaksi Penjualan</h1>
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
        <label for="product_id">Pilih Produk:</label><br>
        <select name="product_id" id="product_id" required>
            <option value="">-- Pilih Produk --</option>
            <?php foreach ($products as $p): ?>
                <option value="<?= $p['id'] ?>">
                    <?= $p['nama'] ?> (<?= $p['jenis'] ?>)
                    - Stok: <?= $p['stok'] ?> | Harga: Rp <?= $p['harga'] ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="qty">Jumlah Terjual:</label><br>
        <input type="number" name="qty" id="qty" min="1" value="1" required><br><br>

        <button type="submit">Catat Transaksi</button>
    </form>
</body>

</html>
