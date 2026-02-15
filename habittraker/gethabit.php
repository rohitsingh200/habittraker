<?php
session_start();
$db = new SQLite3('database.db');

$user_id = $_SESSION['user_id'];

$stmt = $db->prepare("SELECT * FROM habits WHERE user_id=:uid");
$stmt->bindValue(':uid', $user_id, SQLITE3_INTEGER);
$result = $stmt->execute();

$habits = [];
while($row = $result->fetchArray(SQLITE3_ASSOC)){
    $habits[] = $row;
}

echo json_encode($habits);
?>
