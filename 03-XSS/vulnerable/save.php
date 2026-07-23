<?php

require 'db.php';

$name = $_POST['name'];
$comment = $_POST['comment'];

$sql = "INSERT INTO comments (name, comment) VALUES (?, ?)";

$stmt = $pdo->prepare($sql);

$stmt->execute([$name, $comment]);

header("Location: index.php");
exit;
