<?php
// controllers/ChatController.php

include '../models/Message.php';

class ChatController {
    private $message;

    public function __construct($pdo) {
        $this->message = new Message($pdo);
    }

    public function sendMessage($senderId, $receiverId, $message) {
        return $this->message->create($senderId, $receiverId, $message);
    }

    public function getMessages($userId1, $userId2) {
        return $this->message->getMessagesBetweenUsers($userId1, $userId2);
    }
}
?>
