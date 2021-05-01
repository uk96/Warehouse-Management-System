<?php 
  class YearlySalesData {

    private $conn;
    private $tableName;
  
    public function __construct($db) {
      $this->conn = $db;
    }

    public function getCount($productId) {
        $query = "SELECT COUNT(*) FROM `yearlysalesdata`";
        if ($productId) {
            $query .= " WHERE ProductId = '$productId' ";
        }
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getYearlySalesData($productId, $limit, $offset) {
        $query = "SELECT * FROM `yearlysalesdata`";
        if ($productId) {
            $query .= " WHERE ProductId = '$productId' ";
        }
        $query .= ' LIMIT ' . $limit . ' OFFSET ' . $offset;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
  }

?>