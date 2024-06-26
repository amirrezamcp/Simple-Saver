<?php

require_once 'Databeses.php';
require_once 'src/Semej.php';

use src\Semej\Semej;

class Message {

    protected $connection;
    public function __construct() {
        $this->connection = new Database();
    }

    public function add($ip, $user_agent, $message) {
        $user_id = $this->checkIP($ip);
        if(is_null($user_id)) {
            // insert user
            $user_data = [
                'ip' => $ip
            ];
            $user_id = $this->connection->insert('users', $user_data);
        }
        $message_data = [
            'user_id' => $user_id,
            'message' => $message,
            'user_agent' => $user_agent
        ];
        $this->connection->insert('messages', $message_data);
        Semej::set('success', 'OK', 'Message Saved');
        header("Location:" . $_SERVER['PHP_SELF']);
    }

    public function checkIP($ip) {
        $result = $this->connection->select('users', "ip ='$ip'");
        if(count($result) > 0) {
            return $result[0]['id'];
        }else{
            return null;
        }
    }

    public function getMessage($ip) {
        $result = $this->connection->getLastMessage($ip);
        if(count($result) > 0) {
            return $result[0]['message'];
        }else{
            return null;
        }
    }
    public function getMessageS($ip) {
        $result = $this->connection->getLast10Messages($ip);
        if(count($result) > 0) {
            return $result;
        }else{
            return null;
        }
    }
}