<?php
  class Transaction {
    
    public function __construct($db) {
      $this->conn = $db;
    }

      public function addTransactionHead($data1, $data2) {

        $total = ($data1['amount'] * .01);
        $email = $data2['email'];

        // Prepare Query
        $query = "INSERT INTO ofs_order_header
        (amount, comments, service_method_id, address_id, store_id, payment_id)
        VALUES
        ('$total', NULL, 1, (select address_id from ofs_addresses where email = '$email'), 1, 1);
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

      //MY WORK ON TRANSACTION DETAIL INSERT
public function addTransactionDetail($data, $data2) {
  //Initialize iterator (detail record) and fields array
  $i = 0;
  $fields = array();
  $email = $data2['email'];

  //grab the order id from the current order
  $orderq = "SELECT order_id FROM ofs_order_header WHERE address_id = (SELECT address_id FROM ofs_addresses WHERE email = '$email' ORDER BY address_id DESC LIMIT 1)";
  $sth = $this->conn->prepare( $orderq );
  $sth->execute();
  $oresult = $sth->fetchColumn();

  //iterate through items selected by customer 
  foreach($data as $key => $value){
    $i++;
    $fields[] = "('$oresult', '$i', '$value[2]', 1, 'Test Inserts', '$value[3]', '$value[4]', '$value[5]', '$value[6]')";
  }

  //query the order details into ofs_order_detail
  $query_values = implode(',', $fields);

  $query = "INSERT INTO ofs_order_detail (order_id, order_detail_id, detail_price, qty, comment, category_id, subcategory_id, product_id, detail_id) VALUES $query_values";
  $stmt = $this->conn->prepare( $query );
  if($stmt->execute()) {
    return true;
  } else {
    return false;
  }
  }

    public function getTransactions() {
      $query = "SELECT * FROM transactions ORDER BY created_at DESC";

      // prepare query statement
      $stmt = $this->conn->prepare( $query );
  
      // execute query
      $stmt->execute();
  
      // return values
      return $stmt;
    }
  }