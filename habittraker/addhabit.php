<?php
session_start();
$db = new SQLite3('database.db');

$db->exec("CREATE TABLE IF NOT EXISTS habits (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    task TEXT,
    date TEXT
)");

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $_SESSION['user_id'];
$task = $data['task'];
$date = $data['date'];

$stmt = $db->prepare("INSERT INTO habits (user_id,task,date) VALUES (:uid,:task,:date)");
$stmt->bindValue(':uid', $user_id, SQLITE3_INTEGER);
$stmt->bindValue(':task', $task, SQLITE3_TEXT);
$stmt->bindValue(':date', $date, SQLITE3_TEXT);
$stmt->execute();

echo json_encode(["success"=>true]);
?>
