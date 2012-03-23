<?php

class board extends dao {

    protected $table = __CLASS__;


    public $username;

    public $message;


    public $entered_on;

    public function set_entered_on($entered_on) {
        $this->entered_on = $entered_on;
    }

    public function get_entered_on() {
        return $this->entered_on;
    }

    public function set_message($message) {
        $this->message = $message;
    }

    public function get_message() {
        return $this->message;
    }

    public function set_table($table) {
        $this->table = $table;
    }

    public function get_table() {
        return $this->table;
    }

    public function set_username($username) {
        $this->username = $username;
    }

    public function get_username() {
        return $this->username;
    }
}

?>