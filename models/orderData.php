<?php 
  class ProductData {

    private $conn;
    private $tableName;
  
    public function __construct($db) {
      $this->conn = $db;
    }

    public function fetchOrderDataByBatch($offset, $limit) {
      $query = 'SELECT * FROM ( SELECT * , ROW_NUMBER() OVER (ORDER BY InvoiceNumber, ProductId) AS RowNum FROM `orderdatatable` ) orderData WHERE orderdata.RowNum BETWEEN ' . $offset .'AND '. ($offset + $limit);
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }
  }
?>