<?php

#get database connection
function get_db(){
    $db = null;
    try{
        $db = new PDO('mysql:host=z8dl7f9kwf2g82re.cbetxkdyhwsb.us-east-1.rds.amazonaws.com:3306;dbname=onsigltezg12crks', 's2j1nc0cwmiyk1ds','wrih75ysww2o76c3');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        // notice how we THROW the exception. You can catch this in your controller code in the usual way
        throw new Exception("Something wrong with the database: ".$e->getMessage());
    }
    return $db;
}


#Add product
function addbin($type, $location){
    $db = get_db();
    $query = "INSERT INTO bin (type, location) VALUES (?,?)";
    $statement = $db->prepare($query);
    $binding = array($type, $location);
    $statement -> execute($binding);
}

function addrubbish($type, $name, $description){
    $db = get_db();
    $query = "INSERT INTO rubbish (type,name,description) VALUES (?,?,?)";
    $statement = $db->prepare($query);
    $binding = array($type, $name, $description);
    $statement -> execute($binding);
}

function deleterubbish($name){
   try{
      $db = get_db();
      $query = "DELETE FROM rubbish WHERE name= ?" ;
      if($statement = $db-> prepare($query)){
         $binding = array($name);
         if(!$statement -> execute($binding)){
            throw new Exception("Could not execute query.");
        }
      }
   } catch(Exception $e){
      throw new Exception($e->getMessage());
   }
}


function deleteleaderboarduser($fname){
   try{
      $db = get_db();
      $query = "DELETE FROM user WHERE fname= ?" ;
      if($statement = $db-> prepare($query)){
         $binding = array($fname);
         if(!$statement -> execute($binding)){
            throw new Exception("Could not execute query.");
        }
      }
   } catch(Exception $e){
      throw new Exception($e->getMessage());
   }
}

  function addpoint($points){
      session_start();
      $db = get_db();
      $email= $_SESSION["email"];

      $updated_points = $points +2;

      $query2 = "UPDATE user set points = '15' where email = 'daisy@hotmail.com'";
      $statement = $db->prepare($query2);
      $statement -> execute();

        }


#get all product items from database
function product_list(){
  try{
    $db = get_db();
    $query = "SELECT id,type,location,used FROM bin";
    $statement = $db->prepare($query);
    $statement ->execute();
    $list = $statement->fetchall(PDO::FETCH_ASSOC);
    return $list;
  }
  catch(PDOException $e){
    throw new Exception($e->getMessage());
    return "";
  }
  }

  function rubbish_list(){
    try{
      $db = get_db();
      $query = "SELECT * FROM rubbish";
      $statement = $db->prepare($query);
      $statement ->execute();
      $list = $statement->fetchall(PDO::FETCH_ASSOC);
      return $list;
    }

    catch(PDOException $e){
      throw new Exception($e->getMessage());
      return "";
    }
    }


#get all account details from database
  function my_account(){
    session_start();
    try{
      $db = get_db();
      $query = "SELECT email,fname,lname,points,salt,hashed_password FROM user where email = ? ";
      $statement = $db->prepare($query);
      $email= $_SESSION["email"];
      $binding = array($email);
      $statement -> execute($binding);
      $list = $statement->fetchall(PDO::FETCH_ASSOC);
      return $list;
    }
    catch(PDOException $e){
      throw new Exception($e->getMessage());
      return "";
    }
    }

