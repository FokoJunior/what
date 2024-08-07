<?php
// backend/index.php

include 'config/database.php';
include 'controllers/AuthController.php';
include 'controllers/UserController.php';
include 'controllers/ChatController.php';
include 'controllers/GroupController.php';

header('Content-Type: application/json');
$input = json_decode(file_get_contents('php://input'), true);

$authController = new AuthController($pdo);
$userController = new UserController($pdo);
$chatController = new ChatController($pdo);
$groupController = new GroupController($pdo);

$response = ['success' => false];

switch ($input['action']) {
    case 'register':
        if ($authController->register($input['username'], $input['password'])) {
            $response['success'] = true;
        }
        break;
    case 'login':
        $user = $authController->login($input['username'], $input['password']);
        if ($user) {
            $response['success'] = true;
            $response['user'] = $user; // Inclure les informations utilisateur
        }
        break;
    case 'sendMessage':
        if ($chatController->sendMessage($input['senderId'], $input['receiverId'], $input['message'])) {
            $response['success'] = true;
        }
        break;
    case 'createGroup':
        if ($groupController->createGroup($input['name'])) {
            $response['success'] = true;
        }
        break;
    case 'addUserToGroup':
        if ($groupController->addUserToGroup($input['groupId'], $input['userId'])) {
            $response['success'] = true;
        }
        break;
    case 'sendMessageToGroup':
        if ($groupController->sendMessageToGroup($input['groupId'], $input['senderId'], $input['message'])) {
            $response['success'] = true;
        }
        break;
    default:
        $response['message'] = 'Invalid action';
        break;
}

echo json_encode($response);
?>
