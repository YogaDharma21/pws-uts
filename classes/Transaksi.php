<?php
require_once __DIR__ . '/../config/Database.php';

class Transaksi extends Database
{
    private $table = 'transaksi';

    public function create($product_id, $qty)
    {
        $qry = "INSERT INTO $this->table (product_id, qty) VALUES (?, ?)";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("ii", $product_id, $qty);
        return $stmt->execute();
    }

    public function getAllTransactions()
    {
        $qry = "SELECT t.*, p.nama as product_name, p.jenis as product_type, p.harga as product_price
                FROM $this->table t
                JOIN produk p ON t.product_id = p.id
                ORDER BY t.transaction_date";
        return $this->conn->query($qry);
    }

    public function getById($id)
    {
        $qry = "SELECT * FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getTransactionsByProduct($product_id)
    {
        $qry = "SELECT * FROM $this->table WHERE product_id = ? ORDER BY transaction_date";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTotalTransactions()
    {
        $qry = "SELECT COUNT(*) as total FROM $this->table";
        $result = $this->conn->query($qry);
        return $result->fetch_assoc()['total'];
    }

    public function getTotalQtySold()
    {
        $qry = "SELECT SUM(qty) as total FROM $this->table";
        $result = $this->conn->query($qry);
        return $result->fetch_assoc()['total'];
    }
}