#still working on it
function update_details($id,$title,$fname,$lname,$email,$phone,$city,$state,$country,$postcode,$shipping_address){
   try{
     $db = get_db();
     if(validate_user_name($db,$fname)){
         $query = "UPDATE users SET title=?, fname=?, lname=?, email=?, phone=?, city=?, shipping_state=?, shipping_address=?, country=?, postcode=? WHERE id=?";
         if($statement = $db->prepare($query)){
            $binding = array($title,$fname,$lname,$email,$phone,$city,$state,$shipping_address,$country,$postcode,$id);
            if(!$statement -> execute($binding)){
               throw new Exception("Could not execute query.");
            }else{
               session_start();
               $_SESSION["email"] = $email;
               session_write_close();
            }
         }
         else{
         throw new Exception("Could not prepare statement.");
         }
     }
     else{
        throw new Exception("Invalid data.");
     }


   }
   catch(Exception $e){
       throw new Exception($e->getMessage());
   }

}

    function leaderboard(){
      session_start();
      try{
        $db = get_db();
        $query = "SELECT email,fname,lname, points FROM user ORDER BY points DESC";
        $statement = $db->prepare($query);
        $email= $_SESSION["email"];
        $binding = array($email);
        $statement -> execute($binding);
        $list = $statement->fetchall(PDO::FETCH_ASSOC);
        return $list;
      }
      catch(PDOException $e){
        throw new Exception($e->getMessage());
        return "";
      }

      }

      function leaderboardFirst(){
        session_start();
        try{
          $db = get_db();
          $query = "SELECT email,fname,lname, points FROM user ORDER BY points DESC LIMIT 1 ";
          $statement = $db->prepare($query);
          $email= $_SESSION["email"];
          $binding = array($email);
          $statement -> execute($binding);
          $first = $statement->fetchall(PDO::FETCH_ASSOC);
          return $first;
        }
        catch(PDOException $e){
          throw new Exception($e->getMessage());
          return "";
        }

        }

        function leaderboardSecond(){
          session_start();
          try{
            $db = get_db();
            $query = "SELECT email,fname,lname, points FROM user ORDER BY points DESC LIMIT 1 OFFSET 1 ";
            $statement = $db->prepare($query);
            $email= $_SESSION["email"];
            $binding = array($email);
            $statement -> execute($binding);
            $second = $statement->fetchall(PDO::FETCH_ASSOC);
            return $second;
          }
          catch(PDOException $e){
            throw new Exception($e->getMessage());
            return "";
          }

          }
          function leaderboardThird(){
            session_start();
            try{
              $db = get_db();
              $query = "SELECT email,fname,lname,points FROM user ORDER BY points DESC LIMIT 1 OFFSET 2 ";
              $statement = $db->prepare($query);
              $email= $_SESSION["email"];
              $binding = array($email);
              $statement -> execute($binding);
              $third = $statement->fetchall(PDO::FETCH_ASSOC);
              return $third;
            }
            catch(PDOException $e){
              throw new Exception($e->getMessage());
              return "";
            }

            }

    #get point details from database
      function points(){
        session_start();
        try{
          $db = get_db();
          $query = "SELECT points FROM user where email = ? ";
          $statement = $db->prepare($query);
          $email= $_SESSION["email"];
          $binding = array($email);
          $statement -> execute($binding);
          $list = $statement->fetchall(PDO::FETCH_ASSOC);
          return $list;
        }
        catch(PDOException $e){
          throw new Exception($e->getMessage());
          return "";
        }
        }

#signup function
  function sign_up($email,$fname, $lname, $password, $password_confirm){
     try{
       $db = get_db();

       if(validate_user_name($db,$email) && validate_passwords($password,$password_confirm)){
            $salt = generate_salt();
            $password_hash = generate_password_hash($password,$salt);
            $query = "INSERT INTO user (email,fname,lname,salt,hashed_password) VALUES (?,?,?,?,?)";
            if($statement = $db->prepare($query)){
               $binding = array($email,$fname, $lname,$salt,$password_hash);
               if(!$statement -> execute($binding)){
                   throw new Exception("Could not execute query.");
               }
            }
            else{
              throw new Exception("Could not prepare statement.");
            }
       }
       else{
          throw new Exception("Invalid data.");
       }
     }
     catch(Exception $e){
         throw new Exception($e->getMessage());
     }
  }
#doesnt work/not in use
function get_user_id(){
   $id="";
   session_start();
   if(!empty($_SESSION["id"])){
      $id = $_SESSION["id"];
   }
   session_write_close();
   return $id;
}

