<?php 
  class OrderData {

    private $conn;
    private $tableName;
  
    public function __construct($db) {
      $this->conn = $db;
    }

    public function getCount($invoiceNumber, $productId, $productName, $customerId) {
      if ($invoiceNumber) {
        $sql[] = " InvoiceNumber = '$invoiceNumber' ";
      }
      if ($productId) {
        $sql[] = " ProductId = '$productId' ";
      }
      if ($productName) {
        $sql[] = " ProductName LIKE '%$productName%' ";
      }
      if ($customerId) {
        $sql[] = " CustomerId = '$customerId' ";
      }
      $query = "SELECT COUNT(*) FROM `orderdatatable`";
      if (!empty($sql)) {
        $query .= ' WHERE ' . implode(' AND ', $sql);
      }
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    public function getOrderData($invoiceNumber, $productId, $productName, $customerId, $limit, $offset) {
      if ($invoiceNumber) {
        $sql[] = " InvoiceNumber = '$invoiceNumber' ";
      }
      if ($productId) {
        $sql[] = " ProductId = '$productId' ";
      }
      if ($productName) {
        $sql[] = " ProductName LIKE '%$productName%' ";
      }
      if ($customerId) {
        $sql[] = " CustomerId = '$customerId' ";
      }
      $query = "SELECT * FROM `orderdatatable`";
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