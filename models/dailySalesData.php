<?php 
  class DailySalesData {

    private $conn;
    private $tableName;
  
    public function __construct($db) {
      $this->conn = $db;
    }

    public function getCount($productId, $salesDate) {
        if ($productId) {
            $sql[] = " ProductId = '$productId' ";
        }
        if ($salesDate) {
            $sql[] = " SalesDate = '$salesDate' ";
        }
        $query = "SELECT COUNT(*) FROM `dailysalesdata`";
        if (!empty($sql)) {
            $query .= ' WHERE ' . implode(' AND ', $sql);
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getDailySalesData($productId, $salesDate, $limit, $offset) {
        if ($productId) {
            $sql[] = " ProductId = '$productId' ";
        }
        if ($salesDate) {
            $sql[] = " SalesDate = '$salesDate' ";
        }
        $query = "SELECT * FROM `dailysalesdata`";
        if (!empty($sql)) {
            $query .= ' WHERE ' . implode(' AND ', $sql);
        }
        $query .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
  }

?>