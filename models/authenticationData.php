<?php 
  class Authenticate {

    private $conn;
    private $tableName;
    private $baseUrl = "http://localhost/wms/api";
  
    public function __construct($db) {
      $this->conn = $db;
    }

    public function authorizeData($username, $password) {
      $query = 'Select * from user where useremail="' . $username . '" and password="' . $password . '"';
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    public function insertData($userName, $userEmail, $password) {
      try{
        $query = 'INSERT INTO user (username, useremail, password) VALUES ( "'. $userName . '","'. $userEmail . '","' . $password . '")';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return 1;
      } catch(PDOException $e) {
        return 0;
      }
    }

    public function insertMailChain($userEmail) {
      try{
        $query = 'INSERT INTO mailchain (email) VALUES ( "'. $userEmail . '")';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return 1;
      } catch(PDOException $e) {
        return 0;
      }
    }

    public function deleteMailChain($userEmail) {
      try{
        $query = 'DELETE FROM mailchain WHERE email ="'.$userEmail.'"';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return 1;   
      } catch(PDOException $e) {
        return 0;
      }  
    }

    public function makeApiCall($url,$postdata) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $this->baseUrl . $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postdata));
      $result = curl_exec($ch);
      return $result;
    }

    public function getApiCall($url) {
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$this->baseUrl . $url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      return $result;
    }

    public function getAllEmail() {
      $query = 'SELECT * FROM mailchain';
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }
  }

?>