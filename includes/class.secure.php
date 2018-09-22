<?php
class Secure {
 
    private $users_table = "users";
    public $error;
    
    /***************************************************************
     Hashing Methods
    ****************************************************************/
    //generates a salt for hashing
    private function generateSalt($length=22) {
        $length = (int)$length;
        $len    = ($length >= 22) ? $length : 22;
        
        $unique_str = md5(uniqid(mt_rand(), true));
        $base64     = base64_encode($unique_str);
        $modified   = str_replace("+", ".", $base64);
        return substr($modified, 0, $len);
    }
    
    // Use Built-in versions instead if you are on PHP >5.6 php 
    // returns a hashed password
    public function passwordHash($password="") {
        $hash_type     = "$2y$11$";
        $salt          = $hash_type.$this->generateSalt(22);
        return crypt($password, $salt);
    }
    
    //verify a hashed password with existing password
    public function passwordVerify($password="", $hash_password="") {
        return (crypt($password, $hash_password) === $hash_password) ? true : false;
    }



    /***************************************************************
     Validation Methods
    ****************************************************************/

    // Check whether password is strong 
    // Tweak it based to your requirement
    public function checkPasswordStrength($password="") {
        // Validate
        if(!isset($password[7])) {
            // validate length
            $this->error = "Password must be at least 8 characters"; 
            return false;
        } elseif(!preg_match('/([a-z]+)/', $password)) {
            // validate lowercase
            $this->error = "Password must include a lower case alphabet"; 
            return false;
        } elseif(!preg_match('/([A-Z]+)/', $password)) {
            // validate uppercase
            $this->error = "Password must include an upper case alphabet"; 
            return false;
        } elseif(!preg_match('/([0-9]+)/', $password)) {
            // validate numeric charaters
            $this->error = "Password must include a numeric character"; 
            return false;
        } elseif(!preg_match('/([^a-zA-Z0-9]+)/', $password)) {
            // validate symbols
            $this->error = "Password must include a symbol"; 
            return false;
        } 
        return true;
    }

    public function validateEmailAddress($email="") {
        global $Database;


        if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
            $this->error = "Your email address is invalid";
            return false;
        } elseif (isset($email[39])) {
            $this->error =  "Email address is too long";
            return false;
        }

        //validate for duplicate in database
        $sql  = "SELECT * FROM ".$this->users_table;
        $sql .= " WHERE email = '{$email}' LIMIT 1";

        $result = $Database->query($sql);
        if($Database->num_rows($result) == 1) {
            $this->error = "This email address is already in use.";
            return false;
        }
        return true;
    }

    //for authenticating user login
    public function authenticate($email="", $password="") {
        global $Database, $Session;

        $email = $Database->cleanData($email);
       
        // Fetch session user's level
        $sql  = "SELECT * FROM ".$this->users_table;
        $sql .= " WHERE email = '{$email}' ";
        $sql .= "LIMIT 1";

        $result = $Database->query($sql);
        if ($Database->numRows($result) != 1) return false;
        $row    = $Database->fetchData($result);

        return ($this->passwordVerify($password, $row->password) === true) ? true : false;
    }
}

$secure = new Secure();
?>