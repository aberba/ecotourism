<?php
class Util {

    /* Recommended version of __autoload() in PHP manual */

    //New recommended version of __autopload(); see PHP documentation.
    // spl_autoload_register(function($class_name) {
    //     $file_name = "class.". strtolower($class_name) .".php";
    //     require_once(INC_DIR.DS.$file_name);
    // });


    // used to check againsts crost domain ajax request attacks 
    // in public/ajax/* files
    public static function isAjaxRequest() {
        if ($_SERVER["HTTP_X_REQUESTED_WITH"] !== "XMLHttpRequest") return false;

        
        // Uncomment code to ensure ajax request only come from your server
        // Attackers could use ajax DDoS if this is not implemented 
        // Remember to define MY_HTTP_HOST_NAME when you uncomment code
        //if ($_SERVER['HTTP_HOST'] != MY_HTTP_HOST_NAME) return false;
        return true;
    }
    
    public static function includeTemplate($file_name="") {
        $file_name = strtolower($file_name);
        include(TEM_DIR.DS.$file_name);
    }

    public static function redirectTo($location=null) {
        header("Location: $location");
    }

    public static function arrayToMessage($array=null) {
        return "<ul id='error-messages'><li>". join("</li><li>", $array) .
        "</li></ul>";
    }

    public static function outputMessage($message="") {
        if ( isset($message[0]) )  echo "<div id='message'><p>". $message ."</p></div>";
    }

    public static function getFileExtension($file_name="") {
        //explode filename by "." into an array
        $exp_array = explode(".", basename($file_name));
        return $exp_array[ count($exp_array) -1 ];
    }
}
?>