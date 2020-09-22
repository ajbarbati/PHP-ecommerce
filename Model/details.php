<?php
    class Details
        {

            public 
                $category_id,
                $subcategory_id,
                $product_id,
                $detail_id, 
                $detail_name, 
                $detail_description, 
                $detail_price;
                
            
                public function __construct($db){
                    $this->conn = $db;
                }
            
                function detRead(){
            
                    // select all products query
                    $query = "SELECT * FROM ofs_product_details";
                
                    // prepare query statement
                    $stmt = $this->conn->prepare( $query );
                
                    // execute query
                    $stmt->execute();
                
                    // return values
                    return $stmt;
                }
                // read all product based on product ids included in the $ids variable
                
                // reference http://stackoverflow.com/a/10722827/827418
                public function readByIds($id1,$id2,$id3){
                
                    // query to select products
                    $query = " SELECT detail_name, detail_price, detail_id FROM ofs_product_details WHERE category_id = ".$id1." AND subcategory_id = ".$id2." AND product_id = ".$id3;
                
                    // prepare query statement
                    $stmt = $this->conn->prepare($query);
                    $ids = array($id1,$id2,$id3);
                    // execute query
                    $stmt->execute($ids);
                
                    // return values from database
                    return $stmt;
                }   
        }
