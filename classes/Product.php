<?php
require_once __DIR__ . '/../config/Database.php';

class Product extends Database
{
    private $table = 'produk';

    public function create($nama, $jenis, $stok, $harga)
    {
        $qry = "INSERT INTO $this->table (nama, jenis, stok, harga) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("ssii", $nama, $jenis, $stok, $harga);
        return $stmt->execute();
    }

    public function getAllProducts()
    {
        $qry = "SELECT * FROM $this->table ORDER BY id";
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

    public function update($id, $nama, $jenis, $stok, $harga)
    {
        $qry = "UPDATE $this->table SET nama = ?, jenis = ?, stok = ?, harga = ? WHERE id = ?";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("ssiii", $nama, $jenis, $stok, $harga, $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $qry = "DELETE FROM $this->table WHERE id = ?";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getProductsSedikit($threshold = 5)
    {
        $qry = "SELECT * FROM $this->table WHERE stok < ?";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("i", $threshold);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    public function reduceStock($id, $qty)
    {
        $qry = "UPDATE $this->table SET stok = stok - ? WHERE id = ? AND stok >= ?";
        $stmt = $this->conn->prepare($qry);
        $stmt->bind_param("iii", $qty, $id, $qty);
        return $stmt->execute();
    }
}
