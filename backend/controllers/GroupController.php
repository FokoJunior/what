<?php
// controllers/GroupController.php

include '../models/Group.php';

class GroupController {
    private $group;

    public function __construct($pdo) {
        $this->group = new Group($pdo);
    }

    public function createGroup($name) {
        return $this->group->create($name);
    }

    public function addUserToGroup($groupId, $userId) {
        return $this->group->addUserToGroup($groupId, $userId);
    }

    public function getGroupMembers($groupId) {
        return $this->group->getGroupMembers($groupId);
    }

    public function sendMessageToGroup($groupId, $senderId, $message) {
        return $this->group->sendMessageToGroup($groupId, $senderId, $message);
    }

    public function getGroupMessages($groupId) {
        return $this->group->getGroupMessages($groupId);
    }
}
?>