#doesnt work/not in use
function get_user_name(){
   $email="";
   $name="";
   session_start();
   if(!empty($_SESSION["email"])){
      $email = $_SESSION["email"];
   }
   session_write_close();

   try{
      $db = get_db();
      $query = "SELECT fname FROM user WHERE email=?";
      if($statement = $db->prepare($query)){
         $binding = array($email);
         if(!$statement -> execute($binding)){
                 throw new Exception("Could not execute query.");
         }
         else{
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $name = $result['name'];

         }
      }
      else{
            throw new Exception("Could not prepare statement.");
      }

   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
   return $name;
}

#sign in function with cart array intiated
function sign_in($user_name,$password){
   try{
      $db = get_db();
      $query = "SELECT email, salt, hashed_password FROM user WHERE email=?";
      if($statement = $db->prepare($query)){
         $binding = array($user_name);
         if(!$statement -> execute($binding)){
                 throw new Exception("Could not execute query.");
         }
         else{
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $salt = $result['salt'];
            $hashed_password = $result['hashed_password'];
            if(generate_password_hash($password,$salt) !== $hashed_password){
                throw new Exception("Account does not exist!");
            }
            else{
               $email = $result["email"];
               $cart = array();
               set_authenticated_session($email,$hashed_password, $cart);
            }
         }
      }
      else{
            throw new Exception("Could not prepare statement.");
      }
   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
}

#checks if database is empty
function is_db_empty(){
   $is_empty = false;
   try{
      $db = get_db();
      $query = "SELECT email FROM user WHERE email=?";
      if($statement = $db->prepare($query)){
	     $email="god@hotmail.com";
         $binding = array($email);
         if(!$statement -> execute($binding)){
                 throw new Exception("Could not execute query.");
         }
         else{
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if(empty($result)){
	          $is_empty = true;
            }
         }
      }
      else{
            throw new Exception("Could not prepare statement.");
      }
   }
   catch(Exception $e){
      throw new Exception($e->getMessage());
   }
   return $is_empty;

}

#added cart array
function set_authenticated_session($email, $password_hash, $cart){
      session_start();
      //Make it a bit harder to session hijack
      session_regenerate_id(true);
      $_SESSION["email"] = $email;
      $_SESSION["hash"] = $password_hash;
      $_SESSION["cart"] = $cart;
      session_write_close();
}

function generate_password_hash($password,$salt){
      return hash("sha256", $password.$salt, false);
}

function generate_salt(){
    $chars = "0123456789ABCDEF";
    return str_shuffle($chars);
}

#not implemented
function validate_user_name($db,$user_name){
    return true;
}
#not implemented
function validate_passwords($password, $password_confirm){
   if($password === $password_confirm && validate_password($password)){
      return true;
   }
   return false;
}

#not implemented
function validate_password($password){
  return true;
}

function admin_sign_in($admin, $password){
  try{
    if ($admin && $password){
      if ($admin === "admin" && $password === "Admin"){
        set_admin_authenticated_session($admin, $password);
      }
      else{
      throw new Exception("Wrong credentials entered, please enter correct credentials");
      }
    }
    else{
      throw new Exception("Fields are left empty, please fill all fields");
    }
  }
  catch(Exception $e){
    throw new Exception($e->getMessage());
  }
}



function set_admin_authenticated_session($admin,$password){
      session_start();

      //Make it a bit harder to session hijack
      session_regenerate_id(true);

      $_SESSION["admin"] = $admin;
      $_SESSION["password"] = $password;
      session_write_close();
}


function is_authenticated(){
    $email = "";
    $hash="";
    session_start();
    if(!empty($_SESSION["email"]) && !empty($_SESSION["hash"] )){
       $email = $_SESSION["email"];
       $hash = $_SESSION["hash"];
    }
    session_write_close();

    if(!empty($email) && !empty($hash)){

        try{
           $db = get_db();
           $query = "SELECT hashed_password FROM user WHERE email=?";
           if($statement = $db->prepare($query)){
             $binding = array($email);
             if(!$statement -> execute($binding)){
                return false;
             }
             else{
                 $result = $statement->fetch(PDO::FETCH_ASSOC);
                 if($result['hashed_password'] === $hash){
                   return true;
                 }
             }
           }

        }
        catch(Exception $e){
           throw new Exception("Authentication not working properly. {$e->getMessage()}");
        }

    }
    return false;

}

function is_admin_authenticated(){
  $admin ="";
  $password = "";

  session_start();
  if(!empty($_SESSION["admin"]) && !empty($_SESSION["password"])){
     $admin = $_SESSION["admin"];
     $password = $_SESSION["password"];
  }
  session_write_close();

  if(!empty($admin) && !empty($password)){

      try{
         if($admin === "admin" && $password === "Admin"){
           return true;

         }
       }

      catch(Exception $e){
         throw new Exception("Authentication not working properly. {$e->getMessage()}");
      }
  } else{
      return false;
  }
}

function sign_out(){
    session_start();
    if(!empty($_SESSION["email"]) && !empty($_SESSION["hash"])){
       $_SESSION["email"] = "";
       $_SESSION["hash"] = "";
       $_SESSION = array();
       session_destroy();
    }
    else if(!empty($_SESSION["admin"]) && !empty($_SESSION["password"])){
      $_SESSION["admin"] = "";
      $_SESSION["password"] = "";
      $_SESSION = array();
      session_destroy();
    }

    session_write_close();


}
