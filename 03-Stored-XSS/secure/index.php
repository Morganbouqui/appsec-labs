<?php
require 'db.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Stored XSS Lab</title>
</head>

<body>

<h2>Guestbook</h2>

<form action="save.php" method="POST">

    <p>
        Name:
        <br>
        <input type="text" name="name" required>
    </p>

    <p>
        Comment:
        <br>
        <textarea name="comment" rows="5" cols="40" required></textarea>
    </p>

    <button type="submit">
        Submit
    </button>

</form>

<hr>

<h2>Comments</h2>

<?php

$stmt = $pdo->query("SELECT * FROM comments ORDER BY id DESC");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

    echo "<hr>";

    echo "<strong>"
    . htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8')
    . "</strong><br>";

echo nl2br(
    htmlspecialchars(
        $row['comment'],
        ENT_QUOTES,
        'UTF-8'
    )
);

echo "<br>";

}
?>

</body>
</html>
