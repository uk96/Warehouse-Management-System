<?php 
  class ProductData {

    private $conn;
    private $tableName;
  
    public function __construct($db) {
      $this->conn = $db;
    }

    public function readExpiredProducts() {
      $query = 'SELECT * FROM `productdata` WHERE ExpiryDate <= CURDATE()';
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }
  }

?>