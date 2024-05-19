<?php

require_once 'Databeses.php';

class Message {

    protected $connection;
    public function __construct() {
        $this->connection = new Database();
    }

    public function add($ip, $user_agent, $message) {

        // insert user
        $user_data = [
            'ip' => $ip
        ];
        $user_id = $this->connection->insert('users', $user_data);
        $message_data = [
            'user_id' => $user_id,
            'message' => $message,
            'user_agent' => $user_agent
        ];
        $this->connection->insert('messages', $message_data);
    }
}