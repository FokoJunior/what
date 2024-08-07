<?php
// models/Group.php

class Group {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function create($name) {
        $stmt = $this->pdo->prepare("INSERT INTO groups (name) VALUES (?)");
        return $stmt->execute([$name]);
    }

    public function addUserToGroup($groupId, $userId) {
        $stmt = $this->pdo->prepare("INSERT INTO group_members (group_id, user_id) VALUES (?, ?)");
        return $stmt->execute([$groupId, $userId]);
    }

    public function getGroupMembers($groupId) {
        $stmt = $this->pdo->prepare("SELECT users.id, users.username FROM users 
                                     INNER JOIN group_members ON users.id = group_members.user_id 
                                     WHERE group_members.group_id = ?");
        $stmt->execute([$groupId]);
        return $stmt->fetchAll();
    }

    public function sendMessageToGroup($groupId, $senderId, $message) {
        $stmt = $this->pdo->prepare("INSERT INTO group_messages (group_id, sender_id, message) VALUES (?, ?, ?)");
        return $stmt->execute([$groupId, $senderId, $message]);
    }

    public function getGroupMessages($groupId) {
        $stmt = $this->pdo->prepare("SELECT group_messages.*, users.username FROM group_messages 
                                     INNER JOIN users ON group_messages.sender_id = users.id 
                                     WHERE group_messages.group_id = ?");
        $stmt->execute([$groupId]);
        return $stmt->fetchAll();
    }
}
?>
