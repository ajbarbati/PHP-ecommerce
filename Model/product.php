<?php
    class Product
        {

            public 
                $category_id,
                $subcategory_id,
                $product_id,
                $product_name, 
                $product_description;
                
            
                public function __construct($db){
                    $this->conn = $db;
                }
            
                function proRead(){
            
                    // select all products query
                    $query = "SELECT * FROM ofs_products";
                
                    // prepare query statement
                    $stmt = $this->conn->prepare( $query );
                
                    // execute query
                    $stmt->execute();
                
                    // return values
                    return $stmt;
                }
                function cartRead($id1,$id2,$id3){
            
                    // select all products query
                    $query = "SELECT * FROM ofs_products WHERE category_id = ".$id1." AND subcategory_id = ".$id2." AND product_id = ".$id3;
                
                    // prepare query statement
                    $stmt = $this->conn->prepare( $query );
                
                    // execute query
                    $stmt->execute();
                
                    // return values
                    return $stmt;
                }
                function categoryRead($cat){
            
                    // select all products query
                    $query = "SELECT * FROM orderforsure.ofs_products WHERE category_id = ".$cat." ;";
                
                    // prepare query statement
                    $stmt = $this->conn->prepare( $query );
                
                    // execute query
                    $stmt->execute();
                
                    // return values
                    return $stmt;
                }
                function subCatRead($cat,$sub) {
                    // select all products query
                    $query = "SELECT * FROM orderforsure.ofs_products WHERE category_id = ".$cat." AND subcategory_id = ".$sub." ;";
                
                    // prepare query statement
                    $stmt = $this->conn->prepare( $query );
                
                    // execute query
                    $stmt->execute();
                
                    // return values
                    return $stmt;
                }
                function proSearch($term) {
                    // select all products query
                    $query = "SELECT * FROM orderforsure.ofs_products WHERE product_name LIKE '%".$term."%' OR product_description LIKE '%".$term."%'";
                
                    // prepare query statement
                    $stmt = $this->conn->prepare( $query );
                
                    // execute query
                    $stmt->execute();
                
                    // return values
                    return $stmt;
                }
        }
?> 