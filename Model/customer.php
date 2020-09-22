<?php
  class Customer {


    public function __construct($db) {
      $this->conn = $db;
    }

    public function addCustomer($data) {

      $email = $data['email'];
      $first_name = $data['first_name'];
      $last_name = $data['last_name'];
      $password = $data['password'];
      $phone = $data['phone'];
      // Prepare Query
      $query = "INSERT INTO ofs_customers 
      (email, first_name, last_name, password, phone, is_active) 
      VALUES
      ('$email', '$first_name', '$last_name', '$password', $phone, 1);
      ";
      
      // prepare query statement
      $stmt = $this->conn->prepare( $query );
  
      // Execute
      if($stmt->execute()) {
        return true;
      } else {
        return false;
      }
    }
    public function addAddress($data) {

      $email = $data['email'];
      $address1 = $data['address']['line1'];
      $address2 = $data['address']['line2'];
      $zipcode = $data['address']['zipcode'];
      $city = $data['address']['city'];
      $state = $data['address']['state'];
      // Prepare Query
      $query = "INSERT INTO ofs_addresses
      (address_1, address_2, city, state, postcode, email)
      VALUES
      ('$address1', '$address2', '$city', '$state', '$zipcode', '$email');
      ";
    
      // prepare query statement
      $stmt = $this->conn->prepare( $query );
  
      // Execute
      if($stmt->execute()) {
        return true;
      } else {
        return false;
      }
    }
  
    public function getCustomers() {
      $query = "SELECT * FROM ofs_customers ORDER BY date_created DESC";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );
  
      // execute query
      $stmt->execute();
  
      // return values
      return $stmt;
    }

    public function customerByEmail($email) {
      $query = "SELECT * FROM ofs_customers WHERE email = '".$email."'";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );
  
      // execute query
      $stmt->execute();
  
      // return values
      return $stmt;
    }
    public function addressByEmail($email) {
      $query = "SELECT * FROM ofs_addresses WHERE email = '".$email."'";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );
  
      // execute query
      $stmt->execute();
  
      // return values
      return $stmt;
    }
  }