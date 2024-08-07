<?php
// controllers/UserController.php

include '../models/User.php';

class UserController {
    private $user;

    public function __construct($pdo) {
        $this->user = new User($pdo);
    }

    public function getUserById($id) {
        $stmt = $this->user->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getAllUsers() {
        $stmt = $this->user->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function updateUser($id, $username, $password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->user->pdo->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
        return $stmt->execute([$username, $hash, $id]);
    }

    public function deleteUser($id) {
        $stmt = $this->user->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
?>
