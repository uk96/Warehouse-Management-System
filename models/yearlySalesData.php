<?php 
  class YearlySalesData {

    private $conn;
    private $tableName;
  
    public function __construct($db) {
      $this->conn = $db;
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