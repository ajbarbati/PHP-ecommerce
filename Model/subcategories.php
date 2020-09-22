<?php
class SubCategory
{

    public
        $subcategory_id,  
        $subcategory_name, 
        $subcategory_description;
        
    
        public function __construct($db){
            $this->conn = $db;
        }
       
        function subRead(){
    
            // select all products query
            $query = "SELECT * FROM ofs_product_subcategories";
        
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
        
            // execute query
            $stmt->execute();
        
            // return values
            return $stmt;
        }
        function catRead($id){
            
                // select all products query
                $query = "SELECT * FROM ofs_product_subcategories WHERE category_id =".$id;
            
                // prepare query statement
                $stmt = $this->conn->prepare( $query );
            
                // execute query
                $stmt->execute();
            
                // return values
                return $stmt;
            
        }
        function subName($id,$id2){
            
                // select all products query
                $query = "SELECT * FROM ofs_product_subcategories WHERE category_id =".$id." AND subcategory_id =".$id2;
            
                // prepare query statement
                $stmt = $this->conn->prepare( $query );
            
                // execute query
                $stmt->execute();
            
                // return values
                return $stmt;
            
        }
}