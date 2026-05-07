<?php
require_once './classes/Product.php';
require_once './classes/Transaksi.php';

$product = new Product();
$transaksi = new Transaksi();

$lowStockResult = $product->getProductsSedikit(5);
$lowStockProducts = [];
while ($row = $lowStockResult->fetch_assoc()) {
    $lowStockProducts[] = $row;
}

$rekapTransaksi = $transaksi->getAllTransactions();
$rekapProduk = $product->getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>

<body>
    <h2>Peringatan Stok Sedikit (dibawah 5)</h2>
    <?php if (count($lowStockProducts) > 0): ?>
        <ul>
            <?php foreach ($lowStockProducts as $p): ?>
                <li>
                    <?= $p['nama'] ?> (<?= $p['jenis'] ?>)
                    tersisa: <?= $p['stok'] ?> unit
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Tidak ada produk dengan stok sedikit</p>
    <?php endif; ?>
    <h2>Produk <a href="./products/add.php"><button>
                Tambah Produk
            </button></a></h2>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama Produk</th>
            <th>Jenis</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $rekapProduk->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['nama'] ?></td>
                <td><?= $row['jenis'] ?></td>
                <td>
                    <?= $row['stok'] ?>
                    <?php if ($row['stok'] < 5): ?>
                        <br><em style="color:red;">Stok Sedikit!</em>
                    <?php endif; ?>
                </td>
                <td>Rp <?= $row['harga'] ?></td>
                <td>
                    <?php if ($row['stok'] < 5): ?>
                        <span style="color:red;">Sedikit</span>
                    <?php else: ?>
                        <span style="color:green;">Aman</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="./products/edit.php?id=<?= $row['id'] ?>">Edit</a> |
                    <a href="./products/delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <div>
        <h2>Transaksi <a href="./transactions/add.php"><button>
                    Transaksi Baru
                </button></a></h2>

    </div>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Produk</th>
            <th>Jenis</th>
            <th>Qty Terjual</th>
            <th>Tanggal</th>
            <th>Total transaksi</th>
        </tr>
        <?php while ($row = $rekapTransaksi->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['product_name'] ?></td>
                <td><?= $row['product_type'] ?></td>
                <td><?= $row['qty'] ?></td>
                <td><?= $row['transaction_date'] ?></td>
                <td><?= $row['qty'] * $row['product_price'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>
