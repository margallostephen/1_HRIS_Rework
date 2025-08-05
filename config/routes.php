<?php
require_once CONFIG_PATH . 'db.php';

$result = $mysqli->query("SELECT ROLE_ID FROM role_tb");
$allRoles = array_column($result->fetch_all(MYSQLI_ASSOC), 'ROLE_ID');

$routes = [
    'auth' => [0],
    'dashboard' => [1, 2, 4],
    'employee/list' => [1, 2, 4],
    'employee/relation' => [1, 2, 4],
    'survey' => $allRoles,
    'error/403' => $allRoles,
    'error/404' => $allRoles,
    'allowed_roles' => [1, 2, 4]
];

return $routes;
