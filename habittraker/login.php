<?php
session_start();
$db = new SQLite3('database.db');

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'];
$password = $data['password'];

$stmt = $db->prepare("SELECT * FROM users WHERE username=:username");
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$result = $stmt->execute();
$row = $result->fetchArray(SQLITE3_ASSOC);

if($row && password_verify($password, $row['password'])){
    $_SESSION['user_id'] = $row['id'];
    echo json_encode(["success"=>true]);
} else {
    echo json_encode(["success"=>false]);
}
?>
