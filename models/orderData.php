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

    public function insertOrder($orderData){
      try{
        $query = 'INSERT INTO orderdatatable (InvoiceNumber, ProductId, ProductName, Quantity, InvoiceDate, UnitPrice, CustomerId, Country) VALUES ("'.$orderData["invoiceNumber"].'", "'.$orderData["productId"].'", "'.$orderData["productName"].'", "'.$orderData["quantity"].'", "'.$orderData["invoiceDate"].'", "'.$orderData["unitPrice"].'", "'.$orderData["customerId"].'", "'.$orderData["country"].'")';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return 1;
      } catch(PDOException $e) {
        return 0;
      } 
    }
  }
?>