<?php
$db = new SQLite3('database.db');

$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT
)");

$data = json_decode(file_get_contents("php://input"), true);

$username = $data['username'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

$stmt = $db->prepare("INSERT INTO users (username,password) VALUES (:username,:password)");
$stmt->bindValue(':username', $username, SQLITE3_TEXT);
$stmt->bindValue(':password', $password, SQLITE3_TEXT);

$result = @$stmt->execute();

if($result) echo json_encode(["success"=>true]);
else echo json_encode(["success"=>false]);
?>
