<?php

class User extends GlobalObject {
    protected static $table_name = "admin";
    protected static $table_columns = ["id", "fname", "lname", "email", "password", "role", "last_login"];

    public $id,
            $fname,
            $lname,
            $email,
            $password,
            $role,
            $last_login;

    private function logLogin() {
        //$this->last_login = time();
    }
}
?>
