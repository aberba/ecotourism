<?php
class Session {

    private $logged_id  = false,
            $message    = "";

    public $id,
           $role;


    function __construct() {
        session_start();
        $this->checkLogin();
        $this->checkMessage();
    }

    /* Session Login & Logout Methods
    *************************************************************/
    private function checkLogin() {
        if (isset($_SESSION['id'])) {
            $this->id        = (int)$_SESSION['id'];
            $this->logged_id = true;
        } else {
            unset($this->id);
            $this->logged_id = false;
        }
        
        //if (isset($_COOKIE['id'])) $_SESSION['id'] = (int)$_COOKIE['id'];
    }

    private function checkMessage() {
        if ( isset($_SESSION['message']) ) {
            $this->message = $_SESSION['message'];
            unset($_SESSION['message']);
        } else {
            $this->message = "";
        }
    }

    public function message($message="") {
        if (!empty($message)) {
            $_SESSION['message'] = $message;
        } else {
            return $this->message;
        }
    }

    public function login($id=0, $role=0) {
        $_SESSION['id']   = $id;
        $_SESSION['role'] = $role;
        $this->id         = $id;
        $this->role       = $role;
        $this->logged_id  = true;

        //if ($remember_me === true) setcookie('id', $user_id, time() + (60 * 60 * 24 * 2), "/");
        //$this->logLogin($user_id);
    }

    public function logout() {  
        unset($_SESSION['id']);
        unset($_SESSION['role']);
        session_destroy();
        setcookie(session_name(), null, time() - (3600 * 60 * 60 * 24));

        unset($this->id);
        unset($this->role);
        $this->logged_id  = false;  

        //setcookie('id', null, time() - (3600 * 60 * 60 * 24), "/");     
        //setcookie('id', null, time() - (3600 * 60 * 60 * 24), "/ajax/");   
        //if (isset($_COOKIE[session_name()])) setcookie(session_name(), "", time() - (3600 * 60 * 24), "/");
    }

    public function loggedIn() {
        return $this->logged_id;
    }

    public function is_admin() {
        return ($this->user_role >= 2) ? true : false;
    }

    public function is_moderator() {
        return ($this->user_role >= 1) ? true : false;
    }

    public function isActivated($user_id=0) {}


    public function user() {
        $user = array("id"         => (int)$this->user_id,
                       "name"      => $this->username,
                       "fullname"  => $this->fullname,
                       "email"     => $this->user_email,
                       "level"     => $this->user_role
                      );
        return $user; 
    }

    public static function authenticateLogin($email="", $password="") {
        global $database, $secure;

        $sql  = "SELECT * FROM ".static::$users_name." WHERE email = '";
        $sql .= $Database->cleanData( $email ). "' LIMIT 1";
        $records = static::findBySQL($sql);

        if (empty($records)) return false;
        return ($secure->passwordVerify($password, $records[0]->password)) ? $records[0] : false;
    }

    public function registerAccount($post=null) {}
}

$session = new Session();
?>