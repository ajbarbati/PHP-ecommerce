<?php
class Category
{

    public
        $category_id,  
        $category_name, 
        $category_description;
        
    
        public function __construct($db){
            $this->conn = $db;
        }
       
        function catRead(){
    
            // select all products query
            $query = "SELECT * FROM ofs_product_categories";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // execute query
            $stmt->execute();
        
            // return values
            return $stmt;
        }
        function catName($cat){
    
            // select all products query
            $query = "SELECT category_name FROM ofs_product_categories WHERE category_id = ". $cat;
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // execute query
            $stmt->execute();
        
            // return values
            return $stmt;
        }
}


