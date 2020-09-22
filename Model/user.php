<?php


class User
{
    private $db;
 
    function __construct($DB_con)
    {
      $this->db = $DB_con;
    }
 
    public function register($uname,$uPass)
    {
       try
       {
           $new_password = password_hash($uPass, PASSWORD_DEFAULT);
   
           $stmt = $this->db->prepare("INSERT INTO ofs_staff(staff_name,staff_password,staff_isactive,role_id) 
                                                       VALUES(:uname, :uPass, 1, 1)");
              
           $stmt->bindparam(":uname", $uname);
           $stmt->bindparam(":uPass", $new_password);            
           $stmt->execute(); 
   
           return $stmt; 
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }    
    }
 
    public function login($uname,$uPass)
    {
       try
       {
          $stmt = $this->db->prepare("SELECT * FROM ofs_staff WHERE staff_name=:uname LIMIT 1");
          $stmt->execute(array(':uname'=>$uname));
          $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
          if($stmt->rowCount() > 0)
          {
             if(password_verify($uPass, $userRow['staff_password']))
             {
                $_SESSION['user_session'] = $userRow['staff_id'];
                return true;
             }
             else
             {
                return false;
             }
          }
       }
       catch(PDOException $e)
       {
           echo $e->getMessage();
       }
   }
 
   public function is_loggedIn()
   {
      if(isset($_SESSION['user_session']))
      {
         return true;
      }
   }
 
   public function redirect($url)
   {
       header("Location: $url");
   }
 
   public function logout()
   {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
   }

   public function byUserName($user) {
      $stmt = $this->db->prepare("SELECT * FROM ofs_staff WHERE staff_id=:user_id");
      $stmt->execute(array(":user_id"=>$user));
      $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
  
      // return values
      return $userRow;
    }
}
?>